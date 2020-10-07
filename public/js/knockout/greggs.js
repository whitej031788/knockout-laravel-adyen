function contentsKnockoutObj() {
  this.reference = ko.observable('');
  this.phoneNumber = ko.observable('');
  this.shopperEmail = ko.observable('');
  this.shopperReference = ko.observable((Math.floor(Math.random() * 10000000).toString()));
  this.returnUrl = ko.observable('https://greggs.co.uk');
  this.currency = ko.observable('USD');
  this.amount = ko.observable('');
  this.errorMessage = ko.observable('');
  this.successMessage = ko.observable('');
  this.customerName = ko.observable('');
  this.pickupTime = ko.observable('');

  this.sellableItems = ko.observableArray([
    {
      category: 'breakfast',
      sku: 'BCNROL1',
      image: 'https://s3.eu-west-2.amazonaws.com/greggs-prod-cms/public/Uploads/6073b0247c/Bacon-Roll-Heinz-2_315.jpg',
      name: 'Bacon Breakfast Roll',
      price: '2.50',
      quantity: ko.observable(0)
    },
    {
      category: 'breakfast',
      sku: 'SGSRLL',
      image: 'https://s3.eu-west-2.amazonaws.com/greggs-prod-cms/public/Uploads/091f0a6b93/Sausage-Breakfast-Roll_880.jpg',
      name: 'Sausage Breakfast Roll',
      price: '2.50',
      quantity: ko.observable(0)
    },
    {
      category: 'breakfast',
      sku: 'CNMBUN',
      image: 'https://s3.eu-west-2.amazonaws.com/greggs-prod-cms/public/Uploads/bf6f0b396a/Cinnamon-Bun-1_880.jpg',
      name: 'Cinnamon Roll',
      price: '1.50',
      quantity: ko.observable(0)
    },
    {
      category: 'coffee',
      sku: 'CAPUC',
      image: 'https://s3.eu-west-2.amazonaws.com/greggs-prod-cms/public/Uploads/038e7e8c7a/Cappuccino-New_205.jpg',
      name: 'Cappuccino',
      price: '1.50',
      quantity: ko.observable(0)
    },
    {
      category: 'coffee',
      sku: 'FLTWHIT',
      image: 'https://s3.eu-west-2.amazonaws.com/greggs-prod-cms/public/Uploads/6c2ea2f429/Flat-White_205.jpg',
      name: 'Flat White',
      price: '2.00',
      quantity: ko.observable(0)
    },
    {
      category: 'coffee',
      sku: 'LATEE',
      image: 'https://s3.eu-west-2.amazonaws.com/greggs-prod-cms/public/Uploads/1e97847669/Latte_205.jpg',
      name: 'Latee',
      price: '1.50',
      quantity: ko.observable(0)
    }
  ]);

  this.totalAmount = ko.computed(function() {
    let total = 0;
    for (let i = 0; i < this.sellableItems().length; i++) {
      total += this.sellableItems()[i].quantity() * parseFloat(this.sellableItems()[i].price)
    }
    return total;
  }, this);

  this.sendPaymentLink = function() {
    let self = this;

    this.errorMessage('');

    if (!this.shopperEmail().trim() && !this.phoneNumber().trim()) {
      this.errorMessage('Please provide either email address or phone number');
      return;
    }

    // if (this.totalAmount() <= 0) {
    //   this.errorMessage("Please enter an amount greater than zero");
    //   return;
    // }

    if (this.amount() <= 0) {
      this.errorMessage("Please enter an amount greater than zero");
      return;
    }

    if (!this.reference().trim()) {
      this.errorMessage("You must enter the order number from the register");
      return;
    }

    $.ajax({
      url: '/api/greggs/generateAndShowInvoice',
      //dataType: 'json',
      type: 'post',
      data: self.paymentLinkJson(),
      success: function(retData, textStatus, jQxhr) {
        //self.successMessage('Order number #' + self.reference() + " has been emailed or sent via text to the customer. As soon as they pay, an email notification will be sent to your store for the order to be prepared and set out for contactless pickup.");
        //var blob=new Blob([retData]);
        //var link=document.createElement('a');
        //link.href=window.URL.createObjectURL(blob);
        //link.download="invoice.pdf";
        //link.click();
        window.location="invoice.pdf"
      },
      error: function(jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });

    return false;
  }

  this.addOne = function(item) {
    item.quantity(item.quantity() + 1);
    console.log(item);
    console.log(this.totalAmount());
  }

  this.removeOne = function(item) {
    if (item.quantity() <= 0) {
      item.quantity(0);
    } else {
      item.quantity(item.quantity() - 1);
    }
  }

  this.buildDescription = function() {
    return "Greggs Order #" + this.reference();
  }

  this.paymentLinkJson = function() {
    let obj = {};

    obj.amount = {};
    obj.amount.value = parseFloat(this.amount()) * 100;
    obj.amount.currency = this.currency();
    obj.reference = this.reference();
    obj.shopperReference = this.shopperReference();
    obj.shopperEmail = this.shopperEmail();
    //obj.description = this.buildDescription();
    obj.returnUrl = this.returnUrl();
    obj.phoneNumber = this.phoneNumber();

    return obj;
  }
}

ko.applyBindings(new contentsKnockoutObj());
