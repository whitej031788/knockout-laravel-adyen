import { paymentMethodForm } from './partials/pay-method-component.js';

function contentsKnockoutObj() {
  let self = this;

  this.originKey = 'pub.v2.8215833140141788.aHR0cDovL2xvY2FsaG9zdDo4MDAw.MW9tDxjt-oSAYUwbdk6t2rHwZR3oXERpM4fYhaS3ong';
  this.paymentMethodForm = new paymentMethodForm();
  this.showPayButton = ko.observable(false);
  this.enablePayButton = ko.observable(false);
  this.enable3DS2 = ko.observable(false);
  this.populateFakeAddress = ko.observable(true);

  this.submitPaymentMethods = function() {
    var checkOptions = {
      enableStoreDetails: true
    };

    if (this.enable3DS2()) {
      checkOptions = {
       hasHolderName: true,
       holderNameRequired: true,
       enableStoreDetails: true
      };

      if (!this.populateFakeAddress()) {
        checkOptions.billingAddressRequired = true;
      }
    }
    this.paymentMethodForm.submitMethodRequest()
    .then(data => {
      self.adyenCheckout = new window.AdyenCheckout(self.buildConfig(data));
      self.createSecureFields();
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
      console.log(data);
    })
    .catch(error => {
      console.log(error);
    });
  }

  this.buildConfig = function(data) {
    let self = this;

    let obj = {
      locale: "en_US", // The shopper's locale. For a list of supported locales, see https://docs.adyen.com/checkout/components-web/localization-components.
      environment: "test", // When you're ready to accept live payments, change the value to one of our live environments https://docs.adyen.com/checkout/components-web#testing-your-integration.
      originKey: self.originKey, // Your website's Origin Key. To find out how to generate one, see https://docs.adyen.com/user-management/how-to-get-an-origin-key.
      paymentMethodsResponse: data, // The payment methods response returned in step 1.
      onChange: function (state, component) {
        if (state.isValid) {
          self.enablePayButton(true);
          self.payMethodData = state.data;
        } else {
          self.enablePayButton(false);
        }
        console.log(state);
      },
      onAdditionalDetails: function (state, component) {
        console.log(state);
        self.getPaymentDetails(state.data);
      },
      onSubmit: function (state, component) {
        self.payMethodData = state.data;
        self.submitPayment();
        console.log(state);
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
      success: function(data, textStatus, jQxhr) {
        if (data.action && data.action.type && (data.action.type == 'threeDS2Fingerprint' || data.action.type == 'threeDS2Challenge')) {
          self.adyenCheckout.createFromAction(data.action).mount('#action-container');
        } else if (data.action && data.action.type && data.action.type == 'redirect') {
          self.adyenCheckout.createFromAction(data.action).mount('#action-container');
        }
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
      success: function(data, textStatus, jQxhr) {
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
      onChange: function(data) {console.log(data)},
      onValid : function() {},
      onLoad: function() {},
      onConfigSuccess: function() {},
      onFieldValid : function() {},
      onBrand: function() {},
      onError: function() {},
      onFocus: function() {},
      onBinValue: function(bin) {console.log(bin)}
    }).mount('#customCard-container');
  }
}

ko.applyBindings(new contentsKnockoutObj());
