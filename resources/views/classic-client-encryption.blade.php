@extends('layouts.main')

@section('content')
  <div class="row see-through mild-opacity mt-3">
    <div class="col-md-6 text-center">
      <h3 class="text-center">Adyen Classic Client Side Encryption</h3>
      <p>All data must be correct to enable the submit button. The Adyen JS library does this validaton on its own. This includes a 4 digit year.</p>
      <p>On submit, a single encrypted blob will be added as a hidden input to be passed to the server</p>
      <script type="text/javascript" src="https://test.adyen.com/hpp/cse/js/8215833140141788.shtml"></script>
      <form method="POST" id="adyen-encrypted-form">
        <input placeholder="Card Number" class="form-control mb-2" type="text" size="20" data-encrypted-name="number"/>
        <input placeholder="Card Name" class="form-control mb-2" type="text" size="20" data-encrypted-name="holderName"/>
        <input placeholder="Expire Month" class="form-control mb-2" type="text" size="2" data-encrypted-name="expiryMonth"/>
        <input placeholder="Expire Year" class="form-control mb-2" type="text" size="4" data-encrypted-name="expiryYear"/>
        <input placeholder="CVC" class="form-control mb-2" type="text" size="4" data-encrypted-name="cvc"/>
        <input placeholder="Card Number" class="form-control mb-2" type="hidden" value="{{$datetime}}" data-encrypted-name="generationtime"/>
        <input placeholder="Card Number" class="form-control mb-2" type="submit" value="Pay"/>
      </form>
      <script>
      // The form element to encrypt.
      var form = document.getElementById('adyen-encrypted-form');
      var encryptedBlobFieldName = "adyenDataEncrypted";
      // See https://github.com/Adyen/CSE-JS/blob/master/Options.md for details on the options to use.
      let options = {};
      options.name = encryptedBlobFieldName;
      options.onsubmit = function(e) {
        var encryptedData = form.elements[encryptedBlobFieldName].value;
        // The above is our encrypted card data we can now pass to our payments endpoint
        $.ajax({
          url: '/api/adyen/classicPayment',
          dataType: 'json',
          type: 'post',
          data: {'encData': encryptedData},
          success: function(data, textStatus, jQxhr) {
            console.log(data);
          },
          error: function(jqXhr, textStatus, errorThrown) {
            console.log(errorThrown);
          }
        });
        e.preventDefault();
      };

      adyen.createEncryptedForm(form, options);
      </script>
    </div>
    <div class="col-md-6 text-center">
      <h3 class="text-center">Adyen Gift Cards</h3>
      <p>Gift cards must go through the old endpoint, /authorise</p>
      <form id="giftCardForm" data-bind="event: { submit: submitGiftCard }">
        <input placeholder="Gift Card Number" class="form-control mb-2" type="text" size="20" data-bind="value: cardNumber" />
        <input placeholder="Gift Card Name" class="form-control mb-2" type="text" size="20" data-bind="value: cardName" />
        <input placeholder="Expire Month" class="form-control mb-2" type="text" size="2" data-bind="value: expireMonth" />
        <input placeholder="Expire Year" class="form-control mb-2" type="text" size="4" data-bind="value: expireYear" />
        <input placeholder="CVC" class="form-control mb-2" type="text" size="4" data-bind="value: cardCvc" />
        <input placeholder="Merchant Account" class="form-control mb-2" type="text" size="20" data-bind="value: merchantAccount" disabled />
        <input placeholder="Amount" class="form-control mb-2" type="number" size="10" data-bind="value: amount" />
        <input placeholder="Currency" class="form-control mb-2" type="text" size="3" data-bind="value: currency" />
        <input placeholder="Reference" class="form-control mb-2" type="text" size="20" data-bind="value: reference" />
        <select style="background-color: white;" class="form-control mb-2" data-bind="options: availableBrands, value: selectedBrand"></select>
        <input type="submit" class="btn btn-primary" value="Pay"/>
      </form>
      <script>
      </script>
    </div>
  </div>
@endsection
