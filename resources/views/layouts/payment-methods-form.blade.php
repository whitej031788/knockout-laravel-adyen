<form>
  <div class="form-group">
    <label for="merchantAccount">Merchant Account:</label>
    <input type="text" class="form-control" id="merchantAccount" placeholder="Enter merchant account" disabled>
  </div>
  <div class="form-group">
    <label for="countryCode">Country Code:</label>
    <input type="text" maxlength="2" class="form-control" id="countryCode" placeholder="Enter country code" onkeyup="this.value = this.value.toUpperCase();">
  </div>
  <div class="form-group">
    <label for="amount">Amount:</label>
    <input type="number" class="form-control" id="amount" placeholder="Enter amount">
  </div>
  <div class="form-group">
    <label for="currency">Currency:</label>
    <input maxlength="3" type="text" class="form-control" id="currency" placeholder="Enter currency" onkeyup="this.value = this.value.toUpperCase();">
  </div>
  <div class="form-group">
    <label for="channel">Channel:</label>
    <input type="text" class="form-control" id="channel" placeholder="Enter channel" disabled>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
