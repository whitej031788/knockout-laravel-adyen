@extends('layouts.main')

@section('content')
  <div class="jumbotron see-through">
    <div class="container mild-opacity">
      <div class="row">
        <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2">
          <h1 class="text-center">Example Adyen Integrations</h1>
          <ul class="list-group">
            <li class="list-group-item">Laravel</li>
            <li class="list-group-item">Knockout.js</li>
            <li class="list-group-item">CSS</li>
            <li class="list-group-item">jQuery</li>
            <li class="list-group-item">Adyen API</li>
            <li class="list-group-item"></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <script>
  async function onValidateMerchant(resolve, reject, validationURL) {
    let retObj = {
      "epochTimestamp": 1585836163761,
      "expiresAt": 1585839763761,
      "merchantSessionIdentifier": "SSH77B6....",
      "nonce": "acee6f45",
      "merchantIdentifier": "3142363....",
      "domainName": "https://testpage.com",
      "displayName": "Test ApplePay Store",
      "signature": "wri7yfwfr32...."
    };
    resolve(retObj);
  }
  let myProm = new Promise((function(resolve, reject) {
    return onValidateMerchant(resolve, reject, 'e.validationURL')
  })).then((function(e) {
    console.log(e);
  })).catch((function(e) {
    console.error(e);
  }))
  </script>
@endsection
