<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdyenController extends Controller
{
  public function __construct() {
     $this->adyenClient = new \Adyen\Client();
     $this->adyenClient->setXApiKey(env('ADYEN_API_KEY', null));
     $this->adyenClient->setEnvironment(\Adyen\Environment::TEST);
  }

  public function getPaymentMethods(Request $request) {
    /*$validatedData = $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:persons,email',
        'job_role' => 'required'
    ]);*/

    $service = new \Adyen\Service\Checkout($this->adyenClient);

    $params = array(
      "merchantAccount" => "JamieAdyenTestECOM",
      "countryCode" => "NL",
      "channel" => "Web"
    );

    $result = $service->paymentMethods($params);
    var_dump($result);
  }
}
