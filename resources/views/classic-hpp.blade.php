@extends('layouts.main')

@section('content')
  <script> var sessValid = "{{$datetime}}";</script>
  <div class="row see-through mild-opacity mt-3">
    <div class="col-md-6 offset-md-3">
      <h3 class="text-center">Adyen Classic HPP</h3>
      <form method="post" data-bind="submit: submitHppStuff, attr: {action: hppUrl}" id="adyenForm" name="adyenForm" target="_parent" class="form">
        <div class="form-group" id="hppSubmitForm">
          <label for="merchantAccount">Merchant Account:</label>
          <input type="text" name="merchantAccount" class="form-control" id="merchantAccount" placeholder="Enter merchant account" data-bind="value: merchantAccount">
        </div>
        <div class="form-group">
          <label for="countryCode">Country Code:</label>
          <input type="text" name="countryCode" maxlength="2" class="form-control" id="countryCode" placeholder="Enter country code" data-bind="value: countryCode" onkeyup="this.value = this.value.toUpperCase();">
        </div>
        <div class="form-group">
          <label for="amount">Amount:</label>
          <input type="number" name="paymentAmount" class="form-control" id="amount" placeholder="Enter amount" data-bind="value: paymentAmount">
        </div>
        <div class="form-group">
          <label for="currency">Currency:</label>
          <input maxlength="3" name="currencyCode" type="text" class="form-control" id="currency" placeholder="Enter currency" data-bind="value: currencyCode" onkeyup="this.value = this.value.toUpperCase();">
        </div>
        <div class="form-group">
          <label for="channel">Reference:</label>
          <input type="text" name="merchantReference" class="form-control" id="reference" placeholder="Enter reference" data-bind="value: merchantReference">
        </div>
        <div class="form-group">
          <label for="skinCode">Skin Code:</label>
          <input type="text" name="skinCode" class="form-control" id="skinCode" placeholder="Enter Skin Code" data-bind="value: skinCode">
        </div>
        <div class="form-group">
          <label for="hppType">HPP Type:</label>
          <select style="background-color: white;" id="hppType" class="form-control" data-bind="options: hppTypeOptions, value: hppType"></select>
        </div>
        <input type="hidden" id="sessionValidity" name="sessionValidity" value="{{$datetime}}" />
        <input type="hidden" id="merchantSig" name="merchantSig" data-bind="value: merchantSig" />
        <div class="col-md-12 text-center alert-danger small mb-2" data-bind="text: error, visible: error"></div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
@endsection
