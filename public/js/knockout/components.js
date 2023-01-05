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
  this.populateFakeAddress = ko.observable(false);
  this.dropIn = ko.observable(true);
  this.enableSessions = ko.observable(false);
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
  this.enableCostEstimate = ko.observable(false);
  this.costEstimateComplete = ko.observable(false);
  this.donationToken = ko.observable();
  this.giftCardPayment = ko.observable(0);
  this.orderPsp = ko.observable('');
  this.orderData = ko.observable('');
  this.deliveryDate = ko.observable('');
  this.enableAirlineData = ko.observable(false);
  this.enableLodgingData = ko.observable(false);

  this.splits = ko.observableArray([]);

  this.addSplit = function() {
    self.splits.push({amount: 0, account: ''});
  }

  this.removeSplit = function(split) {
    self.splits.remove(split);
  }

  this.basketItems = ko.observableArray([]);

  this.addBasketItem = function() {
    self.basketItems.push({productTitle: '', quantity: 1, sku: ''});
  }

  this.removeBasketItem = function(item) {
    self.basketItems.remove(item);
  }

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

    let orderObj = null;

    if (this.orderPsp() && this.orderData()) {
      orderObj = {
        orderData: this.orderData(),
        pspReference: this.orderPsp()
      };
    }

    // Use the old /payments API endpoint
    if (!this.enableSessions()) {
      this.paymentMethodForm.submitMethodRequest(orderObj)
      .then(data => {
        self.havePaymentMethods(true);
        self.populatePostman(data);

        if (self.adyenCheckout && orderObj) {
          self.adyenCheckout.update({ paymentMethodsResponse: data.response, order: orderObj, amount:{value:100,currency:'GBP'} });
        } else {
          (async function() {
            self.adyenCheckout = await window.AdyenCheckout(self.buildConfig(data.response));

            let checkOptions = self.generateDropInConfig();

            if (self.dropIn()) {
              if (self.dropInObj) {
                self.dropInObj("#dropin-container");
              } else {
                var element = document.getElementById('dropin-container');
                self.dropInObj = self.adyenCheckout.create("dropin", checkOptions).mount(element);
              }
            } else {
              self.buildComponents(data.response, checkOptions);
            }
          })();
        }
      })
      .catch(error => {
        console.log(error);
      });
    } else {
      this.paymentMethodForm.submitSessionRequest()
      .then(data => {
        self.havePaymentMethods(true);
        self.populatePostman(data);

        if (self.adyenCheckout && orderObj) {
          self.adyenCheckout.update({ paymentMethodsResponse: data.response, order: orderObj, amount:{value:100,currency:'GBP'} });
        } else {
          (async function() {
            self.adyenCheckout = await window.AdyenCheckout(self.buildSessionConfig(data.response));

            let checkOptions = self.generateDropInConfig();

            if (self.dropIn()) {
              if (self.dropInObj) {
                self.dropInObj("#dropin-container");
              } else {
                var element = document.getElementById('dropin-container');
                self.dropInObj = self.adyenCheckout.create("dropin", checkOptions);
                self.dropInObj.mount(element);
              }
            } else {
              self.buildComponents(data.response, checkOptions);
            }
          })();
        }
      })
      .catch(error => {
        console.log(error);
      });
    }
  }

  this.unmountDropin = function() {
    this.dropInObj.unmount();
    console.log(this.dropInObj.props)
    this.dropInObj.props.showPaymentMethods = true;
    this.dropInObj.remount();
  }

  this.testOrderUpdate = function() {
    //self.adyenCheckout.update();
    console.log(self.adyenCheckout);
    self.paymentMethodForm.amount('500');
    //self.adyenCheckout.update({ order: {remainingAmount: 500}, amount: {value: 500000, currency: "GBP"}});
    self.adyenCheckout.update(this.buildConfig(self.adyenCheckout.paymentMethodsResponse));
    console.log(self.adyenCheckout);
  }

  this.populatePostman = function(data) {
    this.apiUrlOrMethod(data.method);
    this.apiRequest(this.jsonPrettyHighlightToId(data.request));
    this.apiResponse(this.jsonPrettyHighlightToId(data.response));
  }

  this.buildComponents = function(data, checkOptions) {
      try {
      if (self.isPayMethodSupport(data.paymentMethods, 'scheme')) {
        checkOptions.onBrand = function(e) {console.log('onBrand', e)};
        checkOptions.onFieldValid = function(e) {console.log('onFieldValid', e)};
        checkOptions.onBinValue = function(e) {console.log('onBinValue', e)};
        self.adyenCheckout.create("scheme", checkOptions).mount("#card-container");
      }

      // if (self.isPayMethodSupport(data.paymentMethods, 'alipay')) {
        self.adyenCheckout.create('alipay', checkOptions).mount('#alipay-container');
      // }

      if (self.isPayMethodSupport(data.paymentMethods, 'klarna')) {
        self.adyenCheckout.create("klarna", checkOptions).mount("#klarna-container");
      }

      if (self.isPayMethodSupport(data.paymentMethods, 'sepadirectdebit')) {
        self.adyenCheckout.create("sepadirectdebit", checkOptions).mount("#sepadirectdebit-container");
      }

      if (self.isPayMethodSupport(data.paymentMethods, 'directdebit_GB')) {
        self.adyenCheckout.create("directdebit_GB", checkOptions).mount("#directdebit_GB-container");
      }

      if (self.isPayMethodSupport(data.paymentMethods, 'interac')) {
        self.adyenCheckout.create("interac", checkOptions).mount("#interac-container");
      }

      if (self.isPayMethodSupport(data.paymentMethods, 'ideal')) {
        self.adyenCheckout.create("ideal", checkOptions).mount("#ideal-container");
      }

      if (self.isPayMethodSupport(data.paymentMethods, 'givex')) {
        self.adyenCheckout.create("givex", {type: 'givex', pinRequired: false, showPayButton: true}).mount("#givex-container");
      }

      if (self.isPayMethodSupport(data.paymentMethods, 'paypal')) {
        self.adyenCheckout.create("paypal", self.paypalConfig()).mount("#paypal-container");
      }

      if (self.isPayMethodSupport(data.paymentMethods, 'applepay')) {
        let applepay = self.adyenCheckout.create("applepay", self.applePayConfig());
        applepay.mount('#applepay-container')
      }

      if (self.isPayMethodSupport(data.paymentMethods, 'clearpay')) {
        self.adyenCheckout.create('clearpay', {
          translations: {"es-ES": {
            "continueTo": "Pago!"
          }}}).mount('#clearpay-container');
      }

      if (self.isPayMethodSupport(data.paymentMethods, 'afterpaytouch')) {
        self.adyenCheckout.create('afterpaytouch').mount('#afterpaytouch-container');
      }

      if (self.isPayMethodSupport(data.paymentMethods, 'econtext_seven_eleven')) {
        self.adyenCheckout.create('econtext_seven_eleven').mount('#jpseveneleven-container');
      }

      if (self.isPayMethodSupport(data.paymentMethods, 'econtext_stores')) {
        self.adyenCheckout.create('econtext_stores').mount('#konbini-container');
      }

      if (data.storedPaymentMethods) {
        console.log(JSON.stringify(self.adyenCheckout.paymentMethodsResponse.storedPaymentMethods));
        //self.adyenCheckout.create("card", self.adyenCheckout.paymentMethodsResponse.storedPaymentMethods[0]).mount("#stored-card");
      }

      self.showPayButton(true);
    } catch (err) {
      console.log('components error', err);
    }
  }

  function mutateNamesWeDontLike(data) {
    console.log(data);
    // data represents the /paymentMethods response from the Adyen server
    // If the payment method "type" is klarna_account, change its name to any custom name to show in Drop-In
    data.paymentMethods[6].name = "Pay in 3 with Klarna";
    // Now pass data into the Adyen Drop-In creation
    return data;
  }

  function addMinutes(date, minutes) {
    return new Date(date.getTime() + minutes*60000);
  }

  this.buildConfig = function(data) {
    let self = this;

    //data = mutateNamesWeDontLike(data);

    let obj = {
      // amount: {value: self.paymentMethodForm.amount(), currency: self.paymentMethodForm.currency()},
      // analytics: {
      //   enabled: false,
      //   telemetry: false
      // },
      locale: "en-GB", // The shopper's locale. For a list of supported locales, see https://docs.adyen.com/checkout/components-web/localization-components.
      environment: "test", // When you're ready to accept live payments, change the value to one of our live environments https://docs.adyen.com/checkout/components-web#testing-your-integration.
      //originKey: self.originKey, // Your website's Origin Key. To find out how to generate one, see https://docs.adyen.com/user-management/how-to-get-an-origin-key.
      clientKey: self.clientKey,
      paymentMethodsResponse: data, // The payment methods response returned in step 1.
      onChange: function (state, component) {
        console.log(state);
        if (state.isValid) {
          self.payMethodData = state.data;
        }

        if (state.data.paymentMethod && state.data.paymentMethod.encryptedCardNumber && !self.costEstimateComplete() && self.enableCostEstimate()) {
          self.doCostEstimate(state.data.paymentMethod.encryptedCardNumber);
        }
      },
      onAdditionalDetails: async (state, component) => {
        console.log("onAdditionalDetails: ", state);
        state.data.threeDSAuthenticationOnly = self.threeDSAuthenticationOnly();
        await self.getPaymentDetails(state.data);
      },
      onOrderRequest: function (resolve, reject, data) {
        $.ajax({
          url: '/api/adyen/createOrder',
          dataType: 'json',
          type: 'post',
          data: {
            "reference": self.paymentMethodForm.reference(),
            "amount" : {
              "value" : parseInt(self.paymentMethodForm.amount()),
              "currency" : self.paymentMethodForm.currency()
            },
            "merchantAccount" : self.paymentMethodForm.merchantAccount(),
            "expiresAt" : addMinutes(new Date(), 1).toISOString()
          },
          success: function(retData, textStatus, jQxhr) {
            self.populatePostman(retData);
            self.orderPsp(retData.response.pspReference);
            self.orderData(retData.response.orderData);
            resolve(retData.response);
          },
          error: function(jqXhr, textStatus, errorThrown) {
            console.log(errorThrown);
            reject('oops');
          }
        });
      },
      onBalanceCheck: function (resolve, reject, data) {
       // call /paymentMethods/balance
       if (data.paymentMethod.type = 'giftcard') {
         data.paymentMethod.type = 'giftcard';
         data.paymentMethod.brand = 'givex';
       }
       $.ajax({
         url: '/api/adyen/checkBalance',
         dataType: 'json',
         type: 'post',
         data: {
           "amount" : {
             "value" : parseInt(self.paymentMethodForm.amount()),
             "currency" : self.paymentMethodForm.currency()
           },
           "merchantAccount" : self.paymentMethodForm.merchantAccount(),
           "paymentMethod" : data.paymentMethod
         },
         success: function(retData, textStatus, jQxhr) {
           let data = retData.response;
           self.populatePostman(retData);
           if (retData.response.resultCode == "NotEnoughBalance") {
             self.giftCardPayment(retData.response.balance.value);
           }
           console.log(JSON.stringify(data));
           resolve(data);
         },
         error: function(jqXhr, textStatus, errorThrown) {
           console.log(errorThrown);
           reject('oops');
         }
       });
      },
      onSubmit: function (state, component) {
        // GIFT CARD HACK
        if (state.data.paymentMethod.type == 'giftcard') {
          state.data.paymentMethod.type = 'givex';
        }

        self.payMethodData = state.data;
        self.submitPayment(component);
        component.setStatus('ready');
      },
      onSelect: function(component) {
        console.log(component);
      },
      onError: function(e) {
        console.log(e);
      },
      showPayButton: self.showPayButton(),
      paymentMethodsConfiguration: {
        card: {
          hasHolderName: true,
          holderNameRequired: true,
          enableStoreDetails: false,
          name: "Card Label",
          hideCVC: false,
          showBillingAddress: true,
          data: {
            street: "123 main st"
          }
        },
        applepay: {
          amount: {
            value: self.paymentMethodForm.amount(),
            currency: self.paymentMethodForm.currency()
          },
          countryCode: self.paymentMethodForm.countryCode()
        },
        paywithgoogle: {
          amount: {
            value: self.paymentMethodForm.amount(),
            currency: self.paymentMethodForm.currency()
          },
          countryCode: self.paymentMethodForm.countryCode()
        }
      },
    };

    // Require 3DS data if we are enabling it
    if (this.enable3DS2()) {
      obj.paymentMethodsConfiguration.card.holderNameRequired = true;
      obj.paymentMethodsConfiguration.card.hasHolderName = true;
      if (!this.populateFakeAddress()) {
        obj.paymentMethodsConfiguration.card.billingAddressRequired = true;
        obj.paymentMethodsConfiguration.card.data.billingAddress = {};
        obj.paymentMethodsConfiguration.card.data.billingAddress.street = "123 main st";
        obj.paymentMethodsConfiguration.card.data.holderName = "Jam";
        obj.paymentMethodsConfiguration.card.billingAddressAllowedCountries = ['GB'];
      }
    }
    obj.paymentMethodsConfiguration.card.enableStoreDetails = this.enableStoreDetails() && !this.tokenizeOnly();
    // obj.paymentMethodsConfiguration.paywithgoogle = this.gPayConfig();
    // obj.paymentMethodsConfiguration.applepay = this.applePayConfig();
    obj.paymentMethodsConfiguration.paypal = this.paypalConfig();

    console.log(obj);

    return obj;
  }

  this.buildSessionConfig = function(data) {
    let self = this;

    //data = mutateNamesWeDontLike(data);

    let obj = {
      environment: "test", // When you're ready to accept live payments, change the value to one of our live environments https://docs.adyen.com/checkout/components-web#testing-your-integration.
      //originKey: self.originKey, // Your website's Origin Key. To find out how to generate one, see https://docs.adyen.com/user-management/how-to-get-an-origin-key.
      clientKey: self.clientKey,
      session: {
        id: data.id, // Unique identifier for the payment session.
        sessionData: data.sessionData // The payment session data.
      },
      onPaymentCompleted: (result, component) => {
        console.info(result, component);
      },
      onError: (error, component) => {
        console.error(error.name, error.message, error.stack, component);
      },
      // onSubmit: (state, component) => {console.log('onSubmit', state); return;},
      onBrand: (e) => {console.log('onBrand', e)},
      onSelect: (state, component) => {console.log('onSelect', state.props.type)},
      onChange: (state, component) => {console.log('onChange', state)},
      onBinValue: (e) => {console.log('onBinValue', e)},
      beforeSubmit: (data, component, actions) => {
        console.log('beforeSubmit', data);
        data.deliveryDate = '2022-11-29T10:15:30+01:00';
        actions.resolve(data);
      },
      paymentMethodsConfiguration: {
        card: {
          name: "Credit / Debit Card",
        },
      }
    };

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

    $.ajax({
      url: this.enable3DS2() ? '/api/adyen/makePayment3DS2' : '/api/adyen/makePaymentSimple',
      dataType: 'json',
      type: 'post',
      data: self.paymentJson(this.enable3DS2()),
      success: function(retData, textStatus, jQxhr) {
        self.populatePostman(retData);
        let data = retData.response;

        // gift card partial payment shit
        if (data.order && data.order?.remainingAmount?.value > 0) {
          console.log('Partial payment');
          // handle orders
          const order = {
              orderData: data.order.orderData,
              pspReference: data.order.pspReference
          };

          self.giftCardPayment(data.order?.remainingAmount?.value);

          self.paymentMethodForm.submitMethodRequest(order)
          .then(orderPaymentMethods => {
            self.populatePostman(orderPaymentMethods);
            self.adyenCheckout.update({ paymentMethodsResponse: orderPaymentMethods.response, order, amount: data.order.remainingAmount });
          });
        }

        if (data.action && data.action.paymentData) {
          self.paymentData(data.action.paymentData);
        }

        if (data.resultCode && data.resultCode == "Authorised") {
          $('#successModal').modal('toggle');
          self.pspReference(data.pspReference);
          self.canCapture(true);
          if (data.donationToken) {
            self.donationToken(data.donationToken);
            self.adyenCheckout.create('donation', self.generateDonationConfig()).mount('#donation-container');
          }
        }

        // close paypal popups
        if (retData.request.paymentMethod.type == "paypal" && data.resultCode == "Refused") {
          paypal.Buttons.instances[0].close();
        }

        if (data.action && data.action.type && (data.action.type == 'threeDS2Fingerprint' || data.action.type == 'threeDS2Challenge' || data.action.type == 'threeDS2')) {
          self.adyenCheckout.createFromAction(data.action).mount('#action-container');
        } else if (data.action && data.action.type && data.action.type == 'redirect') {
          self.redirPrettyPrint(self.jsonPrettyHighlightToId(data.action));
          self.redirectAction = data.action;
          $('#redirectModal').modal('toggle');
        } else if (data.action && data.action.type && data.action.type == 'sdk' && data.action.paymentMethodType != "klarna" && data.action.paymentMethodType != "klarna_account") {
          component.handleAction(data.action).mount('#action-container');
        } else if (data.action && data.action.type && (data.action.type == 'voucher' || data.action.type == 'qrCode')) {
          self.adyenCheckout.createFromAction(data.action).mount('#action-container');
        } else if (data.action && data.action.type && data.action.type == 'sdk' && (data.action.paymentMethodType == "klarna" || data.action.paymentMethodType == "klarna_account")) {
          // KLARNA WIDGET
          console.log(data);
          let klarnaToken = data.action.sdkData["client_token"];

          Klarna.Payments.init({
            client_token: klarnaToken
          });

          let payCategory = '';

          if (data.action.paymentMethodType == "klarna") {
            payCategory = 'pay_later';
          } else if (data.action.paymentMethodType == "klarna_account") {
            payCategory = 'pay_over_time';
          }

          Klarna.Payments.load({
            container: '#klarna-payments-container',
            payment_method_category: payCategory
          }, function (res) {
            console.debug(res);
          });

          setTimeout(function() {
            Klarna.Payments.authorize(
              {payment_method_category: payCategory, auto_finalize: true},
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

    return $.ajax({
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
    obj.paymentMethod = {};
    obj.paymentMethod.type = 'scheme';
    obj.shopperInteraction = "ContAuth";
    // obj.recurringProcessingModel = "UnscheduledCardOnFile";
    obj.amount = amount;
    obj.reference = this.paymentMethodForm.reference();
    obj.merchantAccount = this.paymentMethodForm.merchantAccount();
    obj.donationOriginalPspReference = this.pspReference();
    obj.donationToken = this.donationToken();
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
    if (this.giftCardPayment() && this.giftCardPayment() != 0) {
      obj.amount.value = parseInt(this.giftCardPayment());
      this.giftCardPayment(0);
    } else {
      obj.amount.value = parseInt(this.paymentMethodForm.amount());
    }
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
      if (this.splits().length >= 1) {
        obj.splits = this.splits();
      }
    }

    if (this.basketItems().length >= 1) {
      obj.basketItems = this.basketItems();
    }

    if (this.orderPsp() && this.orderData()) {
      obj.order = {
        orderData: this.orderData(),
        pspReference: this.orderPsp()
      };
    }

    if (this.deliveryDate()) {
      const delivDate = new Date(this.deliveryDate());
      obj.deliveryDate = delivDate.toISOString();
    }

    obj.enableL2Data = this.enableL2Data();
    obj.enableAirlineData = this.enableAirlineData();
    obj.enableLodgingData = this.enableLodgingData();

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
      showRemovePaymentMethodButton: true,
      onSelect: function(e) {
        console.log('onSelect', e);
      },
      onDisableStoredPaymentMethod: function(storedPaymentMethodId, resolve, reject) {
        console.log('onDisableStoredPaymentMethod', storedPaymentMethodId);
        resolve();
      }
    };

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
      onClick: function(resolve, reject) {
        console.log('ONCLICK');
        resolve();
      },
      allowedAuthMethods: ['PAN_ONLY']
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
      amount: {
        currency: "GBP",
        value: 1000
      },
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
      showPayButton: true,
      intent: 'authorize',
      merchantId: 'LFVS99UNVDAUJ',
      environment: "test", // Change this to "live" when you're ready to accept live PayPal payments
      countryCode: this.paymentMethodForm.countryCode(), // Only needed for test. This will be automatically retrieved when you are in production
      amount: {
        currency: this.paymentMethodForm.currency(),
        value: this.paymentMethodForm.amount()
      },
      onCancel: (data, component) => {
        console.log(component);
          component.setStatus('ready');
          // Sets your prefered status of the component when a PayPal payment is cancelled. In this example, return to the initial state.
      },
      onError: (e) => {
        console.log('onError paypal', e);
      },
      onInit: (e) => {
        console.log('onInit paypal', e);
      },
      onClick: (e) => {
        console.log('onClick paypal', e);
      }
    };

    return obj;
  }
}
window.my = { viewModel: new contentsKnockoutObj() };
ko.applyBindings(window.my.viewModel);
