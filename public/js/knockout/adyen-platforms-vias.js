function adyenPlatformsKo() {
  this.currentTab = ko.observable('signUp');
  this.apiUrlOrMethod = ko.observable('');
  this.apiRequest = ko.observable('');
  this.apiResponse = ko.observable('');

  /* Create / Update Account Holder */
  this.legalEntityOptions = ko.observableArray([
    "Individual",
    "Business"
  ]);
  this.legalEntity = ko.observable("Business");
  this.merchantAccount = ko.observable('JamieAdyenTest_JamieAdyenTestMP-POS_TEST');
  this.verificationProfile = ko.observable('');
  this.email = ko.observable('jamie.white@adyen.com');
  this.country = ko.observable('GB');
  this.firstName = ko.observable('NameFirst');
  this.lastName = ko.observable('TestData');
  this.accountHolderCode = ko.observable('');
  this.legalBusinessName = ko.observable('TestData');
  this.webAddress = ko.observable('https://google.com');
  this.gender = ko.observable('UNKNOWN');
  this.createFrontLoad = ko.observable(false);
  this.createEcomStore = ko.observable(false);
  this.createPosStore = ko.observable(false);
  // Bank check / Individual / Shareholder / Company Check
  this.houseNumberOrName = ko.observable('10');
  this.street = ko.observable('Hills Place');
  this.city = ko.observable('PASSED');
  this.stateOrProvince = ko.computed(function() {
    return this.city();
  }, this);
  this.postalCode = ko.observable('W1F 7SD');
  this.houseNumberOrName = ko.observable('10');
  this.ownerName = ko.computed(function() {
    return this.lastName();
  }, this);
  this.branchCode = ko.observable('40-05-15');
  this.currencyCode = ko.observable('GBP');
  this.accountNumber = ko.observable('00990274');
  this.fullPhoneNumber = ko.observable('+441234567890');
  this.dateOfBirth = ko.observable('1988-09-11');
  this.registrationNumber = ko.observable('');
  this.documentNumber = ko.observable('1234567890');
  this.omitBankInfo = ko.observable(false);

 /* Create Notification Endpoint */
 this.notificationDescription = ko.observable('');
 this.notifyURL = ko.observable('');
 this.notifyUsername = ko.observable('');
 this.notifyPassword = ko.observable('');

 /* Upload document endpoint */
 this.documentTypeOptions = ko.observableArray([
   "PASSPORT",
   "ID",
   "VISA",
   "DRIVINGLICENSE",
   "BANK_STATEMENT"
 ]);
 this.documentType = ko.observable("PASSPORT");
 this.documentDescription = ko.observable("PASSED");
 this.documentContent = ko.observable();
 this.filename = ko.observable('');
 this.bankAccountUUID = ko.observable('');
 this.shareholderCode = ko.observable('');

  this.changeTab = function(tab) {
    this.currentTab(tab);
  }

  this.platformsApiCall = function(url, postData, promiseAction) {
    let self = this;

    $.ajax({
      url: '/api/marketplace/' + url,
      dataType: 'json',
      type: 'post',
      data: postData,
      success: function(retData, textStatus, jQxhr) {
        self.populatePostman(url, postData, retData);

        // Should we do anything else? Like populate observables?
        if (promiseAction) {
          switch (url) {
            case "getAccountHolder":
              self.populateAccountHolder(retData.response);
              break;
            case "getOnboardingUrl":
              window.open(retData.response.redirectUrl);
              break;
            case "getPciQuestionnaireUrl":
              window.open(retData.response.redirectUrl);
              break;
            default:
              break;
          }
        }
      },
      error: function(jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  }

  this.createAccountHolder = function() {
    if (!this.accountHolderCode()) {
      alert('Provide account holder code');
      return;
    }

    let data = this.formatAccountHolderJson(this.legalEntity(), false, 'create');

    this.platformsApiCall('createAccountHolder', data);
  }

  this.createNotificationConfiguration = function() {
    let data = {
      "configurationDetails": {
        "apiVersion": 5,
        "active": true,
        "description": this.notificationDescription(),
        "eventConfigs": [
          {
            "eventType": "ACCOUNT_HOLDER_CREATED",
            "includeMode": "INCLUDE"
          },
          {
            "eventType": "ACCOUNT_HOLDER_UPDATED",
            "includeMode": "INCLUDE"
          },
          {
            "eventType": "ACCOUNT_HOLDER_STATUS_CHANGE",
            "includeMode": "INCLUDE"
          },
          {
            "eventType": "ACCOUNT_HOLDER_VERIFICATION",
            "includeMode": "INCLUDE"
          },
          {
            "eventType": "ACCOUNT_HOLDER_PAYOUT",
            "includeMode": "INCLUDE"
          },
          {
            "eventType": "ACCOUNT_CREATED",
            "includeMode": "INCLUDE"
          },
          {
            "eventType": "ACCOUNT_UPDATED",
            "includeMode": "INCLUDE"
          },
          {
            "eventType": "ACCOUNT_CLOSED",
            "includeMode": "INCLUDE"
          },
          {
            "eventType": "BENEFICIARY_SETUP",
            "includeMode": "INCLUDE"
          },
          {
            "eventType": "PAYMENT_FAILURE",
            "includeMode": "INCLUDE"
          },
          {
            "eventType": "SCHEDULED_REFUNDS",
            "includeMode": "INCLUDE"
          },
          {
            "eventType": "TRANSFER_FUNDS",
            "includeMode": "INCLUDE"
          },
          {
            "eventType": "REFUND_FUNDS_TRANSFER",
            "includeMode": "INCLUDE"
          },
          {
            "eventType": "REPORT_AVAILABLE",
            "includeMode": "INCLUDE"
          },
          {
            "eventType": "COMPENSATE_NEGATIVE_BALANCE",
            "includeMode": "INCLUDE"
          }
        ],
        "notifyURL": this.notifyURL(),
        "notifyUsername": this.notifyUsername(),
        "notifyPassword": this.notifyPassword(),
        "sslProtocol": "SSL"
      }
    };

    this.platformsApiCall('createNotificationConfiguration', data);
  }

  this.uploadDocument = function() {
    let data = {
       "documentContent": this.documentContent(),
       "documentDetail": {
          "accountHolderCode": this.accountHolderCode(),
          "documentType": this.documentType(),
          "filename": this.filename(),
          "description": this.documentDescription()
       }
    }

    if (this.bankAccountUUID() && this.documentType() == 'BANK_STATEMENT') {
      data.documentDetail.bankAccountUUID = this.bankAccountUUID();
    }

    if (this.shareholderCode()) {
      data.documentDetail.shareholderCode = this.shareholderCode();
    }

    this.platformsApiCall('uploadDocument', data);
  }

  this.getAccountHolder = function() {
    if (!this.accountHolderCode()) {
      alert('Provide account holder code');
      return;
    }

    let data = {
      "accountHolderCode": this.accountHolderCode()
    }

    this.platformsApiCall('getAccountHolder', data, true);
  }

  this.getOnboardingUrl = function() {
    if (!this.accountHolderCode()) {
      alert('Provide account holder code');
      return;
    }

    let data = {
      "accountHolderCode": this.accountHolderCode(),
      "returnUrl": "https://your.return-url.com/?submerchant=123"
    }

    this.platformsApiCall('getOnboardingUrl', data, true);
  }

  this.checkAccountHolder = function() {
    if (!this.accountHolderCode()) {
      alert('Provide account holder code');
      return;
    }

    // Push them to the max tier
    let data = {
      "accountHolderCode": this.accountHolderCode(),
      "accountStateType": "Payout",
      "tier": "2"
    }

    this.platformsApiCall('checkAccountHolder', data, true);
  }

  this.getPciQuestionnaireUrl = function() {
    if (!this.accountHolderCode()) {
      alert('Provide account holder code');
      return;
    }

    let data = {
      "accountHolderCode": this.accountHolderCode(),
      "returnUrl": "https://your.return-url.com/?submerchant=123"
    }

    this.platformsApiCall('getPciQuestionnaireUrl', data, true);
  }

  this.populateAccountHolder = function(data) {
    this.legalEntity(data.legalEntity);
    this.country(data.accountHolderDetails.address.country);
    this.postalCode(data.accountHolderDetails.address.postalCode);
    this.city(data.accountHolderDetails.address.city);
    this.street(data.accountHolderDetails.address.street);
    this.houseNumberOrName(data.accountHolderDetails.address.houseNumberOrName);
    this.email(data.accountHolderDetails.email);

    if (data.legalEntity == "Individual") {
      this.firstName(data.accountHolderDetails.individualDetails.name.firstName);
      this.lastName(data.accountHolderDetails.individualDetails.name.lastName);
      this.gender(data.accountHolderDetails.individualDetails.name.gender);
    } else {
      this.legalBusinessName(data.accountHolderDetails.businessDetails.legalBusinessName);
      if (data.accountHolderDetails.businessDetails.registrationNumber) {
        this.registrationNumber(data.accountHolderDetails.businessDetails.registrationNumber);
      }
      // Only supporting one shareholder at the moment
      this.firstName(data.accountHolderDetails.businessDetails.shareholders[0].name.firstName);
      this.lastName(data.accountHolderDetails.businessDetails.shareholders[0].name.lastName);
      this.gender(data.accountHolderDetails.businessDetails.shareholders[0].name.gender);

      if (data.accountHolderDetails.businessDetails.shareholders[0].personalData) {
        this.dateOfBirth(data.accountHolderDetails.businessDetails.shareholders[0].personalData.dateOfBirth);
      }

      if (data.accountHolderDetails.businessDetails.shareholders[0].shareholderCode) {
        this.shareholderCode(data.accountHolderDetails.businessDetails.shareholders[0].shareholderCode);
      }
    }
  }
  // TO IMPLEMENT
  this.updateAccountHolder = function() {
    if (!this.accountHolderCode()) {
      alert('Provide account holder code');
      return;
    }

    var endpoint = 'updateAccountHolder';
    var type = 'update';
    var frontLoad = false;

    // If front load is ticked, let's try and create it
    if (this.createFrontLoad()) {
      endpoint = 'createAccountHolder';
      type = 'create';
      frontLoad = true;
    }

    // Is this an ECOM store creation?
    if (this.createEcomStore()) {
      type = 'ecom-store-create';
    }

    // Is this a POS store creation?
    if (this.createPosStore()) {
      type = 'pos-store-create';
    }

    let data = this.formatAccountHolderJson(this.legalEntity(), frontLoad, type);

    this.platformsApiCall(endpoint, data);
  }

  this.formatAccountHolderJson = function(type, frontLoad, createOrUpdateOrStore) {
    // START MINIMAL DATA, FOR AN UPDATE OR A CREATE
    let data = {
       "accountHolderCode": this.accountHolderCode(),
       "accountHolderDetails": {
          "address": {
            "country": this.country()
          },
          "email": this.email(),
          "webAddress": this.webAddress(),
          // "phoneNumber":
          // {
          //   "phoneCountryCode": this.country(),
          //   "phoneNumber": this.fullPhoneNumber(),
          //   "phoneType": "Mobile"
          // }
       },
       "legalEntity": type
    };

    if (createOrUpdateOrStore == 'create') {
      // data.createDefaultAccount = true;
      if (this.verificationProfile()) {
        data.verificationProfile = this.verificationProfile();
      }
    }

    if (type == "Individual") {
      data.accountHolderDetails.individualDetails = {
        "name": {
          "firstName": this.firstName(),
          "lastName": this.lastName(),
          "gender": this.gender()
        }
      }
    } else {
      data.accountHolderDetails.businessDetails = {
        "legalBusinessName": this.legalBusinessName(),
        "shareholders": [
          {
            "name": {
              "firstName": this.firstName(),
              "lastName": this.lastName(),
              "gender": this.gender()
            },
            "address": {
              "country": this.country()
            }
          }
        ]
      }
    }
    // END MINIMAL DATA

    // If it is a create and we don't want to front load, then we are done
    // Minimal sign up
    if (createOrUpdateOrStore == 'create' && frontLoad == false) {
      return data;
    } else if (createOrUpdateOrStore == 'update' || frontLoad == true) {
      // any other combo means let's load this object up
      // if it is an update, then load it up
      // if it is a create and frontLoad == true, then we want to load it up anyway
      data.processingTier = "1";
      // Agnostic of legalEntityType()
      data.accountHolderDetails.fullPhoneNumber = this.fullPhoneNumber();
      data.accountHolderDetails.address.houseNumberOrName = this.houseNumberOrName();
      data.accountHolderDetails.address.street = this.street();
      data.accountHolderDetails.address.city = this.city();
      data.accountHolderDetails.address.postalCode = this.postalCode();
      // Bank info we will still make agonstic, easier for now
      if (!this.omitBankInfo()) {
        data.accountHolderDetails.bankAccountDetails = [{
          "accountNumber": this.accountNumber(),
          "branchCode": this.branchCode(),
          "countryCode": this.country(),
          "currencyCode": this.currencyCode(),
          "ownerName": this.ownerName(),
          "ownerHouseNumberOrName": this.houseNumberOrName(),
          "ownerPostalCode": this.postalCode(),
          "ownerCity": this.city(),
          "primaryAccount": true
        }];
      }

      if (type == "Individual") {
        data.accountHolderDetails.individualDetails.personalData = {
          "dateOfBirth": this.dateOfBirth(),
          "documentData": [
            {
              "number": "925076473",
              "type": "PASSPORT"
            }
          ]
        };
      } else {
        data.accountHolderDetails.businessDetails.registrationNumber = this.registrationNumber();
        // Still supporting just one shareholder
        data.accountHolderDetails.businessDetails.shareholders[0].address.houseNumberOrName = this.houseNumberOrName();
        data.accountHolderDetails.businessDetails.shareholders[0].address.street = this.street();
        data.accountHolderDetails.businessDetails.shareholders[0].address.city = this.city();
        data.accountHolderDetails.businessDetails.shareholders[0].address.postalCode = this.postalCode();
        if (!data.accountHolderDetails.businessDetails.shareholders[0].personalData) {
          data.accountHolderDetails.businessDetails.shareholders[0].personalData = {
            "dateOfBirth": this.dateOfBirth(),
            "documentData": [
              {
                "number": "925076473",
                "type": "PASSPORT"
              }
            ]
          };
        } else {
          data.accountHolderDetails.businessDetails.shareholders[0].personalData.dateOfBirth = this.dateOfBirth();
          data.accountHolderDetails.businessDetails.shareholders[0].personalData.documentData = [
            {
              "number": "925076473",
              "type": "PASSPORT"
            }
          ];
        }

        // Update existing shareholder
        if (this.shareholderCode()) {
          data.accountHolderDetails.businessDetails.shareholders[0].shareholderCode = this.shareholderCode();
        }
      }
    }

    if (createOrUpdateOrStore == 'ecom-store-create' || createOrUpdateOrStore == 'pos-store-create') {
      data.accountHolderDetails.storeDetails = [
        {
          "fullPhoneNumber": this.fullPhoneNumber(),
          "merchantAccount": this.merchantAccount(),
          "merchantCategoryCode": "8999",
          "storeName": "Store " + this.accountHolderCode(),
          "storeReference": this.accountHolderCode() + "-store"
        }
      ];

      if (createOrUpdateOrStore == 'ecom-store-create') {
        data.accountHolderDetails.storeDetails[0].shopperInteraction = 'Ecommerce';
        data.accountHolderDetails.storeDetails[0].webAddress = "https://google.com";
      } else { // POS
        data.accountHolderDetails.storeDetails[0].address = {};
        data.accountHolderDetails.storeDetails[0].address.houseNumberOrName = this.houseNumberOrName();
        data.accountHolderDetails.storeDetails[0].address.country = this.country();
        data.accountHolderDetails.storeDetails[0].address.street = this.street();
        data.accountHolderDetails.storeDetails[0].address.city = this.city();
        data.accountHolderDetails.storeDetails[0].address.postalCode = this.postalCode();
      }
    }

    return data;
  }

  this.fileUpload = function(data, e) {
    let self = this;

    let file = e.target.files[0];
    this.filename(file.name);
    let reader = new FileReader();

    reader.onloadend = function (onloadend_e) {
      let result = reader.result; // Here is your base 64 encoded file. Do with it what you want.
      self.documentContent(result);
      console.log(result);
    };

    if (file) {
      reader.readAsDataURL(file);
    }
  };

  this.populatePostman = function(url, postData, data) {
    this.apiUrlOrMethod(url);
    if (data.request) {
      this.apiRequest(this.jsonPrettyHighlightToId(data.request));
    } else {
      this.apiRequest(this.jsonPrettyHighlightToId(postData));
    }

    if (data.response) {
      this.apiResponse(this.jsonPrettyHighlightToId(data.response));
    } else {
      this.apiResponse(this.jsonPrettyHighlightToId(data));
    }
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

ko.applyBindings(new adyenPlatformsKo());
