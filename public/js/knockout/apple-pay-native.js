function contentsKnockoutObj() {
  this.showApplePayButton = ko.observable(window.ApplePaySession && ApplePaySession.canMakePayments());
  // JSON object variables
  var request = null;
  var version = null;
  var merchantId = null;
  var shippingContactUpdate = null;
  var paymentAuthorizationResult = null;
  var settings = {};
  // Javascript needed for completeMethods
  var completePaymentError = [];
  var completeShippingContactError = [];
  var completeCounts = {};

  // Local variables for this page
  var onshippingcontactselectedCount = 1;
  var onpaymentauthorizedCount = 1;

  var shippingContactUpdate = null;

  this.merchantSession = {};

  this.callStartSession = function(session, url) {
    let self = this;

    var text = "";
    text = "\nstartSession Results" + "\n";
    $.post("/api/adyen/applePaySession", {
          "merchantId": merchantId,
          "sessionUrl": url,
          "displayName": "Apple Pay Demo"
        },
        function(data) {
          try {
            self.merchantSession = JSON.parse(data);
          } catch (e) {
            // this should never happen in our situation, unless a bad build
            console.log("startSession response is not valid JSON:\n" + data + "\nApplePaySession cancelled by Apple Pay Demo Site\n");
            if (self.session !== null) {
              self.cancelPaymentSession(session);
            }
          }
          //cleaning the data
          var sanitize = JSON.parse(data);

          sanitize['signature'] = "REDACTED";
          sanitize['merchantSessionIdentifier'] = "REDACTED";
          sanitize['merchantIdentifier'] = "REDACTED";

          text += JSON.stringify(sanitize, undefined, 4);
          // Stop the session if merchantSession is not valid
          if (typeof self.merchantSession === 'string' || 'statusCode' in self.merchantSession) {
            console.log("startSession failed:\n" + text + "\nApplePaySession cancelled by Apple Pay Demo Site\n");
            self.cancelPaymentSession(session);
            return;
          }
          if (!('merchantIdentifier' in self.merchantSession && 'merchantSessionIdentifier' in self.merchantSession && ('nOnce' in self.merchantSession || 'nonce' in self.merchantSession))) {
            var errorDescription = 'merchantSession is invalid. Payment Session cancelled by Apple Pay Demo Site.\n';
            if (!('merchantIdentifier' in self.merchantSession)) {
              errorDescription += 'merchantIdentifier is not found in merchantSession.\n';
            }
            if (!('merchantSessionIdentifier' in self.merchantSession)) {
              errorDescription += 'merchantSessionIdentifier is not found in merchantSession.\n';
            }
            if (!('nOnce' in self.merchantSession)) {
              errorDescription += 'nonce is not found in merchantSession\n';
            }
            errorDescription += text;
            console.log(errorDescription);
            self.cancelPaymentSession(self.session);
            return;
          }

          console.log(text);
          if (self.session !== null) {
            var completeResult = self.completeMerchantValidation(self.session, self.merchantSession);
          }
        }, 'text')
      .fail(function(xhr, textStatus, errorThrown) {
        console.log(xhr.responseText);
        if (self.session !== null) {
          self.cancelPaymentSession(session);
        }
      });
  }

  this.cancelPaymentSession = function(session) {
    if (session !== null)
      this.session.abort();
  }

  this.buildApplePayRequest = function() {
    var req = {};

    req.merchantId = 'merchant.com.adyen.JamieAdyenTestECOM.test';

    try {
      //        req.settings = JSON.parse($('#settings').val());
      req.ApplePayPaymentRequest = {
        "countryCode": "US",
        "currencyCode": "USD",
        "merchantCapabilities": [
          "supports3DS"
        ],
        "supportedNetworks": [
          "visa",
          "masterCard",
          "amex",
          "discover"
        ],
        "total": {
          "label": "Demo (Card is not charged)",
          "type": "final",
          "amount": "1.99"
        }
      };

      req.ApplePayShippingContactUpdate = {};
      req.ApplePayPaymentAuthorizationResult = {
        "status": 0
      };
    } catch (err) {
      alert("Your input does not seem to be a valid JSON object.");
      return;
    }

    return req;
  }

  this.startApplePaySession = function() {
    let self = this;

    if (typeof ApplePaySession === 'undefined') {
      alert("Your browser does not support Apple Pay. Please switch to a supported browser.");
    }

    var o = this.buildApplePayRequest();

    if (o["ApplePayPaymentRequest"] == null) {
      alert("Your input needs to include ApplePayPaymentRequest as a top level key.");
      return;
    }

    request = o["ApplePayPaymentRequest"];
    version = 3;

    merchantId = o["merchantId"];
    shippingContactUpdate = o["ApplePayShippingContactUpdate"];
    paymentAuthorizationResult = o["ApplePayPaymentAuthorizationResult"];
    settings = o["settings"];
    if (settings == null) settings = {};

    // Reset counters
    onshippingcontactselectedCount = 0;
    onpaymentauthorizedCount = 0;

    this.session = new ApplePaySession(version, request);
    window.session = this.session;

    this.session.onshippingcontactselected = function onshippingcontactselected(event) {
      onshippingcontactselectedCount += 1;
      var shippingContact = event.shippingContact;
      console.log('Shipping contact was selected: \n' + JSON.stringify(shippingContact, undefined, 4) + '\n');

      // make sure we use new items if it exists
      var update = {
        newTotal: request["total"],
        newLineItems: request["lineItems"]
      };
      if (o['ApplePayShippingContactUpdate']['newTotal'] !== undefined) {
        update['newTotal'] = o['ApplePayShippingContactUpdate']['newTotal'];
      }
      if (o['ApplePayShippingContactUpdate']['newLineItems'] !== undefined) {
        update['newLineItems'] = o['ApplePayShippingContactUpdate']['newLineItems'];
      }

      settings["failuresBeforeSuccess"] = 1;
      if (settings["failuresBeforeSuccess"] == null || settings["failuresBeforeSuccess"] >= onshippingcontactselectedCount) {
        if (shippingContactUpdate != null)
          update["errors"] = self.errorFromDict(shippingContactUpdate["errors"]);
      }

      self.session.completeShippingContactSelection(update);
    };

    this.session.onshippingmethodselected = function onshippingmethodselected(event) {
      var shippingMethod = event.shippingMethod;
      console.log('Shipping method was selected: ' + JSON.stringify(shippingMethod, undefined, 4) + '\n');
      selectedShippingMethod = event.shippingMethod;

      // make sure we use new items if it exists
      var update = {
        newTotal: request["total"],
        newLineItems: request["lineItems"]
      };
      if (o['ApplePayShippingContactUpdate']['newTotal'] !== undefined) {
        update['newTotal'] = o['ApplePayShippingContactUpdate']['newTotal'];
      }
      if (o['ApplePayShippingContactUpdate']['newLineItems'] !== undefined) {
        update['newLineItems'] = o['ApplePayShippingContactUpdate']['newLineItems'];
      }

      self.session.completeShippingMethodSelection(update);
    };

    this.session.onpaymentauthorized = function onpaymentauthorized(event) {
      onpaymentauthorizedCount += 1;
      var payment = event.payment;
      console.log('payment', payment);
      let currentPaymentToken = payment.token.paymentData;
      console.log("Shipping Contact:\n" + JSON.stringify(payment.shippingContact, undefined, 4) + "\n");
      console.log("Billing Contact:\n" + JSON.stringify(payment.billingContact, undefined, 4) + "\n");
      console.log("Payment Token:\n" + JSON.stringify(payment.token, undefined, 4) + "\n");
      window.setTimeout(function() {

        settings["failuresBeforeSuccess"] = 1;
        var update = {
          status: ApplePaySession.STATUS_SUCCESS
        };
        if (settings["failuresBeforeSuccess"] == null || settings["failuresBeforeSuccess"] >= onpaymentauthorizedCount) {
          if (paymentAuthorizationResult != null) {
            if (paymentAuthorizationResult["status"] != null)
              update["status"] = paymentAuthorizationResult["status"];
            if (paymentAuthorizationResult["errors"] != null)
              update["errors"] = self.errorFromDict(paymentAuthorizationResult["errors"]);
          }
        }

        self.session.completePayment(update);
        console.log('\n\ncompletePayment executed with the following parameters:\n' + JSON.stringify({
          "status": update["status"],
          "errors": self.errorsToJSONObject(update["errors"])
        }, undefined, 4) + '\n');
      }, 2000);
    };

    this.session.onpaymentmethodselected = function onpaymentmethodselected(event) {
      var paymentMethod = event.paymentMethod;

      console.log('Payment method was selected: ' + JSON.stringify(paymentMethod, undefined, 4) + '\n');

      // make sure we use new items if it exists
      var update = {
        newTotal: request["total"],
        newLineItems: request["lineItems"]
      };
      if (o['ApplePayShippingContactUpdate']['newTotal'] !== undefined) {
        update['newTotal'] = o['ApplePayShippingContactUpdate']['newTotal'];
      }
      if (o['ApplePayShippingContactUpdate']['newLineItems'] !== undefined) {
        update['newLineItems'] = o['ApplePayShippingContactUpdate']['newLineItems'];
      }

      console.log('\n\ncompletePaymentMethodSelection:\n' + JSON.stringify(update, undefined, 4) + '\n');
      self.session.completePaymentMethodSelection(update);
    };

    this.session.oncancel = function oncancel() {
      console.log('\nPayment cancelled by WebKit:\n');
      console.log('session.oncancel\n');
    };

    this.session.onvalidatemerchant = function onvalidatemerchant(event) {
      self.callStartSession(self.session, event.validationURL);
    };

    this.session.begin();
  }

  // Helpers
  this.errorFromDict = function(dict) {
    if (dict == null)
      return dict;
    var re = [];
    for (var i = 0; i < dict.length; i++) {
      var e = dict[i];
      re.push(new ApplePayError(e["code"], e["contactField"], e["message"]));
    }
    return re;
  }

  this.completeMerchantValidation = function(session, merchantSession) {
    let self = this;

  	var funcName = 'completeMerchantValidation';
  	if (session == null || session == undefined) return funcName+":\nsession object is null, skipping\n";
  	if (this.numberOfCalls(funcName) >= this.successOverrideFailureCount()) {
  		session.completeMerchantValidation(merchantSession);
  		return funcName + ':\n' + JSON.stringify(merchantSession, undefined, 4) + '\n';
  	}

  	var items = this.completionItemsValue(funcName);

  	if (items == "EMPTY_VALUE") {
  		items = {};
  	} else if (items == "DEFAULT_VALUE") {
  		items = merchantSession;
  	}

  	session.completeMerchantValidation(items);
  	return funcName + ':\n' + JSON.stringify(items, undefined, 4) + '\n';
  }

// Helper

this.successOverrideFailureCount = function() {
	var count = parseInt($("#successOverrideFailureCount").val());
	if (isNaN(count)) return 2;
	else return count;
}
// Returns current number of calls and increment by one afterwards
this.numberOfCalls = function(funcName) {
	if (completeCounts[funcName] == null) {
		completeCounts[funcName] = 1;
	} else {
		completeCounts[funcName] += 1;
	}
//	appendFullLog("\nGot callback: "+funcName+", "+completeCounts[funcName]+" calls so far.\n");
	return completeCounts[funcName]-1;
}

this.errorsToJSONObject = function(errors) {
	var r = [];
	if (errors == null) {
		return null;
	}
	for(var i = 0; i < errors.length; i++) {
		var e = errors[i];
		var error = {};
		error["code"] = e.code;
		error["message"] = e.message;
		error["contactField"] = e.contactField;
		r.push(error);
	}
	return r;
}

this.useNewCompleteAPI = function() {
	return $('#completionMethod-use-new-api').prop('checked');
}

this.getErrors = function(errArray) {
	var errors = [];
	for (var i=0; i<errArray.length; i++) {
		errors.push(new ApplePayError(errArray[i][0],errArray[i][1],errArray[i][2]));
	}
	return errors;
}

this.completionErrorsValue = function(funcName) {
	var selected = parseInt($('#'+funcName+'-errors :selected').val());
	switch (selected) {
		case 0:
			return "EMPTY_ARRAY";
		case 1:
			return "CUSTOM_ARRAY";
		case -1:
			return null;
		case -2:
			return "12345";
		case -3:
			return 12345;
		case -4:
			return undefined;
		default:
			return "EMPTY_ARRAY";
	}
}

this.completionItemsValue = function(funcName) {
	var selected = parseInt($('#'+funcName+'-items :selected').val());
	switch (selected) {
		case 0:
			return "DEFAULT_VALUE";
		case 1:
			return "EMPTY_VALUE";
		case -1:
			return null;
		case -2:
			return "12345";
		case -3:
			return 12345;
		case -4:
			return undefined;
		default:
			return "DEFAULT_VALUE";
	}
}

this.completionStatusValue = function(funcName) {
	var selected = parseInt($('#'+funcName+'-status :selected').val());
	switch (selected) {
		case 0:
			return ApplePaySession.STATUS_SUCCESS;
		case 1:
			return ApplePaySession.STATUS_FAILURE;
		case 2:
			return ApplePaySession.STATUS_INVALID_BILLING_POSTAL_ADDRESS;
		case 3:
			return ApplePaySession.STATUS_INVALID_SHIPPING_POSTAL_ADDRESS;
		case 4:
			return ApplePaySession.STATUS_INVALID_SHIPPING_CONTACT;
		case 5:
			return ApplePaySession.STATUS_PIN_REQUIRED;
		case 6:
			return ApplePaySession.STATUS_PIN_INCORRECT;
		case 7:
			return ApplePaySession.STATUS_PIN_LOCKOUT;
		case -5:
			return -5;
		case 100:
			return 100;
		default:
			return ApplePaySession.STATUS_SUCCESS;
	}
}

this.completionStatusString = function(status) {
  	switch (status) {
  		case 0:
  			return "STATUS_SUCCESS";
  		case 1:
  			return "STATUS_FAILURE";
  		case 2:
  			return "STATUS_INVALID_BILLING_POSTAL_ADDRESS";
  		case 3:
  			return "STATUS_INVALID_SHIPPING_POSTAL_ADDRESS";
  		case 4:
  			return "STATUS_INVALID_SHIPPING_CONTACT";
  		case 5:
  			return "STATUS_PIN_REQUIRED";
  		case 6:
  			return "STATUS_PIN_INCORRECT";
  		case 7:
  			return "STATUS_PIN_LOCKOUT";
  		case -5:
  			return "NEGATIVE_I_DON'T_EXIST";
  		case 100:
  			return "NEGATIVE_I_DON'T_EXIST";
  		default:
  			return "STATUS_SUCCESS";
  	}
  }
}

window.my = { viewModel: new contentsKnockoutObj() };
ko.applyBindings(window.my.viewModel);
