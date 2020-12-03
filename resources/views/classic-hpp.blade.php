@extends('layouts.main')

@section('content')
  <script>
    var sessValid = "{{$datetime}}";
    function target_popup(form) {
    window.open('', 'formpopup', 'width=400,height=400,resizeable,scrollbars');
      form.target = 'formpopup';
    }
  </script>
  <div class="row see-through mild-opacity mt-3">
    <div class="col-md-6 offset-md-3">
      <h3 class="text-center">Adyen Classic HPP</h3>
      <form method="post" data-bind="submit: submitHppStuff, attr: {action: hppUrl}" id="adyenForm" name="adyenForm" class="form">
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
          <label for="channel">Shopper Reference:</label>
          <input type="text" name="shopperReference" class="form-control" id="shopperReference" placeholder="Enter shopper Reference" data-bind="value: shopperReference">
        </div>
        <div class="form-group">
          <label for="channel">Shopper Email:</label>
          <input type="text" name="shopperEmail" class="form-control" id="shopperEmail" placeholder="Enter shopper email" data-bind="value: shopperEmail">
        </div>
        <div class="form-group">
          <label for="skinCode">Skin Code:</label>
          <input type="text" name="skinCode" class="form-control" id="skinCode" placeholder="Enter Skin Code" data-bind="value: skinCode">
        </div>
        <div class="form-group">
          <label for="brandCode">Brand Code:</label>
          <input type="text" name="brandCode" class="form-control" id="brandCode" placeholder="Enter Brand Code" data-bind="value: brandCode">
        </div>
        <div class="form-group">
          <label for="hppType">HPP Type:</label>
          <select style="background-color: white;" id="hppType" class="form-control" data-bind="options: hppTypeOptions, value: hppType"></select>
        </div>
        {{-- <!--Invoice Line Specification -->
        <input type="hidden" name="openinvoicedata.numberOfLines" data-bind="value: openinvoicedata.numberOfLines" />
        <!-- ko foreach: {data: openinvoicedata.lineItems, as: '_data'} -->
          <!-- ko foreach: {data: Object.keys(props), as: '_propkey'} -->
          <input type="hidden" value="1" data-bind="attr: {'name': 'openinvoicedata.line' + _data.id + '.' + _propkey}, value: _data.props[_propkey]" />
          <!-- /ko -->
        <!-- /ko --> --}}

        <input type="hidden" id="sessionValidity" name="sessionValidity" value="{{$datetime}}" />
        <input type="hidden" id="merchantSig" name="merchantSig" data-bind="value: merchantSig" />
        <div class="col-md-12 text-center alert-danger small mb-2" data-bind="text: error, visible: error"></div>
        <button type="submit" class="btn btn-primary">Submit</button>
        {{-- <iframe name="output_frame" src="" id="output_frame" width="500" height="500"></iframe> --}}
      </form>
    </div>
  </div>
@endsection
