import { paymentMethodForm } from './partials/pay-method-component.js';

function contentsKnockoutObj() {
  let self = this;
  /* localhost */
  this.clientKey = 'test_26ROBT3X3NDAXJW4KQPVMOOIUACJULB4';
  //this.originKey = 'pub.v2.8215833140141788.aHR0cDovL2xvY2FsaG9zdDo4MDAw.MW9tDxjt-oSAYUwbdk6t2rHwZR3oXERpM4fYhaS3ong';
  /* EC2 */
  //this.originKey = 'pub.v2.8215833140141788.aHR0cHM6Ly9lYzItMTgtMTMwLTE1NC01Ny5ldS13ZXN0LTIuY29tcHV0ZS5hbWF6b25hd3MuY29t.K9CVN2fXY-ghHu4XCVKoulhHt7tlm8XxL6Xj5-LSgQM';
  this.paymentMethodForm = new paymentMethodForm();
  this.showPayButton = ko.observable(true);
  this.enable3DS2 = ko.observable(false);
  this.populateFakeAddress = ko.observable(true);
  this.dropIn = ko.observable(true);
  this.havePaymentMethods = ko.observable(false);
  this.enableStoreDetails = ko.observable(true);
  this.apiUrlOrMethod = ko.observable('');
  this.apiRequest = ko.observable('');
  this.apiResponse = ko.observable('');
  this.redirectAction = {};
  this.redirPrettyPrint = ko.observable('');
  this.pspReference = ko.observable('');
  this.canCapture = ko.observable(false);
  this.threeDSAuthenticationOnly = ko.observable(false);
  this.tokenizeOnly = ko.observable(false);
  this.paymentData = ko.observable('');
  this.enableL2Data = ko.observable(false);
  this.costEstimateComplete = ko.observable(false);

  this.splitAmount = ko.observable(0);
  this.accountCodeSplit = ko.observable('');

  this.diffCardOptions = ko.observableArray([
    {label: "Normal", number: "4988438843884305", expire: "03/30", cvc: "737"},
    {label: "3DS1", number: "5212345678901234", expire: "10/20", cvc: "737"},
    {label: "3DS2", number: "4917610000000000", expire: "03/30", cvc: "737"}
  ]);

  this.recurringProcessingModelOptions = ko.observableArray([
    "",
    "CardOnFile",
    "Subscription",
    "UnscheduledCardOnFile"
  ]);

  this.recurringProcessingModel = ko.observable("");

  this.payUZAEFT = function() {
    self.payMethodData = {paymentMethod: {type: "payu_ZA_eftpro"}};
    self.submitPayment();
  }

  this.submitPaymentMethods = function() {
    this.havePaymentMethods(false);

    this.paymentMethodForm.submitMethodRequest()
    .then(data => {
      self.havePaymentMethods(true);
      self.populatePostman(data);

      self.adyenCheckout = new window.AdyenCheckout(self.buildConfig(data.response));

      let checkOptions = self.generateDropInConfig();

      if (self.dropIn()) {
        if (self.dropInObj)
          self.dropInObj.mount("#dropin-container");
        else
          self.dropInObj = self.adyenCheckout.create("dropin", checkOptions).mount("#dropin-container");
      } else {
        self.buildComponents(data.response, checkOptions);
      }
    })
    .catch(error => {
      console.log(error);
    });
  }

  this.unmountDropin = function() {
    this.dropInObj.unmount();
    this.dropInObj.props.amount.value = 3000;
    this.dropInObj.remount();
    console.log()
  }

  this.populatePostman = function(data) {
    this.apiUrlOrMethod(data.method);
    this.apiRequest(this.jsonPrettyHighlightToId(data.request));
    this.apiResponse(this.jsonPrettyHighlightToId(data.response));
  }

  this.buildComponents = function(data, checkOptions) {
    if (self.isPayMethodSupport(data.paymentMethods, 'scheme')) {
      self.adyenCheckout.create("scheme", checkOptions).mount("#card-container");
    }

    if (self.isPayMethodSupport(data.paymentMethods, 'alipay')) {
      self.adyenCheckout.create('alipay', checkOptions).mount('#alipay-container');
    }

    if (self.isPayMethodSupport(data.paymentMethods, 'klarna')) {
      self.adyenCheckout.create("klarna", checkOptions).mount("#klarna-container");
    }

    if (self.isPayMethodSupport(data.paymentMethods, 'sepadirectdebit')) {
      self.adyenCheckout.create("sepadirectdebit", checkOptions).mount("#sepadirectdebit-container");
    }

    if (self.isPayMethodSupport(data.paymentMethods, 'interac')) {
      self.adyenCheckout.create("interac", checkOptions).mount("#interac-container");
    }

    if (self.isPayMethodSupport(data.paymentMethods, 'ideal')) {
      self.adyenCheckout.create("ideal", checkOptions).mount("#ideal-container");
    }

    if (self.isPayMethodSupport(data.paymentMethods, 'givex')) {
      self.adyenCheckout.create("giftcard", {type: 'givex', pinRequired: true, showPayButton: true}).mount("#givex-container");
    }

    if (self.isPayMethodSupport(data.paymentMethods, 'paypal')) {
      self.adyenCheckout.create("paypal", self.paypalConfig()).mount("#paypal-container");
    }

    if (self.isPayMethodSupport(data.paymentMethods, 'applepay')) {
      let applepay = self.adyenCheckout.create("applepay", self.applePayConfig());
      applepay.mount('#applepay-container')
    }

    if (self.isPayMethodSupport(data.paymentMethods, 'econtext_seven_eleven')) {
      self.adyenCheckout.create('econtext_seven_eleven').mount('jpseveneleven-container');
    }

    if (self.isPayMethodSupport(data.paymentMethods, 'econtext_stores')) {
      self.adyenCheckout.create('econtext_stores').mount('konbini-container');
    }

    if (data.storedPaymentMethods) {
      console.log(JSON.stringify(self.adyenCheckout.paymentMethodsResponse.storedPaymentMethods));
      //self.adyenCheckout.create("card", self.adyenCheckout.paymentMethodsResponse.storedPaymentMethods[0]).mount("#stored-card");
    }

    self.showPayButton(true);
  }

  function mutateNamesWeDontLike(data) {
    console.log(data);
    // data represents the /paymentMethods response from the Adyen server
    // If the payment method "type" is klarna_account, change its name to any custom name to show in Drop-In
    data.paymentMethods[6].name = "Pay in 3 with Klarna";
    // Now pass data into the Adyen Drop-In creation
    return data;
  }

  this.buildConfig = function(data) {
    let self = this;

    //data = mutateNamesWeDontLike(data);

    let obj = {
      locale: "en-GB", // The shopper's locale. For a list of supported locales, see https://docs.adyen.com/checkout/components-web/localization-components.
      environment: "test", // When you're ready to accept live payments, change the value to one of our live environments https://docs.adyen.com/checkout/components-web#testing-your-integration.
      //originKey: self.originKey, // Your website's Origin Key. To find out how to generate one, see https://docs.adyen.com/user-management/how-to-get-an-origin-key.
      clientKey: self.clientKey,
      translations: {'en-GB': {'payButton': "Pay", 'confirmPreauthorization': 'Save Card and Sign Up!'}},
      paymentMethodsResponse: data, // The payment methods response returned in step 1.
      onChange: function (state, component) {
        console.log(state);
        if (state.isValid) {
          self.payMethodData = state.data;
        }

        if (state.data.paymentMethod && state.data.paymentMethod.encryptedCardNumber && !self.costEstimateComplete()) {
          self.doCostEstimate(state.data.paymentMethod.encryptedCardNumber);
        }
      },
      onAdditionalDetails: function (state, component) {
        console.log("onAdditionalDetails: ", state);
        state.data.threeDSAuthenticationOnly = self.threeDSAuthenticationOnly();
        self.getPaymentDetails(state.data);
      },
      onSubmit: function (state, component) {
        self.payMethodData = state.data;
        self.submitPayment(component);
      },
      onSelect: function(component) {
        console.log(component);
      },
      onError: function(e) {
        console.log(e);
      }
    }

    return obj;
  }

  this.changeTokenOnly = function(obj, event) {
    if (obj.tokenizeOnly()) {
      this.paymentMethodForm.amount(0);
      this.submitPaymentMethods();
    }
  }

  this.isPayMethodSupport = function(payMethods, type) {
    var result = payMethods.filter(obj => {
      return obj.type === type
    });

    if (type != 'scheme' && this.tokenizeOnly()) {
      return false;
    } else {
      return result.length > 0;
    }
  }

  this.hidePaymentSubmit = function() {
    self.dropInObj.submit();
  }

  this.submitPayment = function(component) {
    let self = this;
    if (component) {
      self.myComponent = component;
    }

    if (parseInt(this.splitAmount()) > parseInt(this.paymentMethodForm.amount())) {
      alert("Split can't be greater than amount!");
      return;
    }

    $.ajax({
      url: this.enable3DS2() ? '/api/adyen/makePayment3DS2' : '/api/adyen/makePaymentSimple',
      dataType: 'json',
      type: 'post',
      data: self.paymentJson(this.enable3DS2()),
      success: function(retData, textStatus, jQxhr) {
        self.populatePostman(retData);
        let data = retData.response;

        if (data.action && data.action.paymentData) {
          self.paymentData(data.action.paymentData);
        }

        if (data.resultCode && data.resultCode == "Authorised") {
          $('#successModal').modal('toggle');
          self.pspReference(data.pspReference);
          self.canCapture(true);
          self.adyenCheckout.create('donation', self.generateDonationConfig()).mount('#donation-container');
        }

        if (data.action && data.action.type && (data.action.type == 'threeDS2Fingerprint' || data.action.type == 'threeDS2Challenge')) {
          self.adyenCheckout.createFromAction(data.action).mount('#action-container');
        } else if (data.action && data.action.type && data.action.type == 'redirect') {
          self.redirPrettyPrint(self.jsonPrettyHighlightToId(data.action));
          self.redirectAction = data.action;
          $('#redirectModal').modal('toggle');
        } else if (data.action && data.action.type && data.action.type == 'sdk') {
          self.dropInObj.handleAction(data.action).mount('#action-container');
        } else if (data.action && data.action.type && data.action.type == 'voucher') {
          self.adyenCheckout.createFromAction(data.action).mount('#action-container');
        } else if (data.action && data.action.type && data.action.type == 'qrCode' && data.action.paymentMethodType == "klarna") {
          // KLARNA WIDGET
          let klarnaToken = data.redirect.data["klarnapayments.client_token"];
          console.log(klarnaToken);
          Klarna.Payments.init({
            client_token: klarnaToken
          });

          Klarna.Payments.load({
            container: '#klarna-payments-container',
            payment_method_category: 'pay_later'
          }, function (res) {
            console.debug(res);
          });

          setTimeout(function() {
            Klarna.Payments.authorize(
              {payment_method_category: 'pay_later', auto_finalize: true},
              {},
              function(res) {
                console.log(res)
                let obj = {};

                obj.data = {
                  paymentData: self.paymentData(),
                  details: {
                    token: res.authorization_token
                  }
                };

                self.adyenCheckout.options.onAdditionalDetails(obj, undefined);
                console.log(res);
            })
          }, 5000);
        }
      },
      error: function(jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  }

  this.submitCapture = function() {
    let self = this;

    $.ajax({
      url: '/api/adyen/capturePayment',
      dataType: 'json',
      type: 'post',
      data: {
        "originalReference" : self.pspReference(),
        "merchantAccount" : self.paymentMethodForm.merchantAccount(),
        "modificationAmount" : {
          "value" : parseInt(self.paymentMethodForm.amount()),
          "currency" : self.paymentMethodForm.currency()
        }
      },
      success: function(retData, textStatus, jQxhr) {
        self.populatePostman(retData);
      },
      error: function(jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  }

  this.getPaymentDetails = function(data) {
    let self = this;

    $.ajax({
      url: '/api/adyen/paymentDetails',
      dataType: 'json',
      type: 'post',
      data: {data: data},
      success: function(retData, textStatus, jQxhr) {
        self.populatePostman(retData);
        let data = retData.response;
        if (data.resultCode && data.resultCode == "Authorised") {
          $('#successModal').modal('toggle');
          self.pspReference(data.pspReference);
          self.canCapture(true);
        }

        if (data.action && data.action.type && (data.action.type == 'threeDS2Fingerprint' || data.action.type == 'threeDS2Challenge')) {
          self.adyenCheckout.createFromAction(data.action).mount('#action-container');
        }
      },
      error: function(jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  }

  this.submitDonation = function(amount) {
    let self = this;

    $.ajax({
      url: '/api/adyen/submitDonation',
      dataType: 'json',
      type: 'post',
      data: self.donationJson(amount),
      success: function(retData, textStatus, jQxhr) {
        self.populatePostman(retData);
        alert("Thank you for your donation to Macmillan Cancer Support!");
      },
      error: function(jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  }

  this.donationJson = function(amount) {
    let obj = {};
    obj.modificationAmount = amount;
    obj.reference = this.paymentMethodForm.reference();
    obj.merchantAccount = this.paymentMethodForm.merchantAccount();
    obj.originalReference = this.pspReference();
    obj.donationAccount = "AdyenGivingDemo";
    return obj;
  }

  this.doCostEstimate = function(encCard) {
    let self = this;
    this.costEstimateComplete(true);

    $.ajax({
      url: '/api/adyen/doCostEstimate',
      dataType: 'json',
      type: 'post',
      data: self.costEstimateJson(encCard),
      success: function(retData, textStatus, jQxhr) {
        self.populatePostman(retData);
        alert("Cost Estimate API has been run, please check the results on the left and modify your payment request accordingly");
      },
      error: function(jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  }

  this.costEstimateJson = function(encCard) {
    let obj = {};
    obj.amount = {};
    obj.amount.value = parseInt(this.paymentMethodForm.amount());
    obj.amount.currency = this.paymentMethodForm.currency();
    obj.encryptedCardNumber = encCard;
    obj.merchantAccount = this.paymentMethodForm.merchantAccount();
    return obj;
  }

  this.paymentJson = function(threeds) {
    let obj = {};

    obj.amount = {};
    obj.amount.value = parseInt(this.paymentMethodForm.amount());
    obj.amount.currency = this.paymentMethodForm.currency();
    obj.merchantAccount = this.paymentMethodForm.merchantAccount();
    obj.reference = this.paymentMethodForm.reference();
    obj.countryCode = this.paymentMethodForm.countryCode();
    obj.shopperReference = this.paymentMethodForm.shopperReference();

    obj.payData = self.payMethodData;
    obj.allow3DS2 = false;
    obj.channel = this.paymentMethodForm.channel();

    if (this.recurringProcessingModel()) {
      obj.recurringProcessingModel = this.recurringProcessingModel()
    }

    if (threeds) {
      obj.populateFakeAddress = this.populateFakeAddress();
      obj.allow3DS2 = true;
      obj.origin = window.location.origin;
      obj.threeDSAuthenticationOnly = this.threeDSAuthenticationOnly();
    }

    // Provide Split!
    if (this.paymentMethodForm.merchantAccount() == 'JamieAdyenTestMP') {
      if (this.splitAmount() && this.accountCodeSplit()) {
        obj.splitAmount = this.splitAmount();
        obj.accountCodeSplit = this.accountCodeSplit();
      }
    }

    obj.enableL2Data = this.enableL2Data();

    return obj;
  }

  this.jsonPrettyHighlightToId = function(jsonobj) {
    var json = JSON.stringify(jsonobj, undefined, 2);

    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    json = json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
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

  this.followRedirect = function() {
    //this.dropInObj.handleAction(this.redirectAction);
    this.adyenCheckout.createFromAction(this.redirectAction).mount('#action-container');
  }

  this.generateDropInConfig = function() {
    let obj = {
      paymentMethodsConfiguration: {
        card: {
          onBrand: function(e) {
            console.log(e);
          },
          onBinValue: function(e) {
            console.log(e);
          }
        }
      }
    };
    // Require 3DS data if we are enabling it
    if (this.enable3DS2()) {
      obj.paymentMethodsConfiguration.card.holderNameRequired = true;
      obj.paymentMethodsConfiguration.card.hasHolderName = true;
      if (!this.populateFakeAddress()) {
        obj.paymentMethodsConfiguration.card.billingAddressRequired = true;
      }
    }
    obj.paymentMethodsConfiguration.card.enableStoreDetails = this.enableStoreDetails() && !this.tokenizeOnly();
    obj.paymentMethodsConfiguration.paywithgoogle = this.gPayConfig();
    obj.paymentMethodsConfiguration.applepay = this.applePayConfig();
    obj.paymentMethodsConfiguration.paypal = this.paypalConfig();
    obj.showPayButton = self.showPayButton();
    obj.amount = {value: self.paymentMethodForm.amount(), currency: self.paymentMethodForm.currency()};

    obj.onError = function(error) {
      console.log(error);
    }

    return obj;
  }

  this.generateDonationConfig = function() {
    let obj = {
      amounts: {
        currency: this.paymentMethodForm.currency(),
        values: [300, 500, 1000]
      },
      backgroundUrl: "https://cdn.macmillan.org.uk/dfsmedia/1a6f23537f7f4519bb0cf14c45b2a629/459-50035/information-and-support-homepage-ambient-video-thumbnail",
      description: "Macmillan Cancer Support is committed to improving the lives of everyone affected by cancer and inspiring others to do the same.",
      logoUrl: "https://cdn.macmillan.org.uk/cancer-information-and-support/-/media/project/macmillan/shared/macmillan-logo.svg",
      name: "Macmillan Cancer Support",
      url: "https://www.macmillan.org.uk/",
      showCancelButton: true,
      onDonate: function(state, component) {
        self.submitDonation(state.data.amount);
      },
      onCancel: function(state, component) {
        console.log(state);
      }
    }
    return obj;
  }

  this.gPayConfig = function() {
    let obj = { // Example required configuration for Google Pay
      environment: "TEST", // Change this to PRODUCTION when you're ready to accept live Google Pay payments
      amount: {
        currency: this.paymentMethodForm.currency(),
        value: this.paymentMethodForm.amount()
      },
      configuration: {
        gatewayMerchantId: this.paymentMethodForm.merchantAccount(), // Your Adyen merchant or company account name
        //merchantIdentifier: "12345678910111213141", // Required for PRODUCTION. Remove this object in TEST. Your Google Merchant ID as described in https://developers.google.com/pay/api/web/guides/test-and-deploy/deploy-production-environment#obtain-your-merchantID
        merchantName: "Jamie Gpay Test" // Optional. The name that appears in the payment sheet.
      },
      buttonColor: "white" //Optional. Use a white Google Pay button.
    }
    return obj;
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

  this.applePayConfig = function() {
    let self = this;

    let obj = { // Required configuration for Apple Pay
      amount: "5700",
      currencyCode: this.paymentMethodForm.currency(),
      countryCode: this.paymentMethodForm.countryCode(),
      supportedNetworks: ['visa', 'mastercard'],
      //totalPriceLabel: 'Test Fix',
      configuration: {
        merchantName: 'Jamie White Test ApplePay', // Name to be displayed on the form
        merchantIdentifier: 'merchant.com.adyen.JamieAdyenTestECOM.test' // Your Apple merchant identifier as described in https://developer.apple.com/documentation/apple_pay_on_the_web/applepayrequest/2951611-merchantidentifier
      },
      // requiredShippingContactFields: [
      //   "postalAddress",
      //   "name",
      //   "phoneticName",
      //   "phone",
      //   "email"
      // ],
      onValidateMerchant: async (resolve, reject, validationURL) => {
        let response = await testAwait(validationURL);
        resolve(response);
      },
      onAuthorized: (resolve, reject, event) => {
        // address data, payment token, all in event
        console.log(event);
        // If you see an error, or the payment object is missing something you need, fail it
        // This will cause the Apple payment sheet to show the red X with "Payment not complete"
        // Example here is if no token was Returned from Apple, failure
        // NOTE: the Apple simulator does not return a token with the simulator card
        if (!event.payment.token || !event.payment.token.paymentData) {
          // Can also fail it for address reasons, then show some DOM validation on your page
          reject('FAIL IT');
        } else {
          // resolve() this function if you want the Apple Pay sheet to show "complete"
          // You can still not process the payment, and show them some other validation issue if you want
          // If everything in here is fine, you resolve this promise, which finishes the ApplePay with a checkbox
          // We have our apple pay token, proceed with the server side payment processing

          let localState = {
            data: {
              paymentMethod: {
                type: "applepay",
                "applepay.token": event.payment.token.paymentData
              }
            },
            isValid: true
          }
          // Don't need component object, this can also be your handleOnSubmit
          //handleOnAuthorizedSubmit(localState, undefined);
          // You can also call your component.submit() function, see triggering the submit flow on your own:
          // https://docs.adyen.com/checkout/components-web#configuring-components
          resolve('Everything went well'); // Customer won't see text, just shows Apple Pay sheet completion
        }
      },
      // No matter the outcome of the above, onSubmit will get called regardless
      // as it is called right after onAuthorised in the Adyen Apple Pay Service
      onSubmit: (state, component) => {
        console.log(state);
        if (!state.data.paymentMethod['applepay.token']) {
          // If there is no applepay token, something went wrong of which more $details
          // may be in the onAuthorized
          console.log('No apple pay token received');
        } else {
          // We have our apple pay token, proceed with the server side payment processing
          self.adyenCheckout.options.onSubmit(state, component);
        }
      }
    }
    return obj;
  }

  this.paypalConfig = function() {
    let obj = {
      intent: 'authorize',
      merchantId: 'LFVS99UNVDAUJ',
      environment: "test", // Change this to "live" when you're ready to accept live PayPal payments
      countryCode: this.paymentMethodForm.countryCode(), // Only needed for test. This will be automatically retrieved when you are in production
      amount: {
        currency: this.paymentMethodForm.currency(),
        value: this.paymentMethodForm.amount()
      },
      onCancel: (data, component) => {
          component.setStatus('ready');
          // Sets your prefered status of the component when a PayPal payment is cancelled. In this example, return to the initial state.
      }
    };

    return obj;
  }
}
window.my = { viewModel: new contentsKnockoutObj() };
ko.applyBindings(window.my.viewModel);
