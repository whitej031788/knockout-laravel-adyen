import { paymentMethodForm } from './partials/pay-method-component.js';

function contentsKnockoutObj() {
  let self = this;

  this.originKey = 'pub.v2.8215833140141788.aHR0cDovL2xvY2FsaG9zdDo4MDAw.MW9tDxjt-oSAYUwbdk6t2rHwZR3oXERpM4fYhaS3ong';
  this.paymentMethodForm = new paymentMethodForm();
  this.showPayButton = ko.observable(false);
  this.enablePayButton = ko.observable(false);
  this.enable3DS2 = ko.observable(false);
  this.populateFakeAddress = ko.observable(true);
  this.dropIn = ko.observable(true);
  this.secureFields = ko.observable(false);
  this.havePaymentMethods = ko.observable(false);
  this.enableStoreDetails = ko.observable(true);
  this.apiUrlOrMethod = ko.observable('');
  this.apiRequest = ko.observable('');
  this.apiResponse = ko.observable('');
  this.redirectAction = {};
  this.redirPrettyPrint = ko.observable('');
  this.pspReference = ko.observable('');
  this.canCapture = ko.observable(false);

  this.submitPaymentMethods = function() {
    this.havePaymentMethods(false);

    var checkOptions = {
      paymentMethodsConfiguration: {
        card: {}
      }
    };

    if (this.enableStoreDetails()) {
      checkOptions.paymentMethodsConfiguration.card.enableStoreDetails = true;
    }

    if (this.enable3DS2()) {
      checkOptions.paymentMethodsConfiguration.card.holderNameRequired = true;
      checkOptions.paymentMethodsConfiguration.card.hasHolderName = true;
      if (!this.populateFakeAddress()) {
        checkOptions.paymentMethodsConfiguration.card.billingAddressRequired = true;
      }
    }

    checkOptions.paymentMethodsConfiguration.paywithgoogle = this.gPayConfig();

    this.paymentMethodForm.submitMethodRequest()
    .then(data => {
      self.havePaymentMethods(true);
      self.populatePostman(data);

      self.adyenCheckout = new window.AdyenCheckout(self.buildConfig(data.response));

      if (self.secureFields()) {
        self.createSecureFields();
      } else if (self.dropIn()) {
        self.dropInObj = self.adyenCheckout.create("dropin", checkOptions).mount("#dropin-container");
      } else {
        self.buildComponents(data.response, checkOptions);
      }
    })
    .catch(error => {
      console.log(error);
    });
  }

  this.populatePostman = function(data) {
    this.apiUrlOrMethod(data.method);
    this.apiRequest(this.jsonPrettyHighlightToId(data.request));
    this.apiResponse(this.jsonPrettyHighlightToId(data.response));
  }

  this.buildComponents = function(data, checkOptions) {
    if (self.isPayMethodSupport(data.paymentMethods, 'scheme')) {
      self.adyenCheckout.create("card", checkOptions).mount("#card-container");
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
    self.showPayButton(true);
  }

  this.buildConfig = function(data) {
    let self = this;

    let obj = {
      locale: "en_US", // The shopper's locale. For a list of supported locales, see https://docs.adyen.com/checkout/components-web/localization-components.
      environment: "test", // When you're ready to accept live payments, change the value to one of our live environments https://docs.adyen.com/checkout/components-web#testing-your-integration.
      originKey: self.originKey, // Your website's Origin Key. To find out how to generate one, see https://docs.adyen.com/user-management/how-to-get-an-origin-key.
      paymentMethodsResponse: data, // The payment methods response returned in step 1.
      showPayButton: true,
      onChange: function (state, component) {
        if (state.isValid) {
          self.enablePayButton(true);
          self.payMethodData = state.data;
        } else {
          self.enablePayButton(false);
        }
      },
      onAdditionalDetails: function (state, component) {
        self.getPaymentDetails(state.data);
      },
      onSubmit: function (state, component) {
        self.payMethodData = state.data;
        self.submitPayment();
      }
    }

    return obj;
  }

  this.isPayMethodSupport = function(payMethods, type) {
    var result = payMethods.filter(obj => {
      return obj.type === type
    });

    return result.length > 0;
  }

  this.submitPayment = function() {
    let self = this;

    $.ajax({
      url: this.enable3DS2() ? '/api/adyen/makePayment3DS2' : '/api/adyen/makePaymentSimple',
      dataType: 'json',
      type: 'post',
      data: self.paymentJson(this.enable3DS2()),
      success: function(retData, textStatus, jQxhr) {
        self.populatePostman(retData);
        let data = retData.response;
        if (data.resultCode && data.resultCode == "Authorised") {
          self.pspReference(data.pspReference);
          self.canCapture(true);
        }

        if (data.action && data.action.type && (data.action.type == 'threeDS2Fingerprint' || data.action.type == 'threeDS2Challenge')) {
          self.adyenCheckout.createFromAction(data.action).mount('#action-container');
        } else if (data.action && data.action.type && data.action.type == 'redirect') {
          self.redirPrettyPrint(self.jsonPrettyHighlightToId(data.action));
          self.redirectAction = data.action;
          $('#redirectModal').modal('toggle');
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

    if (threeds) {
      obj.populateFakeAddress = this.populateFakeAddress();
      obj.allow3DS2 = true;
      obj.origin = window.location.origin;
    }

    return obj;
  }

  this.createSecureFields = function() {
    const customCard = self.adyenCheckout.create('securedfields', {
      // Optional configuration
      type: 'card',
      brands: ['mc', 'visa', 'amex', 'bcmc', 'maestro'],
      styles: {
          error: {
              color: 'red'
          },
          validated: {
              color: 'green'
          },
          placeholder: {
              color: '#d8d8d8'
          }
      },
      ariaLabels: {
          lang: 'en-GB',
          encryptedCardNumber: {
              label: 'Credit or debit card number field'
          }
      },
      // Events
      onChange: function(data) {
        console.log(data)
      },
      onValid : function(e) {
        console.log(e);
      },
      onLoad: function() {},
      onConfigSuccess: function() {},
      onFieldValid : function(e) {
        console.log(e);
      },
      onBrand: function() {},
      onError: function(e) {
        console.log('test', e);
      },
      onFocus: function() {},
      onBinValue: function(bin) {console.log(bin)}
    }).mount('#customCard-container');
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
    this.adyenCheckout.createFromAction(this.redirectAction).mount('#action-container');
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
      buttonColor: "white", //Optional. Use a white Google Pay button.
      //For other optional configuration, see section below.
      onChange: (state) => {
        console.log(state);
      },
      onSubmit: (state) => {
        self.payMethodData = state.data;
        self.submitPayment();
        console.log(state);
      },
      onAuthorized: (data) => {
        console.log(data);
      }
    }
    return obj;
  }
}

ko.applyBindings(new contentsKnockoutObj());
