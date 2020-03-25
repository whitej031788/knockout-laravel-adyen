function classicHppKo() {
  this.merchantAccount = ko.observable('JamieAdyenTestECOM');
  this.currencyCode = ko.observable('USD');
  this.merchantReference = ko.observable((Math.floor(Math.random() * 10000000).toString()));
  this.merchantSig = ko.observable('');
  this.paymentAmount = ko.observable(3000);
  this.sessionValidity = ko.observable(sessValid);
  this.skinCode = ko.observable('pCGGZyLp');
  this.countryCode = ko.observable('US');
  this.hppTypeOptions = ko.observableArray(['select', 'pay', 'skipDetails']);
  this.hppType = ko.observable('select');
  this.hppUrl = ko.computed(function() {
    return "https://test.adyen.com/hpp/" + this.hppType() + ".shtml";
  }, this);
  this.error = ko.observable('');

  this.submitHppStuff = function() {
    let self = this;

    if (!this.merchantSig()) {
      $.ajax({
        url: '/api/adyen/signHppHmac',
        dataType: 'json',
        type: 'post',
        data: self.toJSON(),
        success: function(data, textStatus, jQxhr) {
          self.merchantSig(data);
          ko.cleanNode($('#adyenForm')[0]);
          $('#adyenForm').attr('action', self.hppUrl());
          $('#adyenForm').submit();
        },
        error: function(jqXhr, textStatus, errorThrown) {
          console.log(errorThrown);
        }
      });
    } else {
      $('#adyenForm').submit();
    }
  }

  this.toJSON = function() {
    let obj = {};

    obj.merchantAccount = this.merchantAccount();
    obj.currencyCode = this.currencyCode();
    obj.merchantReference = this.merchantReference();
    obj.merchantSig = this.merchantSig() ? this.merchantSig() : undefined;
    obj.paymentAmount = this.paymentAmount();
    obj.sessionValidity = this.sessionValidity() ? this.sessionValidity() : undefined;
    obj.skinCode = this.skinCode() ? this.skinCode() : undefined;
    obj.countryCode = this.countryCode();
    obj.sessionValidity = this.sessionValidity();

    return obj;
  }
}

ko.applyBindings(new classicHppKo());
