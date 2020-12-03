$(document).ready(function() {
  console.log("ready!");
  var str;
  var dropin;
  var card;
  var checkout;

  function fakeJsonPromise() {
    var delayedResponse = function(resolve, reject) {
      setTimeout(function() {
        resolve(
{
    "paymentMethods": [
        {
            "brands": [
                "amex",
                "bcmc",
                "cartebancaire",
                "mc",
                "visa",
                "visadankort"
            ],
            "details": [
                {
                    "key": "number",
                    "type": "text"
                },
                {
                    "key": "expiryMonth",
                    "type": "text"
                },
                {
                    "key": "expiryYear",
                    "type": "text"
                },
                {
                    "key": "cvc",
                    "type": "text"
                },
                {
                    "key": "holderName",
                    "optional": true,
                    "type": "text"
                }
            ],
            "name": "Credit Card",
            "type": "scheme"
        },
        {
            "details": [
                {
                    "key": "number",
                    "type": "text"
                },
                {
                    "key": "expiryMonth",
                    "type": "text"
                },
                {
                    "key": "expiryYear",
                    "type": "text"
                },
                {
                    "key": "holderName",
                    "optional": true,
                    "type": "text"
                }
            ],
            "name": "Bancontact card",
            "type": "bcmc"
        },
        {
            "name": "Online bank transfer.",
            "type": "directEbanking"
        },
        {
            "details": [
                {
                    "items": [
                        {
                            "id": "66",
                            "name": "Bank Nowy BFG S.A."
                        },
                        {
                            "id": "92",
                            "name": "Bank Spółdzielczy w Brodnicy"
                        },
                        {
                            "id": "11",
                            "name": "Bank transfer / postal"
                        },
                        {
                            "id": "74",
                            "name": "Banki Spółdzielcze"
                        },
                        {
                            "id": "73",
                            "name": "BLIK"
                        },
                        {
                            "id": "90",
                            "name": "BNP Paribas - płacę z Pl@net"
                        },
                        {
                            "id": "59",
                            "name": "CinkciarzPAY"
                        },
                        {
                            "id": "87",
                            "name": "Credit Agricole PBL"
                        },
                        {
                            "id": "83",
                            "name": "EnveloBank"
                        },
                        {
                            "id": "76",
                            "name": "Getin Bank PBL"
                        },
                        {
                            "id": "81",
                            "name": "Idea Cloud"
                        },
                        {
                            "id": "7",
                            "name": "ING Corporate customers"
                        },
                        {
                            "id": "35",
                            "name": "Kantor Polski"
                        },
                        {
                            "id": "93",
                            "name": "Kasa Stefczyka"
                        },
                        {
                            "id": "44",
                            "name": "Millennium - Płatności Internetowe"
                        },
                        {
                            "id": "10",
                            "name": "Millennium Corporate customers"
                        },
                        {
                            "id": "68",
                            "name": "mRaty"
                        },
                        {
                            "id": "1",
                            "name": "mTransfer"
                        },
                        {
                            "id": "91",
                            "name": "Nest Bank"
                        },
                        {
                            "id": "80",
                            "name": "Noble Pay"
                        },
                        {
                            "id": "50",
                            "name": "Pay Way Toyota Bank"
                        },
                        {
                            "id": "45",
                            "name": "Pay with Alior Bank"
                        },
                        {
                            "id": "65",
                            "name": "Paylink Idea Bank"
                        },
                        {
                            "id": "36",
                            "name": "Pekao24Przelew"
                        },
                        {
                            "id": "70",
                            "name": "Pocztowy24"
                        },
                        {
                            "id": "6",
                            "name": "Przelew24"
                        },
                        {
                            "id": "46",
                            "name": "Płacę z Citi Handlowy"
                        },
                        {
                            "id": "38",
                            "name": "Płacę z ING"
                        },
                        {
                            "id": "2",
                            "name": "Płacę z Inteligo"
                        },
                        {
                            "id": "4",
                            "name": "Płacę z iPKO"
                        },
                        {
                            "id": "75",
                            "name": "Płacę z Plus Bank"
                        },
                        {
                            "id": "51",
                            "name": "Płać z BOŚ"
                        },
                        {
                            "id": "55",
                            "name": "Raty z Alior Bankiem PLN"
                        },
                        {
                            "id": "89",
                            "name": "Santander"
                        },
                        {
                            "id": "52",
                            "name": "SkyCash"
                        },
                        {
                            "id": "60",
                            "name": "T-Mobile usługi bankowe"
                        },
                        {
                            "id": "21",
                            "name": "VIA - Moje Rachunki"
                        },
                        {
                            "id": "84",
                            "name": "Volkswagen Bank direct"
                        }
                    ],
                    "key": "issuer",
                    "type": "select"
                }
            ],
            "name": "Local Polish Payment Methods",
            "type": "dotpay"
        },
        {
            "name": "Finnish E-Banking",
            "type": "ebanking_FI"
        },
        {
            "details": [
                {
                    "items": [
                        {
                            "id": "d5d5b133-1c0d-4c08-b2be-3c9b116dc326",
                            "name": "Dolomitenbank"
                        },
                        {
                            "id": "ee9fc487-ebe0-486c-8101-17dce5141a67",
                            "name": "Raiffeissen Bankengruppe"
                        },
                        {
                            "id": "6765e225-a0dc-4481-9666-e26303d4f221",
                            "name": "Hypo Tirol Bank AG"
                        },
                        {
                            "id": "8b0bfeea-fbb0-4337-b3a1-0e25c0f060fc",
                            "name": "Sparda Bank Wien"
                        },
                        {
                            "id": "1190c4d1-b37a-487e-9355-e0a067f54a9f",
                            "name": "Schoellerbank AG"
                        },
                        {
                            "id": "e2e97aaa-de4c-4e18-9431-d99790773433",
                            "name": "Volksbank Gruppe"
                        },
                        {
                            "id": "bb7d223a-17d5-48af-a6ef-8a2bf5a4e5d9",
                            "name": "Immo-Bank"
                        },
                        {
                            "id": "e6819e7a-f663-414b-92ec-cf7c82d2f4e5",
                            "name": "Bank Austria"
                        },
                        {
                            "id": "eff103e6-843d-48b7-a6e6-fbd88f511b11",
                            "name": "Easybank AG"
                        },
                        {
                            "id": "25942cc9-617d-42a1-89ba-d1ab5a05770a",
                            "name": "VR-BankBraunau"
                        },
                        {
                            "id": "4a0a975b-0594-4b40-9068-39f77b3a91f9",
                            "name": "Volkskreditbank"
                        },
                        {
                            "id": "3fdc41fc-3d3d-4ee3-a1fe-cd79cfd58ea3",
                            "name": "Erste Bank und Sparkassen"
                        },
                        {
                            "id": "ba7199cc-f057-42f2-9856-2378abf21638",
                            "name": "BAWAG P.S.K. Gruppe"
                        }
                    ],
                    "key": "issuer",
                    "type": "select"
                }
            ],
            "name": "EPS",
            "type": "eps"
        },
        {
            "name": "GiroPay",
            "type": "giropay"
        },
        {
            "details": [
                {
                    "items": [
                        {
                            "id": "1121",
                            "name": "Test Issuer"
                        },
                        {
                            "id": "1154",
                            "name": "Test Issuer 5"
                        },
                        {
                            "id": "1153",
                            "name": "Test Issuer 4"
                        },
                        {
                            "id": "1152",
                            "name": "Test Issuer 3"
                        },
                        {
                            "id": "1151",
                            "name": "Test Issuer 2"
                        },
                        {
                            "id": "1162",
                            "name": "Test Issuer Cancelled"
                        },
                        {
                            "id": "1161",
                            "name": "Test Issuer Pending"
                        },
                        {
                            "id": "1160",
                            "name": "Test Issuer Refused"
                        },
                        {
                            "id": "1159",
                            "name": "Test Issuer 10"
                        },
                        {
                            "id": "1158",
                            "name": "Test Issuer 9"
                        },
                        {
                            "id": "1157",
                            "name": "Test Issuer 8"
                        },
                        {
                            "id": "1156",
                            "name": "Test Issuer 7"
                        },
                        {
                            "id": "1155",
                            "name": "Test Issuer 6"
                        }
                    ],
                    "key": "issuer",
                    "type": "select"
                }
            ],
            "name": "iDEAL",
            "type": "ideal"
        },
        {
            "name": "Pay later with Klarna.",
            "type": "klarna"
        },
        {
            "name": "Slice it with Klarna.",
            "type": "klarna_account"
        },
        {
            "name": "Pay now with Klarna.",
            "type": "klarna_paynow"
        },
        {
            "name": "Multibanco",
            "type": "multibanco"
        },
        {
            "name": "Paysafecard",
            "type": "paysafecard"
        },
        {
            "details": [
                {
                    "key": "sepa.ownerName",
                    "type": "text"
                },
                {
                    "key": "sepa.ibanNumber",
                    "type": "text"
                }
            ],
            "name": "SEPA Direct Debit",
            "type": "sepadirectdebit"
        },
        {
            "name": "Swish",
            "type": "swish"
        },
        {
            "name": "Trustly",
            "type": "trustly"
        },
        {
            "details": [
                {
                    "key": "telephoneNumber",
                    "optional": true,
                    "type": "tel"
                }
            ],
            "name": "Vipps",
            "type": "vipps"
        }
    ]
});
      }, 1000);
    }

    return new Promise(delayedResponse);
  }

  //
  //Adyen Checkout configuration (including the fake payment methods call using file)
  //
  fakeJsonPromise()
  .then(function(paymentMethodsResponse) {

    function handleOnChange(state, component) {
        state.isValid // True or false. Specifies if all the information that the shopper provided is valid.
        state.data // Provides the data that you need to pass in the `/payments` call.
        component // Provides the active component instance that called this event.
      }

      function handleOnAdditionalDetails(state, component) {
        state.data // Provides the data that you need to pass in the `/payments/details` call.
        component // Provides the active component instance that called this event.
        printResults(state.data)
      }

      function handleOnSubmit(state, component) {
        state.isValid // True or false. Specifies if all the information that the shopper provided is valid.
        state.data // Provides the data that you need to pass in the `/payments` call.
        component // Provides the active component instance that called this event.
        printResults(state.data)
      }

      //
      //Components Configuration
      //
      const configuration = {
        locale: "en_US", // The shopper's locale. For a list of supported locales, see https://docs.adyen.com/checkout/components-web/localization-components.
        environment: "test", // When you're ready to accept live payments, change the value to one of our live environments https://docs.adyen.com/checkout/components-web#testing-your-integration.
        clientKey: "test_26ROBT3X3NDAXJW4KQPVMOOIUACJULB4", // Your client key. To find out how to generate one, see https://docs.adyen.com/development-resources/client-side-authentication. Web Components versions before 3.10.1 use originKey instead of clientKey.
        paymentMethodsResponse: paymentMethodsResponse, // The payment methods response returned in step 1.
        onChange: handleOnChange, // Your function for handling onChange event
        onAdditionalDetails: handleOnAdditionalDetails, // Your function for handling onAdditionalDetails event
        showPayButton: true,
        onSubmit: handleOnSubmit,
        amount: { // Optional. Used to display the amount in the Pay Button.
          value: 1000,
          currency: 'EUR'
        },
        paymentMethodsConfiguration: {
          card: { // Example optional configuration for Cards
            hasHolderName: true,
            holderNameRequired: true,
            enableStoreDetails: true,
            hideCVC: false, // Change this to true to hide the CVC field for stored cards
            name: 'Credit or debit card',
            billingAddressRequired: true
          }
        }
      };

      //
      //Dropin Configuration
      //
      // const configurationDropin = {
      //   paymentMethodsResponse: paymentMethodsResponse, // The `/paymentMethods` response from the server.
      //   clientKey: "test_L2WCUWA4ARAPVCODM6HH2D2VNAZV3FBK", // Web Drop-in versions before 3.10.1 use originKey instead of clientKey.
      //   locale: "en-US",
      //   environment: "test",
      //   onSubmit: (state, dropin) => {
      //     // Your function calling your server to make the `/payments` request
      //     printResults(state.data)
      //     .then(response => {
      //       if (response.action) {
      //           // Drop-in handles the action object from the /payments response
      //           dropin.handleAction(response.action);
      //         } else {
      //           // Your function to show the final result to the shopper
      //           showFinalResult(response);
      //         }
      //       })
      //     .catch(error => {
      //       throw Error(error);
      //     });
      //   },
      //   onAdditionalDetails: (state, dropin) => {
      //     // Your function calling your server to make a `/payments/details` request
      //     console.log("this is the onAdditionalDetails function")
      //   },
        // paymentMethodsConfiguration: {
        //   card: { // Example optional configuration for Cards
        //     hasHolderName: true,
        //     holderNameRequired: true,
        //     enableStoreDetails: true,
        //     hideCVC: false, // Change this to true to hide the CVC field for stored cards
        //     name: 'Credit or debit card'
        //   }
        // }
      // };

      //
      //start AdyenCheckout instances
      //
      checkout = new AdyenCheckout(configuration);
      // const checkoutDropin = new AdyenCheckout(configurationDropin);

      //start the card payment component
      card = checkout.create('card').mount('#card-container');

      //start iDeal component
      const idealComponent = checkout.create('ideal').mount('#ideal-container');

      //start SEPA component
      const sepaComponent = checkout.create("sepadirectdebit").mount("#sepa-container");

      //start Dropin
      dropin = checkout.create('dropin').mount('#dropin-container');

    })
.catch(function() {
  $('body').append('<p>Oh no, something went wrong!</p>');
})

  //
  //Copy Container to clipboard
  //
  $("#copy-button").click(function() {
    var copyText = document.getElementById("results-container-hidden");
    copyText.select();
    document.execCommand("copy");
    console.log("Copied the text: " + copyText.value);
  });

  //
  //Submit Adyen Data
  //
  $("#submit-button").click(function() {
    var submissionData = $('#submission-container').val();
    var prettySubmissionData = JSON.parse(submissionData)
    console.log(prettySubmissionData.action);
    dropin.handleAction(prettySubmissionData.action);
    window.localStorage.setItem('paymentData', prettySubmissionData.paymentData)
    // checkout.createFromAction(prettySubmissionData.action).mount('#threeds-container');
  });

});


//
//Function to make JSON output easily readable/copyable
//
function makePretty(jsonobj) {
  var json = JSON.stringify(jsonobj, undefined, 2);

  json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
  json = json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function(match) {
    var cls = 'color: darkorange;';
    if (/^"/.test(match)) {
      if (/:$/.test(match)) {
        cls = 'color: red;';
      } else {
        cls = 'color: green;';
      }
    } else if (/true|false/.test(match)) {
      cls = 'color: blue;';
    } else if (/null/.test(match)) {
      cls = 'color: magenta;';
    }
    return '<span style="' + cls + '">' + match + '</span>';
  });

  return json;
}
//
//results printer
//
function printResults(data) {
  console.log(data);
  $('#results-container-hidden').empty();
  $('#results-container').empty();
  str = makePretty(data)
  $('#results-container').append(str);
  $('#results-container-hidden').append(JSON.stringify(data, null, '  '));
}
