<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdyenController extends Controller
{
  public function __construct() {
    $this->adyenClient = new \Adyen\Client();
    $this->adyenClient->setXApiKey(\Config::get('adyen.apiKey'));
    $this->adyenClient->setEnvironment(\Adyen\Environment::TEST);
  }

  public function getPaymentMethods(Request $request) {
    $checkoutService = new \Adyen\Service\Checkout($this->adyenClient);

    $validatedData = $request->validate([
        'merchantAccount' => 'required',
        'countryCode' => 'required',
        'channel' => 'required'
    ]);

    $params = array(
      "merchantAccount" => $request->merchantAccount,
      "countryCode" => $request->countryCode,
      "channel" => $request->channel,
      'shopperReference' => $request->shopperReference,
      // "blockedPaymentMethods" => array("visa","mc","amex","cup","jcb","discover","girocard")
    );

    if ($request->has("amount")) {
      $params['amount'] = $request->amount;
    }

    $result = $this->makeAdyenRequest("paymentMethods", $params, false, $checkoutService);

    return response()->json($result);
  }

  public function doCostEstimate(Request $request) {
    $params = $request->all();

    $url = "https://pal-test.adyen.com/pal/servlet/BinLookup/v50/getCostEstimate";

    $result = $this->makeAdyenRequest($url, $params, true, false);

    return response()->json($result);
  }

  public function submitDonation(Request $request) {
    $params = $request->all();

    $url = "https://pal-test.adyen.com/pal/servlet/Payment/v64/donate";

    $result = $this->makeAdyenRequest($url, $params, true, false);

    return response()->json($result);
  }

  public function makePaymentSimple(Request $request) {
    $output = new \Symfony\Component\Console\Output\ConsoleOutput();

    $checkoutService = new \Adyen\Service\Checkout($this->adyenClient);

    // iOS specific!
    if ($request->has("payData")) {
      $paymentMethod = $request->payData['paymentMethod'];
    } else {
      $paymentMethod = $request->paymentMethod;
    }

    $cacheKeyRedirect = "http://localhost:8000/normal-redirect/" . $request->shopperReference . "-" . $request->reference;

    // For iOS, amount is a delimited stringify
    if (is_string($request->amount)) {
      $newAmount = explode(",", $request->amount);
      $newAmount = array(
        "value" => $newAmount[0],
        "currency" => $newAmount[1]
      );
    } else {
      $newAmount = $request->amount;
    }

    $params = array(
      "amount" => $newAmount,
      "reference" => $request->reference,
      "countryCode" => $request->countryCode,
      "paymentMethod" => $paymentMethod,
      "channel" => $request->channel,
      "shopperEmail" => 'jamie.white@adyen.com',
      "returnUrl" => $cacheKeyRedirect,
      "merchantAccount" => $request->merchantAccount,
      "shopperReference" => $request->shopperReference,
      "shopperInteraction" => "Ecommerce",
      "billingAddress" => $this->fakeAddressArray(),
      "deliveryAddress" => $this->fakeAddressArray(),
      "captureDelayHours" => 2
    );

    // Lets check for splits!
    if ($request->merchantAccount == 'JamieAdyenTestMP') {
      // Only split if we have amount and account
      if ($request->has("splitAmount") && $request->has("accountCodeSplit")) {
        $params['splits'] = array (
          array (
            'amount' => array (
              'value' => $request->splitAmount,
            ),
            'type' => 'MarketPlace',
            'account' => $request->accountCodeSplit,
            'reference' => '6124145',
            'description' => 'Porcelain Doll: Eliza (20cm)',
          ),
          array (
            'amount' => array (
              'value' => intval($request->amount["value"]) - intval($request->splitAmount),
            ),
            'type' => 'Commission',
            'reference' => '6124146',
          ),
        );
      }
    }

    if ($request->enableL2Data) {
      $this->addL2Data($params);
    }

    // Did the front end specify a recur process model?
    if ($request->has("recurringProcessingModel")) {
      $params['recurringProcessingModel'] = $request->recurringProcessingModel;
    }

    if (strtolower($params["channel"]) == "web" && array_key_exists('storePaymentMethod', $request->payData)) {
      $params['storePaymentMethod'] = $request->payData['storePaymentMethod'];
    }

    if (isset($paymentMethod['type']) && (strpos($paymentMethod['type'], 'klarna') !== false || strpos($paymentMethod['type'], 'clearpay') !== false)) {
      $this->addKlarnaData($params);
    }

    // one click purchase, set ContAuth and CardOnFile
    if (isset($paymentMethod['storedPaymentMethodId']) && is_numeric($paymentMethod['storedPaymentMethodId'])) {
      $params['shopperInteraction'] = "ContAuth";
      $params['recurringProcessingModel'] = "CardOnFile";
    }

    if (isset($paymentMethod['type']) && strpos($paymentMethod['type'], 'paypal') !== false) {
      $params['shopperName'] = $this->fakeShopperName();
    }

    if (isset($paymentMethod['type']) && strpos($paymentMethod['type'], 'ideal') !== false) {
      $params['storePaymentMethod'] = true;
    }

    // konbini
    if (isset($paymentMethod['type']) && strpos($paymentMethod['type'], 'econtext_stores') !== false) {
      $params['shopperName'] = $this->fakeShopperName();
      $params['telephoneNumber'] = $paymentMethod['telephoneNumber'];
      $params['shopperLocale'] = 'ja-JP';
    }

    $result = $this->makeAdyenRequest("payments", $params, false, $checkoutService);

    if (array_key_exists("channel", $params) && strtolower($params["channel"]) != "web") {
      if ($result['resultCode'] == 'RedirectShopper') {
        $cache = Cache::forever($request->shopperReference . '-' . $request->reference, $result['paymentData']);
        $result = $result['action'];
      }
    } else {
      if ($result['response']['resultCode'] == 'RedirectShopper') {
        $cache = Cache::forever($request->shopperReference . '-' . $request->reference, $result['response']['paymentData']);
      }
    }

    $output->writeln(json_encode($result));

    return response()->json($result);
  }

  public function makePayment3DS2(Request $request) {
    $checkoutService = new \Adyen\Service\Checkout($this->adyenClient);

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
      "paymentMethod" => $paymentMethod,
      "reference" => $request->reference,
      "merchantAccount" => $request->merchantAccount,
      "shopperReference" => $request->shopperReference,
      "additionalData" => array(
        "allow3DS2" => true
      ),
      "shopperEmail" => 'jamie.white@adyen.com',
      "telephoneNumber" => '1234567890',
      "returnUrl" => $cacheKeyRedirect,
      "countryCode" => $request->countryCode,
      "channel" => $request->channel,
      "shopperInteraction" => "Ecommerce",
      "origin" => $request->origin,
      "shopperIP" => $_SERVER['REMOTE_ADDR'],
      "billingAddress" => $billingAddress,
      "browserInfo" => $browserInfo,
      "threeDSAuthenticationOnly" => $request->threeDSAuthenticationOnly
    );

    if (array_key_exists('storePaymentMethod', $request->payData)) {
      $params['storePaymentMethod'] = $request->payData['storePaymentMethod'];
    }

    if ($request->has("recurringProcessingModel")) {
      $params['recurringProcessingModel'] = $request->recurringProcessingModel;
    }

    $result = $this->makeAdyenRequest("payments", $params, false, $checkoutService);

    if ($result['response']['resultCode'] == 'RedirectShopper') {
      $cache = Cache::forever($request->shopperReference . '-' . $request->reference, $result['response']['paymentData']);
    }
    // Check if further action is needed.
    return response()->json($result);
  }

  public function paymentDetails(Request $request) {
    $checkoutService = new \Adyen\Service\Checkout($this->adyenClient);

    $params = $request->data;
    // Data object passed from onAdditionalDetails event of the front end parsed from JSON to an array

    $result = $this->makeAdyenRequest("paymentsDetails", $params, false, $checkoutService);

    return response()->json($result);
  }

  public function capturePayment(Request $request) {
    $modificationService = new \Adyen\Service\Modification($this->adyenClient);

    $params = $request->all();
    // Data object passed from onAdditionalDetails event of the front end parsed from JSON to an array

    $result = $this->makeAdyenRequest("capture", $params, false, $modificationService);

    return response()->json($result);
  }

  // DEPRECATED
  public function signHppHmac(Request $request) {
    //JSON-ify the data for the POST
    $pairs = $request->all();
    // Test Klarna
    // $pairs["openinvoicedata.numberOfLines"] = "2";
    // $pairs["openinvoicedata.line1.numberOfItems"] = "1";
    // $pairs["openinvoicedata.line1.itemAmount"] = "3500";
    // $pairs["openinvoicedata.line1.currencyCode"] = "GBP";
    // $pairs["openinvoicedata.line1.itemVatAmount"] = "665";
    // $pairs["openinvoicedata.line1.itemVatPercentage"] = "1900";
    // $pairs["openinvoicedata.line1.vatCategory"] = "High";
    // $pairs["openinvoicedata.line1.description"] = "Description 1";
    // $pairs["openinvoicedata.line2.numberOfItems"] = "1";
    // $pairs["openinvoicedata.line2.itemAmount"] = "2100";
    // $pairs["openinvoicedata.line2.currencyCode"] = "GBP";
    // $pairs["openinvoicedata.line2.itemVatAmount"] = "399";
    // $pairs["openinvoicedata.line2.itemVatPercentage"] = "1900";
    // $pairs["openinvoicedata.line2.vatCategory"] = "Low";
    // $pairs["openinvoicedata.line2.description"] = "Description 2";


    $HMAC_KEY = "70612EFE64ADF31F3468331815ADDE07FD5A31CF09E54EE50845C1D28ECA980D";
    $escapedPairs = array();

    ksort($pairs, SORT_STRING);

    foreach ($pairs as $key => $value) {
      $escapedPairs[$key] = str_replace(':','\\:', str_replace('\\', '\\\\', $value));
    }

    $signingString = implode(":", array_merge(array_keys($escapedPairs), array_values($escapedPairs)));

    $binaryHmacKey = pack("H*" , $HMAC_KEY);

    $binaryHmac = hash_hmac('sha256', $signingString, $binaryHmacKey, true);

    $signature = base64_encode($binaryHmac);

    return response()->json($signature);
  }

  public function threeDSRedirect(Request $request, $payRef) {
    $value = Cache::store('file')->get($payRef);
    //exit();
    // CUSTOM PAYUZA code
    // if (isset($request->PayUReference) && $request->PayUReference) {
    //   $response = $this->redirPayDet($value, ['MD' => $request->PayUReference, 'PaRes' => $request->PayUReference]);
    // } else {
      $response = $this->redirPayDet($value, ['MD' => $request->MD, 'PaRes' => $request->PaRes]);
    // }

    return view('redirect-page', ['serverObject' => json_encode($response)]);
  }

  public function normalRedirect(Request $request, $payRef) {
    // 12345 is a cheeky way to identify PayPal ECS; we don't need payment data for it, its classic API
    if ($payRef == "12345") {
      $postback = $request->all();

      $url = 'https://pal-test.adyen.com/pal/servlet/Payment/v52/authorise';

      $params = array(
        'reference' => '2378rt3gf4b3',
        'merchantAccount' => 'JamieAdyenTestECOM',
        'amount' => array(
          'value' => 15000,
          'currency' => 'GBP'
        ),
        'additionalData' => array(
          'payment.token' => $postback["payment_token"]
        ),
        "selectedBrand" => "paypal_ecs",
        "shopperEmail" => 'jamie.white@adyen.com',
        "shopperIP" => $_SERVER['REMOTE_ADDR'],
        "browserInfo" => array(
          "userAgent" => "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9) Gecko/2008052912 Firefox/3.0",
          "acceptHeader" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
        ),
        "countryCode" => "GB"
      );

      $result = $this->makeAdyenRequest($url, $params, true, false);

      $viewObj = array(
        "method" => "paypal_ecs",
        "postback" => $postback,
        "request" => $result["request"],
        "response" => $result["response"]
      );

      return view('redirect-page', ['serverObject' => json_encode($viewObj)]);
    } else {
      $value = Cache::store('file')->get($payRef);
      $input = Input::all();
      $response = $this->redirPayDet($value, $input);

      return view('redirect-page', ['serverObject' => json_encode($response)]);
    }
  }

  public function classicPayment(Request $request) {
    $url = 'https://pal-test.adyen.com/pal/servlet/Payment/v52/authorise';

    $billingAddress = $this->fakeAddressArray();

    $params = array(
      'reference' => '2378rt3gf4b3',
      'merchantAccount' => 'JamieAdyenTestECOM',
      'amount' => array(
        'value' => 15000,
        'currency' => 'ZAR'
      ),
      'additionalData' => array(
        'card.encrypted.json' => $request->encData,
        "customMpiWrapper" => true
      ),
      "shopperEmail" => 'jamie.white@adyen.com',
      "shopperIP" => $_SERVER['REMOTE_ADDR'],
      "browserInfo" => array(
        "userAgent" => "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9) Gecko/2008052912 Firefox/3.0",
        "acceptHeader" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
      ),
      "countryCode" => "GB",
      "billingAddress" => $billingAddress
    );

    $result = $this->makeAdyenRequest($url, $params, true, false);

    return response()->json($result);
  }

  public function payGiftCard(Request $request) {
    $url = 'https://pal-test.adyen.com/pal/servlet/Payment/v51/authorise';

    $params = array(
      'reference' => $request->reference,
      'merchantAccount' => $request->merchantAccount,
      'selectedBrand' => $request->selectedBrand,
      'amount' => $request->amount,
      'card' => $request->card
    );

    $result = $this->makeAdyenRequest($url, $params, true, false);

    return response()->json($result);
  }

  public function getApplePaySession(Request $request) {
    // This is the server side endpoint that gets called from the onValidateMerchant() JS callback
    // The session is fetched directly from Apple, and then passed back to the client to render the Apple Pay Sheet
    // https://developer.apple.com/documentation/apple_pay_on_the_web/applepaysession/1778021-onvalidatemerchant

    // onValidateMerchant() provides validationURL, which should be the only thing passed from the browser to this server side Endpoint
    // This is where we will make our API call to for the session
    $theUrl = $request->sessionUrl;

    // This should be the domain Apple Pay is running on, and it needs to be validated with Apple and SSL secured
    // https://docs.adyen.com/payment-methods/apple-pay/enable-apple-pay#register-merchant-domain
    $appleValidatedDomain = "ec2-3-10-207-85.eu-west-2.compute.amazonaws.com";

    // POST body
    // $fields_string = json_encode(array(
    //   'merchantIdentifier' => "merchant.com.adyen.JamieAdyenTestECOM.test",
    //   'displayName' => "Jamie's ApplePay Store",
    //   'initiative' => "web",
    //   'initiativeContext' => $appleValidatedDomain
    // ));
    $fields_string = json_encode(array(
      'merchantIdentifier' => "merchant.com.adyen.MrAccount123ECOM.test",
      'displayName' => "Rugby League World Cup England 2021",
      'initiative' => "web",
      'initiativeContext' => "uat.tickets.rlwc2021.com"
    ));

    //open cURL connection
    $ch = curl_init();
    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $theUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json'
    ));

    // This is how Apple requires authenticating this API call; you must create a merchant identity certificate
    // Follow steps here https://docs.adyen.com/payment-methods/apple-pay/enable-apple-pay#create-merchant-identity-certificate
    // Uploaded certificate to your physical web server, and use it to sign your HTTP request
    curl_setopt($ch, CURLOPT_SSLCERT, Storage::path('tm-pay-cert.pem')); // physical path to .pem file

    //execute post request
    $result = json_decode(curl_exec($ch));

    // Now we return this Apple Session data to the browser, and onValidateMerchant() will need to resolve() with this session data
    return response()->json($result);
  }

  private function fakeAddressArray() {
    return [
      "city" => "London",
      "country" => "GB",
      "houseNumberOrName" => "",
      "postalCode" => "EC1V 9ND",
      "street" => "165 Old Street"
    ];
  }

  private function fakeShopperName() {
    return [
      'firstName' => 'Jamie',
      'gender' => 'male',
      'lastName' => 'White'
    ];
  }

  private function fakeKlarnaLineItems($numItems) {
    $retArr = array();
    for ($x = 0; $x < $numItems; $x++) {
      $tmpArr = array(
        'quantity' => 3,
        'amountExcludingTax' => '500',
        'taxPercentage' => '2000',
        'description' => 'Gold Vermeil Fine Chain 24"/61cm with adjuster',
        'id' => $x + 100,
        'taxAmount' => (500 * 0.2),
        'amountIncludingTax' => '600'
      );
      array_push($retArr, $tmpArr);
    }

    return $retArr;
  }

  private function redirPayDet($paymentData, $details) {
    $checkoutService = new \Adyen\Service\Checkout($this->adyenClient);

    $params = array(
      'paymentData' => $paymentData,
      'details' => $details,
      'threeDSAuthenticationOnly' => false
    );

    $result = $this->makeAdyenRequest("paymentsDetails", $params, false, $checkoutService);

    return $result;
  }

  private function addKlarnaData(&$params) {
    $params['shopperLocale'] = 'en_US';
    $params['shopperEmail'] = 'jamie.white@adyen.com';
    //$params['telephoneNumber'] = '1234567890';
    $params['dateOfBirth'] = '2000-12-01';
    $params['billingAddress'] = $this->fakeAddressArray();
    $params['lineItems'] = $this->fakeKlarnaLineItems(1);
    $params['shopperName'] = $this->fakeShopperName();
  }

  private function addL2Data(&$params) {
    // Only create if doesn't exist, otherwise we will overwrite it
    if (!array_key_exists('additionalData', $params)) {
      $params['additionalData'] = array();
    }

    $params['additionalData']["enhancedSchemeData.totalTaxAmount"] = "24000";
    $params['additionalData']["enhancedSchemeData.customerReference"] = "101";
    $params['additionalData']["enhancedSchemeData.freightAmount"] = "300";
    $params['additionalData']["enhancedSchemeData.destinationStateProvinceCode"] = "NYC";
    $params['additionalData']["enhancedSchemeData.shipFromPostalCode"] = "1082GM";
    $params['additionalData']["enhancedSchemeData.orderDate"] = "101216";
    $params['additionalData']["enhancedSchemeData.destinationPostalCode"] = "1082GM";
    $params['additionalData']["enhancedSchemeData.destinationCountryCode"] = "NLD";
    $params['additionalData']["enhancedSchemeData.dutyAmount"] = "500";
    $params['additionalData']["enhancedSchemeData.itemDetailLine1.description"] = "T15 Test products 1";
    $params['additionalData']["enhancedSchemeData.itemDetailLine1.productCode"] = "TEST120";
    $params['additionalData']["enhancedSchemeData.itemDetailLine1.commodityCode"] = "COMMCODE1";
    $params['additionalData']["enhancedSchemeData.itemDetailLine1.quantity"] = "5";
    $params['additionalData']["enhancedSchemeData.itemDetailLine1.unitOfMeasure"] = "m";
    $params['additionalData']["enhancedSchemeData.itemDetailLine1.unitPrice"] = "1000";
    $params['additionalData']["enhancedSchemeData.itemDetailLine1.discount"] = "60";
    $params['additionalData']["enhancedSchemeData.itemDetailLine1.totalAmount"] = "4940";
    $params['additionalData']["enhancedSchemeData.itemDetailLine2.description"] = "T15 Test products 2";
    $params['additionalData']["enhancedSchemeData.itemDetailLine2.productCode"] = "TEST120";
    $params['additionalData']["enhancedSchemeData.itemDetailLine2.commodityCode"] = "COMMCODE2";
    $params['additionalData']["enhancedSchemeData.itemDetailLine2.quantity"] = "5";
    $params['additionalData']["enhancedSchemeData.itemDetailLine2.unitOfMeasure"] = "m";
    $params['additionalData']["enhancedSchemeData.itemDetailLine2.unitPrice"] = "1000";
    $params['additionalData']["enhancedSchemeData.itemDetailLine2.discount"] = "60";
    $params['additionalData']["enhancedSchemeData.itemDetailLine2.totalAmount"] = "4940";
    $params['additionalData']["enhancedSchemeData.itemDetailLine3.description"] = "T15 Test products 3";
    $params['additionalData']["enhancedSchemeData.itemDetailLine3.quantity"] = "5";
    $params['additionalData']["enhancedSchemeData.itemDetailLine3.productCode"] = "TEST120";
    $params['additionalData']["enhancedSchemeData.itemDetailLine3.commodityCode"] = "COMMCODE3";
    $params['additionalData']["enhancedSchemeData.itemDetailLine3.unitOfMeasure"] = "m";
    $params['additionalData']["enhancedSchemeData.itemDetailLine3.unitPrice"] = "1000";
    $params['additionalData']["enhancedSchemeData.itemDetailLine3.discount"] = "60";
    $params['additionalData']["enhancedSchemeData.itemDetailLine3.totalAmount"] = "4940";
  }

  private function makeAdyenRequest($methodOrUrl, $params, $isClassic, $service) {
    $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    $output->writeln(json_encode($params));
    if (!$isClassic) {
      try {
        $result = $service->$methodOrUrl($params);
        $output->writeln(json_encode($result));
      } catch (Exception $e) {
        $output->writeln(json_encode($e));
      }
    } else {
      //JSON-ify the data for the POST
      $fields_string = json_encode($params);
      //Basic auth user
      $username = \Config::get('adyen.username');
      $password = \Config::get('adyen.password');

      //open connection
      $ch = curl_init();
      //set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $methodOrUrl);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
      curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
      ));

      //execute post
      $result = json_decode(curl_exec($ch));
    }

    if (array_key_exists("channel", $params) && strtolower($params["channel"]) != "web") {
      // For app channels, just return raw result data
      return $result;
    } else {
      //  For web channel, return the helpful POSTMAN style data
      return array(
        "method" => $methodOrUrl,
        "request" => $params,
        "response" => $result,
      );
    }
  }

  // MARKETPLACE FUNCTIONS
  private function makeMPRequest($methodOrUrl, $params) {
    //JSON-ify the data for the POST
    $fields_string = json_encode($params);
    //Basic auth user
    $username = "ws_129289@MarketPlace.JamieAdyenTestMP";
    $password = "}U_C;YNIyJ%QH5.2PZ}Y*mhCQ";

    //open connection
    $ch = curl_init();
    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $methodOrUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'x-api-key: '
      //'x-api-key: AQE2hmfxLojHaR1Lw0exgG89s9SXSYhIQ7lLVWxT53yym2h/m9RiPfZlpfG4Kc/rWW9csW3S0P+JEMFdWw2+5HzctViMSCJMYAc=-WijLGVB1SJ83xyKHxEc9wNq8wfahobqOm84oULLILHM=-z*sA9t^y_q~_>Y(8'
    ));

    //execute post
    $result = json_decode(curl_exec($ch));

    return array(
      "method" => $methodOrUrl,
      "request" => $params,
      "response" => $result,
    );
  }

  public function createAccountHolder(Request $request) {
    $params = $request->all();

    $result = $this->makeMPRequest("https://cal-test.adyen.com/cal/services/Account/v6/createAccountHolder", $params);

    return response()->json($result);
  }

  public function createNotificationConfiguration(Request $request) {
    $params = $request->all();

    $result = $this->makeMPRequest("https://cal-test.adyen.com/cal/services/Notification/v6/createNotificationConfiguration", $params);

    return response()->json($result);
  }

  public function uploadDocument(Request $request) {
    $params = $request->all();

    $result = $this->makeMPRequest("https://cal-test.adyen.com/cal/services/Account/v6/uploadDocument", $params);

    return response()->json($result);
  }

  public function getAccountHolder(Request $request) {
    $params = $request->all();

    $result = $this->makeMPRequest("https://cal-test.adyen.com/cal/services/Account/v6/getAccountHolder", $params);

    return response()->json($result);
  }

  public function updateAccountHolder(Request $request) {
    $params = $request->all();

    $result = $this->makeMPRequest("https://cal-test.adyen.com/cal/services/Account/v6/updateAccountHolder", $params);

    return response()->json($result);
  }

  public function checkAccountHolder(Request $request) {
    $params = $request->all();

    $result = $this->makeMPRequest("https://cal-test.adyen.com/cal/services/Account/v6/checkAccountHolder", $params);

    return response()->json($result);
  }

  public function getOnboardingUrl(Request $request) {
    $params = $request->all();

    $result = $this->makeMPRequest("https://cal-test.adyen.com/cal/services/Hop/v6/getOnboardingUrl", $params);

    return response()->json($result);
  }
  // END MARKETPLACE FUNCTIONS
}
