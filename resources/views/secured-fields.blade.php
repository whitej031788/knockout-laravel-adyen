@extends('layouts.main')

@section('content')
<html>
    <head>
        <meta charset="utf-8"/>
        <script type="text/javascript" src="https://checkoutshopper-test.adyen.com/checkoutshopper/assets/js/sdk/checkoutSecuredFields.1.5.1.min.js"></script>
    </head>
    <body>
        <form method="POST" name="adyenForm" id="adyenForm" onsubmit="return mySubmitFunction(event)">
          <div class="cards-div">
              <div class="js-chckt-pm__pm-holder">
                  <input type="hidden" name="txvariant" value="card"/>
                  <label>
                      <span class="input-field" data-cse="encryptedCardNumber"/>
                  </label>
                  <label>
                      <span class="input-field" data-cse="encryptedExpiryMonth"/>
                  </label>
                  <label>
                      <span class="input-field" data-cse="encryptedExpiryYear"/>
                  </label>
                  <label>
                      <span class="input-field" data-cse="encryptedSecurityCode"/>
                  </label>
              </div>
              <input class="form-control mb-2" type="submit" value="Pay"/>
          </div>
        </form>
        <script type="text/javascript">
            var styleObject = {
                base: {
                    padding: '5px',
                    fontSize: '14px'//fontVariant: 'small-caps'
                },
                error: {
                    color: '#f44242'
                },
                placeholder: {
                    color: 'grey'
                }
            };

            var securedFields = csf({
                configObject: {
                    originKey: "pub.v2.8215833140141788.aHR0cDovL2xvY2FsaG9zdDo4MDAw.MW9tDxjt-oSAYUwbdk6t2rHwZR3oXERpM4fYhaS3ong",
                    cardGroupTypes: ['mc', 'visa', 'amex']
                },
                rootNode: '.cards-div',
                paymentMethods: {
                    card: {
                        sfStyles: styleObject,
                        placeholders: {
                            encryptedCardNumber: '1234 5678 9012 3456',
                            encryptedExpiryMonth: 'month',
                            encryptedExpiryYear: 'year',
                            encryptedSecurityCode: 'cvc'
                        }
                    }
                }
            });

            /* Secured Fields callbacks*/
            securedFields.onError(function(pCallbackObj) {
                console.log(pCallbackObj);
                // Triggered when an error occurs e.g. invalid date
                console.log(pCallbackObj.error + " onError (typing): " + pCallbackObj.fieldType)
                console.log(pCallbackObj.error + " onError in field: " + pCallbackObj.fieldType)
            });

            securedFields.onFieldValid(function(fieldObject) {
                console.log(fieldObject.type + " is valid : " + fieldObject.valid)
            });


            securedFields.onBrand ( function(brandObject){
                console.log("The brand is: " + brandObject.brand)
            });

            securedFields.onAllValid(function(allValidObject) {
                console.log(allValidObject);
                console.log("onAllValid: " + allValidObject.allValid)
            });

            securedFields.onFocus(function(focusObject) {
                console.log(focusObject.fieldType + " in focus : " + focusObject.focus)
            });

            function preparePayData(cardNum, expiryMonth, expiryYear, cardCvv) {
              let obj = {};

              obj.amount = {};
              obj.amount.value = 100;
              obj.amount.currency = "GBP";
              obj.merchantAccount = "JamieAdyenTestECOM"
              obj.reference = "TESTREF-SECUREFIELDS";
              obj.countryCode = "GB";
              obj.shopperReference = "TEST-SHOP-REF";

              obj.payData = {};
              obj.payData.paymentMethod = {
                type: "scheme",
                encryptedCardNumber: cardNum,
                encryptedExpiryMonth: expiryMonth,
                encryptedExpiryYear: expiryYear,
                encryptedSecurityCode: cardCvv
              };

              obj.allow3DS2 = false;
              obj.channel = "Web";

              return obj;
            }

            function mySubmitFunction(e) {
              let cardNum = document.adyenForm.elements['encryptedCardNumber'].value;
              let expiryMonth = document.adyenForm.elements['encryptedExpiryMonth'].value;
              let expiryYear = document.adyenForm.elements['encryptedExpiryYear'].value;
              let cardCvv = document.adyenForm.elements['encryptedSecurityCode'].value;
              $.ajax({
                url: '/api/adyen/makePaymentSimple',
                dataType: 'json',
                type: 'post',
                data: preparePayData(cardNum, expiryMonth, expiryYear, cardCvv),
                success: function(retData, textStatus, jQxhr) {
                  console.log(retData);
                },
                error: function(jqXhr, textStatus, errorThrown) {
                  console.log(errorThrown);
                }
              });

              console.log(cardNum)
              return false;
            }
        </script>
</body>
</html>
@endsection
