@extends('layouts.main')

@section('content')
  <div class="row see-through mild-opacity mt-3">
    <div class="col-md-12 text-center">
      <h1 class="text-center">Adyen Components Web Integration</h1>
    </div>
    <div class="col-md-6">
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="enable3DS2" data-bind="value: enable3DS2, checked: enable3DS2">
        <label class="form-check-label" for="enable3DS2">Enable 3DS2</label>
      </div>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="populateFakeAddress" data-bind="value: populateFakeAddress, checked: populateFakeAddress">
        <label class="form-check-label" for="populateFakeAddress">Fake Address (good for quick tests)</label>
      </div>
      @component('layouts.payment-methods-form')
      @endcomponent
    </div>
    <div class="col-md-6">
      <div id="card-container" class="col-md-12"></div>
      <div id="klarna-container" class="col-md-12"></div>
      <div id="alipay-container" class="col-md-12"></div>
      <div id="action-container" class="col-md-12"></div>
      <div id="sepadirectdebit-container" class="col-md-12"></div>
      <button type="button" class="btn btn-secondary" data-bind="visible: showPayButton, enable: enablePayButton, click: submitPayment">Pay Now</button>
    </div>
    <div class="col-md-6">
      <div id="customCard-container">
        <label>
          <span>Card number:</span>
          <span data-cse="encryptedCardNumber"></span>
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
@endsection
