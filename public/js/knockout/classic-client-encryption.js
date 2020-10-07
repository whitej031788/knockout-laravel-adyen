// No JS file here, check the blade template for all code

function contentsKnockoutObj() {
  let self = this;

  this.cardNumber = ko.observable('');
  this.cardName = ko.observable('');
  this.expireMonth = ko.observable('');
  this.expireYear = ko.observable('');
  this.cardCvc = ko.observable('');
  this.currency = ko.observable('USD');
  this.amount = ko.observable(100);
  this.merchantAccount = ko.observable('JamieAdyenTestECOM');
  this.reference = ko.observable((Math.floor(Math.random() * 10000000).toString()));
  this.selectedBrand = ko.observable('');
  this.availableBrands = ko.observableArray(['givex', 'svs', 'valuelink']);

  this.submitGiftCard = function(formElement, event) {
    event.preventDefault();

    let self = this;

    $.ajax({
      url: '/api/adyen/payGiftCard',
      dataType: 'json',
      type: 'post',
      data: self.formatGiftData(),
      success: function(data, textStatus, jQxhr) {
        console.log(data);
      },
      error: function(jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  }

  this.submitAuthorisation = function(formElement, event) {
    event.preventDefault();

    let self = this;

    $.ajax({
      url: '/api/adyen/payGiftCard',
      dataType: 'json',
      type: 'post',
      data: self.formatGiftData(),
      success: function(data, textStatus, jQxhr) {
        console.log(data);
      },
      error: function(jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  }

  this.formatGiftData = function() {
    let obj = {
      amount: {
        currency: this.currency(),
        value: this.amount()
      },
      card: {
        cvc: this.cardCvc(),
        expiryMonth: this.expireMonth(),
        expiryYear: this.expireYear(),
        holderName: this.cardName(),
        number: this.cardNumber()
      },
      reference: this.reference(),
      merchantAccount: this.merchantAccount(),
      selectedBrand: this.selectedBrand()
    };

    return obj;
  }
}

ko.applyBindings(new contentsKnockoutObj());
