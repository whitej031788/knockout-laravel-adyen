<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use \Nexmo\Client;

class GreggsController extends Controller
{
  public function generateAndSendLink(Request $request, \Nexmo\Client $nexmo) {
    $params = array(
      "amount" => $request->amount,
      "reference" => "GREGGS-" . $request->reference,
      "returnUrl" => $request->returnUrl,
      "description" => $request->description,
      "merchantAccount" => "JamieAdyenTestECOM",
      "countryCode" => "GB",
      "shopperReference" => $request->shopperReference,
      "shopperEmail" => $request->shopperEmail,
      "storePaymentMethod" => false
    );

    $result = $this->callAdyenCurl($params);

    /*$message = $nexmo->message()->send([
        'to' => $request->phoneNumber,
        'from' => 'GreggsClickCollect',
        'text' => "Please click the below to link to pay for your order:\n\n" . $result->url . " ||| "
    ]);*/

    return response()->json($result);
  }

    private function callAdyenCurl($params) {
      $fields_string = json_encode($params);

      $username = "ws_363464@Company.JamieAdyenTest";
      $password = "}+5k?72wIZSQ6n7Xks^t^3S--";
      $url = 'https://checkout-test.adyen.com/v52/paymentLinks';

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
      curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
      ));

      $result = json_decode(curl_exec($ch));

      return $result;
    }

    public function generateAndShowInvoice(Request $request) {
      $params = array(
        "amount" => $request->amount,
        "reference" => $request->reference,
        "description" => $request->description,
        "merchantAccount" => "JamieAdyenTestECOM",
        "countryCode" => "US",
        "shopperReference" => $request->shopperReference,
        "shopperEmail" => $request->shopperEmail
      );

      $result = $this->callAdyenCurl($params);

      $pdfhtml = '<!doctype html> <html> <head> <meta charset="utf-8"> <meta name="viewport" content="width=device-width, initial-scale=1"> <title>A simple, clean, and responsive HTML invoice template</title> <link rel="icon" href="/images/favicon.png" type="image/x-icon"> <style> body{ font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; text-align:center; color:#777; } body h1{ font-weight:300; margin-bottom:0px; padding-bottom:0px; color:#000; } body h3{ font-weight:300; margin-top:10px; margin-bottom:20px; font-style:italic; color:#555; } body a{ color:#06F; } .invoice-box{ max-width:800px; margin:auto; padding:30px; border:1px solid #eee; box-shadow:0 0 10px rgba(0, 0, 0, .15); font-size:16px; line-height:24px; font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; color:#555; } .invoice-box table{ width:100%; line-height:inherit; text-align:left; } .invoice-box table td{ padding:5px; vertical-align:top; } .invoice-box table tr td:nth-child(2){ text-align:right; } .invoice-box table tr.top table td{ padding-bottom:20px; } .invoice-box table tr.top table td.title{ font-size:45px; line-height:45px; color:#333; } .invoice-box table tr.information table td{ padding-bottom:40px; } .invoice-box table tr.heading td{ background:#eee; border-bottom:1px solid #ddd; font-weight:bold; } .invoice-box table tr.details td{ padding-bottom:20px; } .invoice-box table tr.item td{ border-bottom:1px solid #eee; } .invoice-box table tr.item.last td{ border-bottom:none; } .invoice-box table tr.total td:nth-child(2){ border-top:2px solid #eee; font-weight:bold; } @media only screen and (max-width: 600px) { .invoice-box table tr.top table td{ width:100%; display:block; text-align:center; } .invoice-box table tr.information table td{ width:100%; display:block; text-align:center; } } </style> </head> <body> <div class="invoice-box"> <table cellpadding="0" cellspacing="0"> <tr class="top"> <td colspan="2"> <table> <tr> <td> Invoice #: ' . $request->reference . '<br> Created: 29 June 2020<br> Due: 29 July 2020 </td> </tr> </table> </td> </tr> <tr class="information"> <td colspan="2"> <table> <tr> <td> <b>IP Centrum</b><br> Unit 9 & 10 Rosemary Court<br> Chadwick End<br> Solihull<br> B93 0BJ </td> <td> Jamie White LLC<br> Jamie White<br> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="412b2e292f012439202c312d246f222e2c">[email&#160;protected]</a> </td> </tr> </table> </td> </tr> <tr class="heading"> <td> Item </td> <td> Price </td> </tr> <tr class="item"> <td> Patent Renewal </td> <td> $1300.00 </td> </tr> <tr class="item"> <td> Administrative Fee </td> <td> $55.00 </td> </tr> <tr class="item last"> <td> Payment Method Fee </td> <td> $5.00 </td> </tr> <tr class="total"> <td></td> <td> Total: $1360.00 </td> </tr><tr class="total"> <td><a target="_blank" href="' . $result->url . '">Click here</a> to pay your invoice via our secure payment page</td> <td> </td> </tr> </table> </div> </body> </html>';

      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($pdfhtml)->setPaper('a4', 'landscape')->setWarnings(false)->save('invoice.pdf');
      return response()->file('invoice.pdf');
    }
}
