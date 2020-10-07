export function ApplePayService(paymentRequest, options) {
  this.session = new ApplePaySession(options.version, paymentRequest);
  this.session.onvalidatemerchant = (e) => this.onvalidatemerchant(e, options.onValidateMerchant);
  this.session.onpaymentauthorized = (e) => this.onpaymentauthorized(e, options.onPaymentAuthorized);
  this.session.oncancel = (e) => this.oncancel(e, options.onCancel);

  if (typeof options.onPaymentMethodSelected === 'function') {
    this.session.onpaymentmethodselected = (e) => this.onpaymentmethodselected(e, options.onPaymentMethodSelected);
  }

  if (typeof options.onShippingContactSelected === 'function') {
    this.session.onshippingcontactselected = (e) => this.onshippingcontactselected(e, options.onShippingContactSelected);
  }

  if (typeof options.onShippingMethodSelected === 'function') {
    this.session.onshippingmethodselected = (e) => this.onshippingmethodselected(e, options.onShippingMethodSelected);
  }

  /**
   * Begins the merchant validation process.
   * When this method is called, the payment sheet is presented and the merchant validation process is initiated.
   * @see {@link https://developer.apple.com/documentation/apple_pay_on_the_web/applepaysession/1778001-begin}
   */
  this.begin = function() {
    return this.session.begin();
  }

  /**
   * An event handler that is called when the payment sheet is displayed.
   * Use this attribute to request and return a merchant session.
   * @param {object} event An ApplePayValidateMerchantEvent object (contains validationURL)
   * @param {Promise} onValidateMerchant A promise implemented by the merchant that will resolve with the merchantSession
   * @see {@link https://developer.apple.com/documentation/apple_pay_on_the_web/apple_pay_js_api/providing_merchant_validation}
   */
  this.onvalidatemerchant = function(event, onValidateMerchant) {
    return new Promise((resolve, reject) => onValidateMerchant(resolve, reject, event.validationURL))
      .then(response => {
        this.session.completeMerchantValidation(response);
      })
      .catch(error => {
        console.error(error);
        this.session.abort();
      });
  }

  /**
   * An event handler that is called when the user has authorized the Apple Pay payment with Touch ID, Face ID, or passcode.
   * The onpaymentauthorized function must complete the payment and respond by calling completePayment before the 30 second timeout.
   * @param {object} event The event parameter contains the payment (ApplePayPayment) attribute.
   * @param {Promise} onPaymentAuthorized A promise that will complete the payment when resolved. Use this promise to process the payment.
   * @see {@link https://developer.apple.com/documentation/apple_pay_on_the_web/applepaysession/1778020-onpaymentauthorized}
   */
  this.onpaymentauthorized = function(event, onPaymentAuthorized) {
    return new Promise((resolve, reject) => onPaymentAuthorized(resolve, reject, event))
      .then(() => {
        this.session.completePayment(ApplePaySession.STATUS_SUCCESS);
      })
      .catch(() => {
        this.session.completePayment(ApplePaySession.STATUS_FAILURE);
      });
  }

  /**
   * An event handler that is called when a new payment method is selected.
   * The onpaymentmethodselected function must resolve before the 30 second timeout
   * @param {object} event The event parameter contains the payment (ApplePayPayment) attribute.
   * @param {Promise} onPaymentMethodSelected A promise that will complete the payment when resolved. Use this promise to process the payment.
   * @see {@link https://developer.apple.com/documentation/apple_pay_on_the_web/applepaysession/1778013-onpaymentmethodselected}
   */
  this.onpaymentmethodselected = function(event, onPaymentMethodSelected) {
    return new Promise((resolve, reject) => onPaymentMethodSelected(resolve, reject, event))
      .then((paymentMethodUpdate) => {
        this.session.completePaymentMethodSelection(paymentMethodUpdate);
      })
      .catch((paymentMethodUpdate) => {
        this.session.completePaymentMethodSelection(paymentMethodUpdate);
      });
  }

  /**
   * An event handler that is called when a new payment method is selected.
   * The onpaymentmethodselected function must resolve before the 30 second timeout
   * @param {object} event The event parameter contains the shippingContact attribute.
   * @param {Promise} onShippingContactSelected A promise that will complete the selection of a shipping contact with an update.
   * @see {@link https://developer.apple.com/documentation/apple_pay_on_the_web/applepaysession/1778009-onshippingcontactselected}
   */
  this.onshippingcontactselected = function(event, onShippingContactSelected) {
    return new Promise((resolve, reject) => onShippingContactSelected(resolve, reject, event))
      .then((shippingContactUpdate) => {
        this.session.completeShippingContactSelection(shippingContactUpdate);
      })
      .catch((shippingContactUpdate) => {
        this.session.completeShippingContactSelection(shippingContactUpdate);
      });
  }

  /**
   * An event handler that is called when a new payment method is selected.
   * The onpaymentmethodselected function must resolve before the 30 second timeout
   * @param {object} event The event parameter contains the shippingMethod attribute.
   * @param {Promise} onShippingMethodSelected A promise that will complete the selection of a shipping method with an update.
   * @see {@link https://developer.apple.com/documentation/apple_pay_on_the_web/applepaysession/1778009-onshippingcontactselected}
   */
  this.onshippingmethodselected = function(event, onShippingMethodSelected) {
    return new Promise((resolve, reject) => onShippingMethodSelected(resolve, reject, event))
      .then((shippingMethodUpdate) => {
        this.session.completeShippingMethodSelection(shippingMethodUpdate);
      })
      .catch((shippingMethodUpdate) => {
        this.session.completeShippingMethodSelection(shippingMethodUpdate);
      });
  }

  /**
   * An event handler that is automatically called when the payment UI is dismissed.
   * This function can be called even after an onpaymentauthorized event has been dispatched.
   * @param {object} event
   * @param {function} onCancel
   * @see {@link https://developer.apple.com/documentation/apple_pay_on_the_web/applepaysession/1778029-oncancel}
   */
  this.oncancel = function(event, onCancel) {
    return onCancel(event);
  }
}
