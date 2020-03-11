<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;

class AdyenController extends Controller
{
  public function __construct() {
    $this->adyenClient = new \Adyen\Client();
    $this->adyenClient->setXApiKey('AQEwhmfxLIzNbxNGw0m/n3Q5qf3VYopABJZrXHxTyEyujXLnN3P8LZwpAybFGzQ5dnT1EMFdWw2+5HzctViMSCJMYAc=-ZVuvWaNaFv5m/BktXaTMLvgclIBOr0TecHuSSdQeI5A=-k3a4zKNGsyqD9WJx');
    $this->adyenClient->setEnvironment(\Adyen\Environment::TEST);
  }

  public function getPaymentMethods(Request $request) {
    $validatedData = $request->validate([
        'merchantAccount' => 'required',
        'countryCode' => 'required',
        'channel' => 'required'
    ]);

    $service = new \Adyen\Service\Checkout($this->adyenClient);

    $params = array(
      "merchantAccount" => $request->merchantAccount,
      "countryCode" => $request->countryCode,
      "channel" => $request->channel
    );

    $result = $service->paymentMethods($params);
    return response()->json($result);
  }

  public function makePaymentSimple(Request $request) {
    $service = new \Adyen\Service\Checkout($this->adyenClient);

    $paymentMethod = $request->payData['paymentMethod'];

    $cacheKeyRedirect = "http://localhost:8000/normal-redirect/" . $request->shopperReference . "-" . $request->reference;

    $params = array(
      "amount" => $request->amount,
      "reference" => $request->reference,
      "countryCode" => $request->countryCode,
      "paymentMethod" => $paymentMethod,
      "channel" => $request->channel,
      "returnUrl" => $cacheKeyRedirect,
      "merchantAccount" => $request->merchantAccount,
      "shopperReference" => $request->shopperReference
    );

    if (array_key_exists('storePaymentMethod', $request->payData)) {
      $params['storePaymentMethod'] = $request->payData['storePaymentMethod'];
    }

    if (strpos($paymentMethod['type'], 'klarna') !== false) {
      $this->addKlarnaData($params);
    }

    //var_dump(json_encode($params));

    $result = $service->payments($params);

    if ($result['resultCode'] == 'RedirectShopper') {
      $cache = Cache::forever($request->shopperReference . '-' . $request->reference, $result['paymentData']);
    }

    // Check if further action is needed.
    return response()->json($result);
  }

  public function makePayment3DS2(Request $request) {
    $service = new \Adyen\Service\Checkout($this->adyenClient);

    $paymentMethod = $request->payData['paymentMethod'];
    if ($request->populateFakeAddress) {
      $billingAddress = $this->fakeAddressArray();
    } else {
      $billingAddress = $request->payData['billingAddress'];
    }
    $browserInfo = $request->payData['browserInfo'];

    $cacheKeyRedirect = "http://localhost:8000/threeds-redirect/" . $request->shopperReference . "-" . $request->reference;

    $params = array(
      "amount" => $request->amount,
      "reference" => $request->reference,
      "paymentMethod" => $paymentMethod,
      "returnUrl" => $cacheKeyRedirect,
      "merchantAccount" => $request->merchantAccount,
      "channel" => $request->channel,
      "origin" => $request->origin,
      "shopperIP" => $_SERVER['REMOTE_ADDR'],
      "billingAddress" => $billingAddress,
      "browserInfo" => $browserInfo,
      "shopperReference" => $request->shopperReference,
      "additionalData" => [
        "allow3DS2" => true
      ]
    );

    if (array_key_exists('storePaymentMethod', $request->payData)) {
      $params['storePaymentMethod'] = $request->payData['storePaymentMethod'];
    }

    $result = $service->payments($params);

    if ($result['resultCode'] == 'RedirectShopper') {
      $cache = Cache::forever($request->shopperReference . '-' . $request->reference, $result['paymentData']);
    }
    // Check if further action is needed.
    return response()->json($result);
  }

  public function paymentDetails(Request $request) {
    $service = new \Adyen\Service\Checkout($this->adyenClient);

    $params = $request->data;
    // Data object passed from onAdditionalDetails event of the front end parsed from JSON to an array

    $result = $service->paymentsDetails($params);

    return response()->json($result);
  }

  public function threeDSRedirect(Request $request, $payRef) {
    $value = Cache::store('file')->get($payRef);
    $response = $this->redirPayDet($value, ['MD' => $request->MD, 'PaRes' => $request->PaRes]);

    var_dump($response);
  }

  public function normalRedirect($payRef) {
    $value = Cache::store('file')->get($payRef);
    $input = Input::all();
    $response = $this->redirPayDet($value, $input);

    var_dump($response);
  }

  public function classicPayment(Request $request) {
    $url = 'https://pal-test.adyen.com/pal/servlet/Payment/v51/authorise';
    $fields = array(
      'reference' => '2378rt3gf4b3',
      'merchantAccount' => 'JamieAdyenTestECOM',
      'amount' => array(
        'value' => 15000,
        'currency' => 'USD'
      ),
      'additionalData' => array(
        'card.encrypted.json' => $request->encData
      )
    );

    //JSON-ify the data for the POST
    $fields_string = json_encode($fields);

    $username = "ws_363464@Company.JamieAdyenTest";
    $password = "}+5k?72wIZSQ6n7Xks^t^3S--";

    //open connection
    $ch = curl_init();
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json'
    ));

    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    echo $result;
  }

  private function fakeAddressArray() {
    return [
      'street' => 'Valley Brook Way',
      'houseNumberOrName' => '2316',
      'postalCode' => '30319',
      'city' => 'Atlanta',
      'stateOrProvince' => 'GA',
      'country' => 'US'
    ];
  }

  private function fakeShopperName() {
    return [
      'firstName' => 'Main St',
      'gender' => 'male',
      'lastName' => 'N1'
    ];
  }

  private function fakeKlarnaLineItems($numItems) {
    $retArr = array();
    for ($x = 0; $x < $numItems; $x++) {
      $tmpArr = array(
        'quantity' => $x + 1,
        'amountExcludingTax' => '331',
        'taxPercentage' => '2100',
        'description' => 'Test Klarna',
        'id' => $x + 100,
        'taxAmount' => '69',
        'amountIncludingTax' => '400'
      );
      array_push($retArr, $tmpArr);
    }
    return $retArr;
  }

  private function redirPayDet($paymentData, $details) {
    $service = new \Adyen\Service\Checkout($this->adyenClient);

    $params = array(
      'paymentData' => $paymentData,
      'details' => $details
    );

    $result = $service->paymentsDetails($params);

    return $result;
  }

  private function addKlarnaData(&$params) {
    $params['shopperLocale'] = 'en_US';
    $params['shopperEmail'] = 'jamie@adyen.com';
    $params['billingAddress'] = $this->fakeAddressArray();
    $params['lineItems'] = $this->fakeKlarnaLineItems(2);
    $params['shopperName'] = $this->fakeShopperName();
  }
}
