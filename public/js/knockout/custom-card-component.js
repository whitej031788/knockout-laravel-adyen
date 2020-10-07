import { paymentMethodForm } from './partials/pay-method-component.js';

function contentsKnockoutObj() {
  let self = this;
  /* localhost */
  this.originKey = 'pub.v2.8215833140141788.aHR0cDovL2xvY2FsaG9zdDo4MDAw.MW9tDxjt-oSAYUwbdk6t2rHwZR3oXERpM4fYhaS3ong';
  /* EC2 */
  //this.originKey = 'pub.v2.8215833140141788.aHR0cHM6Ly9lYzItMTgtMTMwLTE1NC01Ny5ldS13ZXN0LTIuY29tcHV0ZS5hbWF6b25hd3MuY29t.K9CVN2fXY-ghHu4XCVKoulhHt7tlm8XxL6Xj5-LSgQM';
  this.paymentMethodForm = new paymentMethodForm();
  this.havePaymentMethods = ko.observable(false);
  this.apiUrlOrMethod = ko.observable('');
  this.apiRequest = ko.observable('');
  this.apiResponse = ko.observable('');
  this.diffCardOptions = ko.observableArray([
    {label: "Normal", number: "4988438843884305", expire: "03/30", cvc: "737"},
    {label: "3DS1", number: "5212345678901234", expire: "10/20", cvc: "737"},
    {label: "3DS2", number: "4917610000000000", expire: "03/30", cvc: "737"}
  ]);

  this.submitPaymentMethods = function() {
    this.havePaymentMethods(false);

    this.paymentMethodForm.submitMethodRequest()
    .then(data => {
      self.havePaymentMethods(true);
      self.populatePostman(data);

      self.adyenCheckout = new window.AdyenCheckout(self.buildConfig('en-GB'));

      self.createSecureFields();
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

  this.buildConfig = function(locale) {
    let self = this;

    let obj = {
      //locale: "en-US",
      locale: locale, // The shopper's locale. For a list of supported locales, see https://docs.adyen.com/checkout/components-web/localization-components.
      environment: "test", // When you're ready to accept live payments, change the value to one of our live environments https://docs.adyen.com/checkout/components-web#testing-your-integration.
      originKey: self.originKey, // Your website's Origin Key. To find out how to generate one, see https://docs.adyen.com/user-management/how-to-get-an-origin-key.
      onChange: function (state, component) {
        console.log('checkout onChange', state);
      }
    }

    return obj;
  }

  this.submitPayment = function() {
    let self = this;

    $.ajax({
      url: '/api/adyen/makePaymentSimple',
      dataType: 'json',
      type: 'post',
      data: self.paymentJson(),
      success: function(retData, textStatus, jQxhr) {
        self.populatePostman(retData);
        let data = retData.response;
        console.log(data);
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

    return obj;
  }

  this.createSecureFields = function() {
    let self = this;

    const styles = {
      "base": {
        "color": "#2B2A35",
        "fontFamily": "Lato, Helvetica, \"Trebuchet MS\", \"Adobe Heiti Std\", \"Segoe UI\", sans‑serif",
        "fontSize": "14px",
        "fontSmoothing": "antialiased",
        "fontWeight": 400
      },
      "error": {
        "color": "#2B2A35"
      },
      "placeholder": {
        "color": "#9393A8",
        "fontSize": "13px",
        "fontSmoothing": "antialiased",
        "fontWeight": 400
      }
    }

    self.customCard = self.adyenCheckout.create('securedfields', {
      placeholders: {
        encryptedCardNumber: 'Card Number',
        encryptedExpiryDate: 'MM/YY',
        encryptedSecurityCode: 'CVV'
      },
      // Optional configuration
      type: 'card',
      brands: ['mc', 'visa', 'amex', 'bcmc', 'maestro'],
      styles: {
        base: {
          color: "#001b2b",
          fontSize: "16px",
          fontWeight: "400"
        },
        placeholder: {
          color: "#90a2bd",
          fontWeight: "200"
        },
        error: {
          color: "#001b2b"
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
        console.log('fields level onchange', data);
      },
      onValid : function(state) {
        self.payMethodData = state.data;
        document.getElementById("secureButton").focus();
        //self.submitPayment();
      },
      onLoad: function() {},
      onConfigSuccess: function() {},
      onFieldValid : function(e) {
        console.log('on field valid', e);
      },
      onBrand: function(e) {
        console.log('onBrand', e);
      },
      onError: function(e) {
        console.log('error', e);
      },
      onAutoComplete: function(e) {
        console.log('auto', e);
      },
      onFocus: function(e) {
        //console.log(e)
      },
      onBinValue: function(bin) {
        console.log('bin value', bin)
      },
      styles: styles
    }).mount('#customCard-container');
  }

  this.unmountAndRemount = function() {
    this.customCard.unmount(); // This is the securefields object unmounted from the DOM
    this.adyenCheckout = new window.AdyenCheckout(self.buildConfig('de-DE')); // new checkout with new locale
    this.createSecureFields(); // this function creates a new securefields object and mounts it with new placeholders
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
}

ko.applyBindings(new contentsKnockoutObj());
