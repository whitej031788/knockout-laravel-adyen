<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script type="module">
      import { ApplePayService } from '/js/knockout/partials/apple-pay-service.js';
      window.ApplePayService = ApplePayService;
    </script>
    <script>
      function getDecimalAmount(amount, currencyCode) {
          return parseInt(String(amount), 10) / 100;
      };

      function formatAmount(amount, currencyCode) {
        return String(getDecimalAmount(amount, currencyCode));
      }

      function preparePaymentRequest() {
        const formattedAmount = formatAmount(100, "GBP");

        return {
          countryCode: "GB",
          currencyCode: "GBP",
          total: {
              label: "Jamie Test Merchant",
              amount: "1.00",
              type: "final"
          },
          //lineItems: props.lineItems,
          //shippingMethods: props.shippingMethods,
          //shippingType: props.shippingType,
          merchantCapabilities: ["supports3DS"],
          //supportedCountries: props.supportedCountries,
          supportedNetworks: [
            "visa",
            "masterCard",
            "amex",
            "discover"
          ],
          //requiredShippingContactFields: props.requiredShippingContactFields,
          //requiredBillingContactFields: props.requiredBillingContactFields,
          //billingContact: props.billingContact,
          //shippingContact: props.shippingContact,
          //applicationData: props.applicationData
        };
      }

      function testAwait(validationURL) {
        return fetch('/api/adyen/applePaySession', {
          method: 'POST', // or 'PUT'
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({"sessionUrl" : validationURL}),
        })
        .then(response => response.json());
      }

      async function myOnValidateMerchant(resolve, reject, validationURL) {
        let response = await testAwait(validationURL);
        resolve(response);
      }

      function myOnPaymentAuthorized(resolve, reject, event) {
        console.log(event);
        resolve(event);
      }

      function submit() {
        startPayment();
      }

      function startPayment() {
        return Promise.resolve(startSession(myOnPaymentAuthorized));
      }

      function onSubmit(event) {
        console.log(event);
      }

      function startSession(onPaymentAuthorized) {
        // This is simplified; it is just building an object, so don't see why it wouldn't be fine
        const paymentRequest = preparePaymentRequest();

        // This is simplified, but just based on the component config object
        const session = new window.ApplePayService(paymentRequest, {
          version: 3,
          onValidateMerchant: myOnValidateMerchant,
          onCancel: (event) => console.log(event),
          onPaymentMethodSelected: null,
          onShippingMethodSelected: null,
          onShippingContactSelected: null,
          onPaymentAuthorized: (resolve, reject, event) => {
            if (!!event.payment.token && !!event.payment.token.paymentData) {
              console.log('Event Payment: ', event.payment);
            }

            // This is usually the component submit function from the React component, which bubbles up to the checkout onSubmit
            onSubmit(event);
            onPaymentAuthorized(resolve, reject, event);
          }
        });

        session.begin();
      }
    </script>
  </head>
  <body>
    <div>
      <div>
        <a lang="us" class="applePayButton" style="-webkit-appearance: -apple-pay-button; -apple-pay-button-type: plain; -apple-pay-button-style: black; height: 30px; width: 150px;" onclick="submit()" title="Start Apple Pay" role="link" tabindex="0"></a>
      </div>
    </div>
  </body>
</html>
