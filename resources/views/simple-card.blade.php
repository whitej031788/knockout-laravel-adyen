<!DOCTYPE html>
<html>
  <head>
    <title>Sample Moto Card Component</title>
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
      integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
      crossorigin="anonymous"></script>
    <!-- Adyen Library -->
    <script src="https://checkoutshopper-test.adyen.com/checkoutshopper/sdk/3.18.1/adyen.js"
      integrity="sha384-CJ8FSR4EmldZPoNUHfpHrZ7CSOsP2lxp8xzSNIE92icrx46CmCoSxucO4IRE8h7V"
      crossorigin="anonymous"></script>
    <!-- Adyen CSS -->
    <link rel="stylesheet" href="https://checkoutshopper-test.adyen.com/checkoutshopper/sdk/3.18.1/adyen.css"
      integrity="sha384-5K4T5NNVv7ZBvNypROEUSjvOL45HszUg/eYfYadY82UF4b+hc+TPQ4SsfTGXufJp"
      crossorigin="anonymous">
    <!-- Adyen Card Rendering / Handling -->
    <script type="text/javascript">

    function handleOnSubmit(state, component) {
      // state.data.paymentMethod now needs to make it to your own server side Java SDK to make a /payments request
      // https://docs.adyen.com/checkout/components-web?tab=codeBlocktS6L2_3
      // You combine the paymentMethod data with your own data, IE reference (order number), merchant account, etc.
      console.log(state.data.paymentMethod);
      $.ajax({
        url: '/api/adyen/makePaymentSimple',
        dataType: 'json',
        type: 'post',
        data: state.data.paymentMethod,
        success: function(retData, textStatus, jQxhr) {
          // Show success / failure to the call center agent, and we are done
          console.log(retData);
        },
        error: function(jqXhr, textStatus, errorThrown) {
          console.log(errorThrown);
        }
      });
    }

    var configuration = {
      environment: "test", // When you're ready to accept live payments, change the value to one of our live environments https://docs.adyen.com/checkout/components-web#testing-your-integration.
      clientKey: "test_26ROBT3X3NDAXJW4KQPVMOOIUACJULB4", // Your client key. To find out how to generate one, see https://docs.adyen.com/development-resources/client-side-authentication. Web Components versions before 3.10.1 use originKey instead of clientKey.
      // The payment methods response that can be fetched using server side Java SDK, https://docs.adyen.com/checkout/components-web?tab=script_2#step-1-get-available-payment-methods, // The payment methods response returned in step 1.
      paymentMethodsResponse: {
        "groups": [{
          "name": "Credit Card",
          "types": ["visa", "mc", "amex"]
        }],
        "paymentMethods": [{
          "brands": ["visa", "mc", "amex"],
          "details": [{
            "key": "number",
            "type": "text"
          }, {
            "key": "expiryMonth",
            "type": "text"
          }, {
            "key": "expiryYear",
            "type": "text"
          }, {
            "key": "cvc",
            "type": "text"
          }, {
            "key": "holderName",
            "optional": true,
            "type": "text"
          }],
          "name": "Credit Card",
          "type": "scheme"
        }]
      },
      onSubmit: handleOnSubmit // Your function for handling the call centre agent submission event
    };
    </script>
  </head>
  <body>
    <div id="adyen-card-component">
    </div>
    <!-- Put these scripts at the bottom so the page would have loaded -->
    <!-- Also can use the jquery $(document).ready -->
    <script type="text/javascript">
      var checkout = new AdyenCheckout(configuration);
      var card = checkout.create('card', {showPayButton: true}).mount('#adyen-card-component');
    </script>
  </body>
</html>
