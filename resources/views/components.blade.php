@extends('layouts.main')

@section('content')
  <div class="row see-through mild-opacity m-2">
    <div class="col-md-12 text-center">
      <h1 class="text-center">Adyen Components Web Integration</h1>
    </div>
    <div class="col-md-4">
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
    <div class="col-md-4">
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="enable3DS2" data-bind="value: enable3DS2, checked: enable3DS2">
        <label class="form-check-label" for="enable3DS2">Enable 3DS2</label>
      </div>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="populateFakeAddress" data-bind="value: populateFakeAddress, checked: populateFakeAddress">
        <label class="form-check-label" for="populateFakeAddress">Fake Address (good for quick tests)</label>
      </div>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="secureFields" data-bind="value: secureFields, checked: secureFields">
        <label class="form-check-label" for="secureFields">Secure Fields (low level)</label>
      </div>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="enableStoreDetails" data-bind="value: enableStoreDetails, checked: enableStoreDetails">
        <label class="form-check-label" for="enableStoreDetails">Enable Store Info</label>
      </div>
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" data-bind="value: dropIn, checked: dropIn" id="dropInSwitch">
        <label class="custom-control-label" for="dropInSwitch" data-bind="visible: dropIn()">Drop-In</label>
        <label class="custom-control-label" for="dropInSwitch" data-bind="visible: !dropIn()">Components</label>
      </div>
      @component('layouts.payment-methods-form')
      @endcomponent
    </div>
    <div class="col-md-4" data-bind="visible: havePaymentMethods()">
      <div id="dropin-container" class="col-md-12"></div>
      <div id="card-container" class="col-md-12"></div>
      <div id="klarna-container" class="col-md-12"></div>
      <div id="alipay-container" class="col-md-12"></div>
      <div id="action-container" class="col-md-12"></div>
      <div id="sepadirectdebit-container" class="col-md-12"></div>
      <div class="col-md-12 mt-1 mb-1" data-bind="visible: showPayButton()">
        <button type="button" class="btn btn-secondary" data-bind="enable: enablePayButton, click: submitPayment">Pay Now</button>
      </div>
      <div class="col-md-12 mb-3 mt-3" data-bind="visible: canCapture()">
        <div class="form-group">
          <label for="pspReference">Psp Reference:</label>
          <input type="text" name="pspReference" class="form-control" id="pspReference" placeholder="Enter PSP Reference" data-bind="value: pspReference">
          <button type="button" class="btn btn-secondary mt-2" data-bind="click: submitCapture">Capture Now</button>
        </div>
      </div>
    </div>
    <div class="col-md-4" data-bind="visible: secureFields() && havePaymentMethods()">
      <div id="customCard-container">
        <label>
          <span>Card number:</span>
          <span data-cse="encryptedCardNumber"></span>
        </label>
        <label>
          <span>Card name:</span>
          <span data-cse="encryptedHolderName"></span>
        </label>
        <label>
          <span>Expiry date:</span>
          <span data-cse="encryptedExpiryDate"></span>
        </label>
        <label>
          <span>CVV/CVC:</span>
          <span data-cse="encryptedSecurityCode"></span>
        </label>
      </div>
    </div>
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
          <p>Adyen has returned a redirect result to you. Click below to continue the redirect flow:</p>
          <pre data-bind="html: redirPrettyPrint"></pre>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bind="click: followRedirect">Follow Redirect</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
