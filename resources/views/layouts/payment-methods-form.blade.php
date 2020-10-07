<form data-bind="submit: submitPaymentMethods" class="mb-2">
  <div class="form-group" id="paymentMethodForm">
    <label for="merchantAccount">Merchant Account:</label>
    <input type="text" class="form-control" id="merchantAccount" placeholder="Enter merchant account" data-bind="value: paymentMethodForm.merchantAccount">
  </div>
  <div class="form-group">
    <label for="countryCode">Country Code:</label>
    <input type="text" maxlength="2" class="form-control" id="countryCode" placeholder="Enter country code" data-bind="value: paymentMethodForm.countryCode" onkeyup="this.value = this.value.toUpperCase();">
  </div>
  <div class="form-group">
    <label for="amount">Amount:</label>
    <input type="number" class="form-control" id="amount" placeholder="Enter amount" data-bind="value: paymentMethodForm.amount">
  </div>
  <div class="form-group">
    <label for="currency">Currency:</label>
    <input maxlength="3" type="text" class="form-control" id="currency" placeholder="Enter currency" data-bind="value: paymentMethodForm.currency" onkeyup="this.value = this.value.toUpperCase();">
  </div>
  <div class="form-group" style="display: none;">
    <label for="channel">Channel:</label>
    <input type="text" class="form-control" id="channel" placeholder="Enter channel" data-bind="value: paymentMethodForm.channel" disabled>
  </div>
  <div class="form-group">
    <label for="channel">Reference:</label>
    <input type="text" class="form-control" id="reference" placeholder="Enter reference" data-bind="value: paymentMethodForm.reference">
  </div>
  <div class="form-group">
    <label for="channel">Shopper Reference:</label>
    <input type="text" class="form-control" id="shopperReference" placeholder="Enter shopper reference" data-bind="value: paymentMethodForm.shopperReference">
  </div>
  <div class="col-md-12 text-center alert-danger small mb-2" data-bind="text: paymentMethodForm.error, visible: paymentMethodForm.error"></div>
  <div class="col-md-12">
    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Fetch the available payment methods!">Submit</button>
  </div>
</form>
