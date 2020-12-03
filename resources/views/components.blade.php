@extends('layouts.main')

@section('content')
  <div class="row m-2">
    <div class="col-md-12 text-center navy-background" style="color: white;">
      <h2 class="text-center mb-2" style="text-decoration:underline;">Adyen Drop-in / Components Integration</h2>
      <div class="col-md-6 offset-md-3 text-center">
        <p class="text-center mb-2">This is a technical demonstration of the Adyen payment integration. It includes the following steps of the integration process:</h2>
          <ol style="color: white;text-align: left;">
            <li>Fetching the available payment methods by currency, country, basket value, etc.</li>
            <li>Displaying available payment methods using the all-in-one Adyen SDK</li>
            <li>Handling any required redirects, popups, or extra information depending on payment method</li>
            <li>Completing the payment</li>
          </ol>
      </div>
    </div>
    <div class="col-md-4 green-back p-3">
      <h4>Method / URL</h4>
      <div class="col-md-12 p-0" data-bind="text: apiUrlOrMethod"></div>
      <h4>Request</h4>
      <div class="col-md-12 back-white">
        <pre data-bind="html: apiRequest"></pre>
      </div>
      <h4>Response</h4>
      <div class="col-md-12 back-white">
        <pre data-bind="html: apiResponse"></pre>
      </div>
    </div>
    <div class="col-md-4 p-2">
      <div class="row mb-4">
        <div class="col-md-6">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="enable3DS2" data-bind="value: enable3DS2, checked: enable3DS2">
            <label data-toggle="tooltip" data-placement="right" title="Should we send 3DS data to the /payments endpoint?" class="form-check-label" for="enable3DS2">Enable 3DS</label>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="enableL2Data" data-bind="value: enableL2Data, checked: enableL2Data">
            <label data-toggle="tooltip" data-placement="right" title="Populate level 2/3 data?" class="form-check-label" for="enableL2Data">Send L2/3 Data</label>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="populateFakeAddress" data-bind="value: populateFakeAddress, checked: populateFakeAddress">
            <label data-toggle="tooltip" data-placement="right" title="Populate fake address for quick tests?" class="form-check-label" for="populateFakeAddress">Fake Address</label>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="showPayButton" data-bind="value: showPayButton, checked: showPayButton">
            <label data-toggle="tooltip" data-placement="right" title="Should I show the pay button" class="form-check-label" for="showPayButton">Show Pay Button</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="enableStoreDetails" data-bind="value: enableStoreDetails, checked: enableStoreDetails">
            <label data-toggle="tooltip" data-placement="right" title="Should we tokenize the card for future purchases?" class="form-check-label" for="enableStoreDetails">Enable Store Info</label>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="threeDSAuthenticationOnly" data-bind="value: threeDSAuthenticationOnly, checked: threeDSAuthenticationOnly">
            <label data-toggle="tooltip" data-placement="right" title="Do 3DS authentication only?" class="form-check-label" for="threeDSAuthenticationOnly">3DS Auth Only</label>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="tokenizeOnly" data-bind="value: tokenizeOnly, checked: tokenizeOnly, event: { change: changeTokenOnly}">
            <label data-toggle="tooltip" data-placement="right" title="Zero auth for tokenize?" class="form-check-label" for="tokenizeOnly">Tokenize Only (zero auth)</label>
          </div>
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" data-bind="value: dropIn, checked: dropIn" id="dropInSwitch">
            <label class="custom-control-label" for="dropInSwitch" data-bind="visible: dropIn()">Drop-In</label>
            <label class="custom-control-label" for="dropInSwitch" data-bind="visible: !dropIn()">Components</label>
          </div>
        </div>
      </div>
      <div data-bind="visible: !tokenizeOnly()">
        @component('layouts.payment-methods-form')
        @endcomponent
      </div>
      <div data-bind="visible: tokenizeOnly()" class="p-3" style="background-color: white;">
        <p>Your product will not be available for shipment until it's scheduled release date February 1st, 2021.</p>
        <p>In order to secure your pre-order, please enter your card details to the right.</p>
        <p>Your card will not be charged until we ship you your goods.</p>
      </div>
    </div>
    <div class="col-md-4 p-3" data-bind="visible: havePaymentMethods()">
      <div class="col-md-12">
        <table class="table" style="background-color: white;">
          <tbody data-bind="foreach: diffCardOptions">
            <tr>
              <td data-bind="text: label"></td>
              <td data-bind="text: number"></td>
              <td data-bind="text: expire"></td>
              <td data-bind="text: cvc"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-12" style="display: none;">
        <label>Recurring Processing Model</label>
        <select class="form-control mb-2" style="border: 2px solid white;" data-bind="options: recurringProcessingModelOptions, value: recurringProcessingModel">
        </select>
      </div>
      <div class="form-group" data-bind="css: {'d-none': paymentMethodForm.merchantAccount() != 'JamieAdyenTestMP'}">
        <label for="accountCodeSplit">Account Code Split:</label>
        <input type="text" class="form-control" id="accountCodeSplit" placeholder="Enter account code" data-bind="value: accountCodeSplit">
      </div>
      <div class="form-group" data-bind="css: {'d-none': paymentMethodForm.merchantAccount() != 'JamieAdyenTestMP'}">
        <label for="splitAmount">Split Amount:</label>
        <input type="number" class="form-control" id="splitAmount" placeholder="Enter split amount" data-bind="value: splitAmount">
      </div>
      <div class="col-md-12">
        <pre class="navy-background" style="color: white; padding: 5px; border-radius: 5px;">const checkout = new AdyenCheckout(configuration);
