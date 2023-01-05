function adyenBalancePlatformsKo() {
  this.currentTab = ko.observable('legalEntity');
  this.apiUrlOrMethod = ko.observable('');
  this.apiRequest = ko.observable('');
  this.apiResponse = ko.observable('');
  // The below is whatever the last API call was
  this.lastEntityId = ko.observable('');
  // We need to persist specific entity type IDs as well
  this.legalEntityId = ko.observable('');
  this.accountHolderId = ko.observable('');
  // Constants
  this.balancePlatform = ko.observable('JamieTest');

  this.entityAssociations = ko.observableArray([]);

  this.addEntityAssociation = function() {
    this.entityAssociations.push({jobTitle: '', legalEntityId: '', type: ''});
  }

  this.removeEntityAssociation = function(assoc) {
    this.entityAssociations.remove(assoc);
  }

  /* Create / Update Account Holder */
  this.legalEntityTypeOptions = ko.observableArray([
    "individual",
    "organization"
  ]);

  this.getRandomNumberBetween = function(min,max) {
    return Math.floor(Math.random()*(max-min+1)+min);
  }

  this.legalEntity = ko.observable({
    type: ko.observable("organization"),
    individual: {
      residentialAddress: {
        city: "Amsterdam",
        country: "NL",
        postalCode: "1011DJ",
        street: "Simon Carmiggeltstraat 6 - 50"
      },
      phone: {
        number: "",
        type: ""
      },
      name: {
        firstName: "Shelly",
        lastName: "Eller"
      },
      birthData: {
        dateOfBirth: "1990-06-21"
      },
      email: "s.eller@example.com",
      taxInformation: [
        {
          country: "",
          number: "",
          type: ""
        }
      ]
    },
    organization: {
      legalName: ko.observable("Example Company - " + this.getRandomNumberBetween(100, 1000)),
      description: "",
      doingBusinessAs: "API Company Trading",
      type: "privateCompany",
      registeredAddress: {
        city: "Amsterdam",
        country: ko.observable("DE"),
        postalCode: "1011DJ",
        street: ""
      },
      phone: {
        number: "",
        type: ""
      },
      registrationNumber: "34179503",
      email: "organization@example.com",
      taxReportingClassification: {
        businessType: "",
        mainSourceOfIncome: "",
        type: ""
      },
      taxInformation: [
        {
          country: "",
          number: "",
          type: ""
        }
      ],
      vatNumber: ""
    },
    entityAssociations: [
      {
        jobTitle: "CEO",
        legalEntityId: "LE322JV223222D5GG42KN6869",
        type: "signatory"
      }
    ]
  });

  this.onboardingLink = ko.observable({locale: "en-US"});

  this.accountHolder = ko.observable({
    description: ko.computed(() => "Account Holder Description - " + this.legalEntityId()),
    balancePlatform: this.balancePlatform(),
    legalEntityId: ko.computed(() => this.legalEntityId())
  });

  this.createLegalEntity = function() {
    let submitData = JSON.parse(ko.toJSON(this)).legalEntity;
    switch (this.legalEntity().type()) {
      case "organization":
        delete submitData.individual;
        break;
      case "individual":
        delete submitData.organization;
        break;
      default:
        break;
    }

    console.log(submitData);
    return;
    this.balanceApiCall('createLegalEntity', submitData);
  }

  this.createAccountHolder = function() {
    this.balanceApiCall('createAccountHolder', JSON.parse(ko.toJSON(this)).accountHolder);
  }

  this.createOnboardingLink = function() {
    this.balanceApiCall('createOnboardingLink', JSON.parse(ko.toJSON(this)).onboardingLink, [this.legalEntityId()]);
  }

  this.createBalanceAccount = function() {
    this.balanceApiCall('createBalanceAccount', JSON.parse(ko.toJSON(this)).balanceAccount);
  }

  // Path params should be an array, that is simply appended to the end of the url
  this.balanceApiCall = function(url, data, pathParams) {
    let self = this;

    if (pathParams && Array.isArray(pathParams) && pathParams.length > 0) {
      for (let i = 0; i < pathParams.length; i++) {
        url += "/" + pathParams[i];
      }
    }

    console.log(url);

    $.ajax({
      url: '/api/balance/' + url,
      dataType: 'json',
      type: 'post',
      data: data,
      success: function(retData, textStatus, jQxhr) {
        self.populatePostman(url, data, retData);
        self.lastEntityId(retData.response.id);
        switch (url) {
          case 'createLegalEntity':
            self.legalEntityId(retData.response.id);
            break;
          case 'createAccountHolder':
            self.accountHolderId(retData.response.id);
            break;
          default:
            self.lastEntityId(retData.response.id);
            break;
        }
      },
      error: function(jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  }

  this.changeTab = function(tab) {
    this.currentTab(tab);
  }

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

ko.applyBindings(new adyenBalancePlatformsKo());
