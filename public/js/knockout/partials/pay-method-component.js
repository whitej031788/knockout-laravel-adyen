export function paymentMethodForm() {
  this.merchantAccount = ko.observable('JamieAdyenTestECOM');
  this.countryCode = ko.observable('GB');
  this.amount = ko.observable((Math.floor(Math.random() * 10000).toString()));
  this.currency = ko.observable('GBP');
  this.channel = ko.observable('Web');
  this.reference = ko.observable((Math.floor(Math.random() * 10000000).toString()));
  this.shopperReference = ko.observable(7802258);
  this.shopperReference = ko.observable((Math.floor(Math.random() * 10000000).toString()));
  this.error = ko.observable('');

  this.submitMethodRequest = function(orderObj) {
    let self = this;

    return new Promise((resolve, reject) => {
      $.ajax({
        url: '/api/adyen/getPaymentMethods',
        dataType: 'json',
        type: 'post',
        data: self.toJSON(orderObj),
        success: function(data, textStatus, jQxhr) {
          resolve(data);
        },
        error: function(jqXhr, textStatus, errorThrown) {
          reject('Something went wrong calling Adyen. Make sure all fields are filled out: <ERROR> ' + errorThrown + ' </ERROR>');
          console.log(errorThrown);
        }
      });
    });
  }

  this.submitSessionRequest = function(orderObj) {
    let self = this;

    return new Promise((resolve, reject) => {
      $.ajax({
        url: '/api/adyen/getPaymentSession',
        dataType: 'json',
        type: 'post',
        data: self.toJSON(orderObj, true),
        success: function(data, textStatus, jQxhr) {
          resolve(data);
        },
        error: function(jqXhr, textStatus, errorThrown) {
          reject('Something went wrong calling Adyen. Make sure all fields are filled out: <ERROR> ' + errorThrown + ' </ERROR>');
          console.log(errorThrown);
        }
      });
    });
  }

  this.toJSON = function(orderObj, isSession) {
    let obj = {};

    obj.amount = {};
    obj.amount.currency = this.currency();
    obj.merchantAccount = this.merchantAccount();
    obj.countryCode = this.countryCode();
    obj.channel = this.channel();
    obj.shopperReference = this.shopperReference();

    if (orderObj) {
      obj.order = orderObj;
    }

    if (isSession) {
      obj.amount.value = this.amount();
      obj.reference = this.reference();
    }

    return obj;
  }
}
