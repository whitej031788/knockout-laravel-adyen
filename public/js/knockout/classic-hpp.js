function classicHppKo() {
  this.merchantAccount = ko.observable('JamieAdyenTestECOM');
  this.currencyCode = ko.observable('GBP');
  this.merchantReference = ko.observable((Math.floor(Math.random() * 10000000).toString()));
  this.shopperReference = ko.observable((Math.floor(Math.random() * 10000000).toString()));
  this.shopperEmail = ko.observable('jamie.white@adyen.com');
  this.merchantSig = ko.observable('');
  this.paymentAmount = ko.observable(3000);
  this.sessionValidity = ko.observable(sessValid);
  this.skinCode = ko.observable('pCGGZyLp');
  this.brandCode = ko.observable('paypal_ecs');
  this.countryCode = ko.observable('GB');
  this.hppTypeOptions = ko.observableArray(['select', 'pay', 'skipDetails']);
  this.hppType = ko.observable('select');
  this.hppUrl = ko.computed(function() {
    return "https://test.adyen.com/hpp/" + this.hppType() + ".shtml";
  }, this);
  this.error = ko.observable('');

  this.openinvoicedata = {
    numberOfLines: '2',
    lineItems: [
      {
        id: 1,
        props: {
          numberOfItems: '1',
          itemAmount: '3500',
          currencyCode: this.currencyCode(),
          itemVatAmount: '665',
          itemVatPercentage: '1900',
          vatCategory: 'High',
          description: 'Description 1',
        }
      },
      {
        id: 2,
        props: {
          numberOfItems: '1',
          itemAmount: '2100',
          currencyCode: this.currencyCode(),
          itemVatAmount: '339',
          itemVatPercentage: '1900',
          vatCategory: 'Low',
          description: 'Description 2'
        }
      }
    ]
  };

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
          console.log(self.hppUrl());
          $('#adyenForm').attr('action', self.hppUrl());
          //window.open('', 'formpopup', 'width=400,height=400,resizeable,scrollbars');
          //$('#adyenForm').attr('target', 'formpopup');
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
    obj.shopperReference = this.shopperReference();
    obj.shopperEmail = this.shopperEmail();
    obj.merchantSig = this.merchantSig() ? this.merchantSig() : undefined;
    obj.paymentAmount = this.paymentAmount();
    obj.sessionValidity = this.sessionValidity() ? this.sessionValidity() : undefined;
    obj.skinCode = this.skinCode() ? this.skinCode() : undefined;
    obj.brandCode = this.brandCode() ? this.brandCode() : undefined;
    obj.countryCode = this.countryCode();
    obj.sessionValidity = this.sessionValidity();

    //obj.openinvoicedata = this.openinvoicedata;

    return obj;
  }
}

ko.applyBindings(new classicHppKo());