const dropin = checkout.create('dropin').mount('#dropin-container');
</pre>
      </div>
      <div id='donation-container'></div>
      <div id="dropin-container" class="col-md-12"></div>
      {{-- <div id="payueft-container" class="col-md-12">
        <button value="PayUZA EFT" data-bind="click: payUZAEFT">PayUZA EFT</button>
      </div> --}}
      <div id="card-container" class="col-md-12"></div>
      <div id="klarna-container" class="col-md-12"></div>
      <div id="alipay-container" class="col-md-12"></div>
      <div id="action-container" class="col-md-12"></div>
      <div id="sepadirectdebit-container" class="col-md-12"></div>
      <div id="interac-container" class="col-md-12"></div>
      {{-- <h3>Givex Component</h3>
      <div id="givex-container" class="col-md-12" style="border: 1px solid white; background-color: grey; padding: 10px;"></div> --}}
      <div id="stored-card" class="col-md-12"></div>
      <div id="paypal-container" class="col-md-12"></div>
      <div id="applepay-container" class="col-md-12"></div>
      <div id="ideal-container" class="col-md-12"></div>
      <div id="jpseveneleven-container"></div>
      <div id="konbini-container"></div>
      <div class="col-md-12 mt-1 mb-1" data-bind="visible: !showPayButton()">
        <button type="button" class="btn btn-secondary" data-bind="click: hidePaymentSubmit">Pay Now</button>
      </div>
      <div class="col-md-12 mb-3 mt-3" data-bind="visible: canCapture()">
        <div class="form-group">
          <label for="pspReference">Psp Reference:</label>
          <input type="text" name="pspReference" class="form-control" id="pspReference" placeholder="Enter PSP Reference" data-bind="value: pspReference">
          <button type="button" class="btn btn-secondary mt-2" data-bind="click: submitCapture">Capture Now</button>
        </div>
      </div>
    </div>
    <div id="klarna-payments-container" class="col-md-12"></div>
  </div>
  <div class="modal" tabindex="-1" role="dialog" id="redirectModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Redirect Action</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Adyen has returned a redirect result to you. This can happen for 3DS1, or any local payment method that requires a redirect, such as Klarna, Ideal, Sofort, etc.</p>
          <p>The Adyen JS SDK handles all of these scenarios, by simple passing the redirect result to <pre>handleAction(redirect)</pre></p>
          <p>Below is the payload returned from the Adyen <pre>/payments</pre> call:</p>
          <pre data-bind="html: redirPrettyPrint"></pre>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bind="click: followRedirect">Follow Redirect</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal" tabindex="-1" role="dialog" id="successModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Order Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Your order number #<span data-bind="text: paymentMethodForm.reference()"></span> has been placed successfully! Thank you!</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
