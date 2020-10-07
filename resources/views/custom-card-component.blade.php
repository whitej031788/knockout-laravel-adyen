@extends('layouts.main')

@section('content')
  <div class="row see-through mild-opacity m-2">
    <div class="col-md-12 text-center">
      <h2 class="text-center mb-2" style="text-decoration:underline;">Adyen Custom Card Components</h2>
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
      @component('layouts.payment-methods-form')
      @endcomponent
    </div>
    <div class="col-md-4" data-bind="visible: havePaymentMethods()">
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
        <button type="button" id="unmountButton" class="btn btn-secondary mt-2" data-bind="click: unmountAndRemount">Unmount</button>
      </div>
      <div class="col-md-12">
        <div id="customCard-container">
          <label>
            <span>Card number:</span>
            <span data-cse="encryptedCardNumber" placeholder="placeholder"></span>
          </label>
          <label>
            <span>Expiry date:</span>
            <span data-cse="encryptedExpiryDate"></span>
          </label>
          <label>
            <span>Expiry month:</span>
            <span data-cse="encryptedExpiryMonth"></span>
          </label>
          <label>
            <span>Expiry year:</span>
            <span data-cse="encryptedExpiryYear"></span>
          </label>
          <label>
            <span>CVV/CVC:</span>
            <span data-cse="encryptedSecurityCode"></span>
          </label>
          <button type="button" id="secureButton" class="btn btn-secondary mt-2" data-bind="click: submitPayment">Pay Now</button>
        </div>
      </div>
    </div>
  </div>
@endsection
