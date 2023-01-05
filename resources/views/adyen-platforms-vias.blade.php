@extends('layouts.main')

@section('content')
  <div class="row see-through mild-opacity m-2">
    <div class="col-md-6 text-center">
      <input type="text" class="form-control" id="merchantAccount" placeholder="Enter merchant account" data-bind="value: merchantAccount">
    </div>
    <div class="col-md-6 text-center">
      <input type="text" class="form-control" id="verificationProfile" placeholder="Enter verification profile" data-bind="value: verificationProfile">
    </div>
    <div class="col-md-12 text-center">
      <h2 class="text-center mb-2" style="text-decoration:underline;">Adyen for Platforms - VIAS</h2>
    </div>
    <div class="col-md-8 offset-md-2">
      <p>The first step in the process is creating the sub-merchant an account on Adyen. This can and should be done as a part of your own sign up process, thus not increasing friction at all (Adyen needs minimal information to allow the partner to start processing payments)</p>
    </div>
    <div class="col-md-4">
      <h4>Method / URL</h4>
      <div class="col-md-12 p-0" data-bind="text: apiUrlOrMethod"></div>
      <h4>Request</h4>
      <div class="col-md-12 back-white">
        <pre data-bind="html: apiRequest"></pre>
      </div>
      <h4>Response</h4>
      <div class="col-md-12 back-white">
        <pre data-bind="html: apiResponse"></pre>
      </div>
    </div>
    <div class="col-md-8">
      <nav class="nav nav-pills flex-column flex-sm-row">
        <a class="flex-sm-fill text-sm-center nav-link" data-bind="click: changeTab.bind($data, 'signUp'), css: {active: currentTab() == 'signUp'}" href="#">Sign Up</a>
        <a class="flex-sm-fill text-sm-center nav-link" data-bind="click: changeTab.bind($data, 'updateAccount'), css: {active: currentTab() == 'updateAccount'}" href="#">Update Account</a>
        <a class="flex-sm-fill text-sm-center nav-link" data-bind="click: changeTab.bind($data, 'uploadDocument'), css: {active: currentTab() == 'uploadDocument'}" href="#">Upload Document</a>
        <a class="flex-sm-fill text-sm-center nav-link" data-bind="click: changeTab.bind($data, 'addNoti'), css: {active: currentTab() == 'addNoti'}" href="#">Add Notification</a>
      </nav>
      <div class="col-md-12" data-bind="css: {'d-none': currentTab() != 'signUp'}">
        <h3 class="mt-3">Sign Up</h3>
        <form data-bind="submit: createAccountHolder">
          <div class="form-group">
            <label>Legal Entity</label>
            <select class="form-control mb-2" style="border: 2px solid white;background: white;" data-bind="options: legalEntityOptions, value: legalEntity">
            </select>
          </div>
          <div class="form-group">
            <label for="accountHolderCode">Account Holder Code:</label>
            <input type="text" class="form-control" id="accountHolderCode" placeholder="Enter account holder code" data-bind="value: accountHolderCode">
          </div>
          <div class="form-group" data-bind="css: {'d-none': legalEntity() != 'Business'}">
            <label for="legalBusinessName">Business Name:</label>
            <input type="text" class="form-control" id="legalBusinessName" placeholder="Enter business name" data-bind="value: legalBusinessName">
          </div>
          <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" class="form-control" id="firstName" placeholder="Enter first name" data-bind="value: firstName">
          </div>
          <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" class="form-control" id="lastName" placeholder="Enter last name" data-bind="value: lastName">
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" placeholder="Enter email" data-bind="value: email">
          </div>
          <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" maxlength="2" class="form-control" id="country" placeholder="Enter country code" data-bind="value: country" onkeyup="this.value = this.value.toUpperCase();">
          </div>
          <div class="form-group">
            <label for="webAddress">Web Address:</label>
            <input type="text" class="form-control" id="webAddress" placeholder="Enter website" data-bind="value: webAddress">
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
      <div class="col-md-12" data-bind="css: {'d-none': currentTab() != 'updateAccount'}">
        <h3 class="mt-3">Update Account</h3>
        <form data-bind="submit: updateAccountHolder">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="createEcomStore" data-bind="value: createEcomStore, checked: createEcomStore">
            <label data-toggle="tooltip" data-placement="right" title="Create an ECOM store" class="form-check-label" for="createEcomStore">Create an ECOM partner store</label>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="createPosStore" data-bind="value: createPosStore, checked: createPosStore">
            <label data-toggle="tooltip" data-placement="right" title="Create a POS store" class="form-check-label" for="createPosStore">Create a POS store</label>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="createFrontLoad" data-bind="value: createFrontLoad, checked: createFrontLoad">
            <label data-toggle="tooltip" data-placement="right" title="Create account holder with all EID fields" class="form-check-label" for="createFrontLoad">Front Load Create Account Holder</label>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="omitBankInfo" data-bind="value: omitBankInfo, checked: omitBankInfo">
            <label data-toggle="tooltip" data-placement="right" title="Use if you are updating account holder with same bank info" class="form-check-label" for="omitBankInfo">Omit Bank Info</label>
          </div>
          <div class="form-group">
            <label for="accountHolderCode">Account Holder Code:</label>
            <input type="text" class="form-control" id="accountHolderCode" placeholder="Enter account holder code" data-bind="value: accountHolderCode">
            <div class="row">
              <div class="col-sm-4">
                <button type="submit" class="btn btn-primary mt-2" data-bind="click: getAccountHolder">Get Account Holder</button>
              </div>
              <div class="col-sm-4">
                <button type="submit" class="btn btn-primary mt-2" data-bind="click: checkAccountHolder">Check Account Holder</button>
              </div>
              <div class="col-sm-4">
                <button type="submit" class="btn btn-primary mt-2" data-bind="click: getOnboardingUrl">Get Onboarding URL</button>
              </div>
              <div class="col-sm-4">
                <button type="submit" class="btn btn-primary mt-2" data-bind="click: getPciQuestionnaireUrl">Get PCI URL</button>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Legal Entity</label>
            <select class="form-control mb-2" style="border: 2px solid white;background: white;" data-bind="options: legalEntityOptions, value: legalEntity">
            </select>
          </div>
          <h5>Identity / Company Check</h5>
          <hr />
          <div class="form-group" data-bind="css: {'d-none': legalEntity() != 'Business'}">
            <label for="legalBusinessName">Business Name:</label>
            <input type="text" class="form-control" id="legalBusinessName" placeholder="Enter business name" data-bind="value: legalBusinessName">
          </div>
          <div class="form-group" data-bind="css: {'d-none': legalEntity() != 'Business'}">
            <label for="registrationNumber">Registration Number:</label>
            <input type="text" class="form-control" id="registrationNumber" placeholder="Enter registrationNumber" data-bind="value: registrationNumber">
          </div>
          <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" class="form-control" id="firstName" placeholder="Enter first name" data-bind="value: firstName">
          </div>
          <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" class="form-control" id="lastName" placeholder="Enter last name" data-bind="value: lastName">
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" placeholder="Enter email" data-bind="value: email">
          </div>
          <div class="form-group">
            <label for="dateOfBirth">Date of Birth:</label>
            <input type="text" class="form-control" id="dateOfBirth" placeholder="Enter dateOfBirth" data-bind="value: dateOfBirth">
          </div>
          <div class="form-group">
            <label for="fullPhoneNumber">Phone Number:</label>
            <input type="text" class="form-control" id="fullPhoneNumber" placeholder="Enter phone number" data-bind="value: fullPhoneNumber">
          </div>
          <div class="form-group">
            <label for="houseNumberOrName">House Number / Name:</label>
            <input type="text" class="form-control" id="houseNumberOrName" placeholder="Enter houseNumberOrName" data-bind="value: houseNumberOrName">
          </div>
          <div class="form-group">
            <label for="street">Street:</label>
            <input type="text" class="form-control" id="street" placeholder="Enter street" data-bind="value: street">
          </div>
          <div class="form-group">
            <label for="fullPhoneNumber">Postal Code:</label>
            <input type="text" class="form-control" id="postalCode" placeholder="Enter postalCode" data-bind="value: postalCode">
          </div>
          <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" id="city" placeholder="Enter city" data-bind="value: city">
          </div>
          <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" maxlength="2" class="form-control" id="country" placeholder="Enter country code" data-bind="value: country" onkeyup="this.value = this.value.toUpperCase();">
          </div>
          <div class="form-group">
            <label for="webAddress">Web Address:</label>
            <input type="text" class="form-control" id="webAddress" placeholder="Enter website" data-bind="value: webAddress">
          </div>
          <h5>Bank Account Check</h5>
          <hr />
          <div class="form-group">
            <label for="ownerName">Bank Owner Name:</label>
            <input type="text" class="form-control" id="ownerName" placeholder="Enter ownerName" data-bind="value: ownerName">
          </div>
          <div class="form-group">
            <label for="ownerHouseNumberOrName">Bank Owner House Number Or Name:</label>
            <input type="text" class="form-control" id="ownerHouseNumberOrName" placeholder="Enter houseNumberOrName" data-bind="value: houseNumberOrName">
          </div>
          <div class="form-group">
            <label for="ownerCity">Bank Owner City:</label>
            <input type="text" class="form-control" id="ownerCity" placeholder="Enter city" data-bind="value: city">
          </div>
          <div class="form-group">
            <label for="ownerPostalCode">Bank Owner Postal Code:</label>
            <input type="text" class="form-control" id="ownerPostalCode" placeholder="Enter postalCode" data-bind="value: postalCode">
          </div>
          <div class="form-group">
            <label for="branchCode">Bank Branch/Sort Code:</label>
            <input type="text" class="form-control" id="branchCode" placeholder="Enter branchCode" data-bind="value: branchCode">
          </div>
          <div class="form-group">
            <label for="bankCountry">Bank Country Code:</label>
            <input type="text" class="form-control" id="bankCountry" placeholder="Enter country" data-bind="value: country">
          </div>
          <div class="form-group">
            <label for="currencyCode">Bank Currency Code:</label>
            <input type="text" class="form-control" id="currencyCode" placeholder="Enter currencyCode" data-bind="value: currencyCode">
          </div>
          <div class="form-group">
            <label for="accountNumber">Bank Account Number:</label>
            <input type="text" class="form-control" id="accountNumber" placeholder="Enter accountNumber" data-bind="value: accountNumber">
          </div>
          <hr />
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
      <div class="col-md-12" data-bind="css: {'d-none': currentTab() != 'uploadDocument'}">
        <h3 class="mt-3">Upload Document</h3>
        <form data-bind="submit: uploadDocument">
          <div class="form-group">
            <label>Document Type</label>
            <select class="form-control mb-2" style="border: 2px solid white;background: white;" data-bind="options: documentTypeOptions, value: documentType">
            </select>
          </div>
          <div class="form-group" data-bind="css: {'d-none': documentType() != 'BANK_STATEMENT'}">
            <label for="bankAccountUUID">Bank Account UUID:</label>
            <input type="text" class="form-control" id="bankAccountUUID" placeholder="Enter bank account UUID" data-bind="value: bankAccountUUID">
          </div>
          <div class="form-group">
            <label for="accountHolderCode">Account Holder Code:</label>
            <input type="text" class="form-control" id="accountHolderCode" placeholder="Enter account holder code" data-bind="value: accountHolderCode">
          </div>
          <div class="form-group">
            <label for="documentDescription">Document Description:</label>
            <input type="text" class="form-control" id="documentDescription" placeholder="Enter document description" data-bind="value: documentDescription">
          </div>
          <div class="form-group">
            <label for="shareholderCode">Shareholder Code:</label>
            <input type="text" class="form-control" id="shareholderCode" placeholder="Enter shareholder code" data-bind="value: shareholderCode">
          </div>
          <div class="form-group">
            <label for="documentData">Upload Document</label>
            <input data-bind="event: {change: fileUpload}" type="file" class="fileChooser form-control-file" id="documentData" />
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
      <div class="col-md-12" data-bind="css: {'d-none': currentTab() != 'addNoti'}">
        <h3 class="mt-3">Add Notification Endpoint</h3>
        <form data-bind="submit: createNotificationConfiguration">
          <div class="form-group">
            <label for="notificationDescription">Notification Description:</label>
            <input type="text" class="form-control" id="notificationDescription" placeholder="Enter description" data-bind="value: notificationDescription">
          </div>
          <div class="form-group">
            <label for="notifyURL">Notification URL:</label>
            <input type="text" class="form-control" id="notifyURL" placeholder="Enter URL" data-bind="value: notifyURL">
          </div>
          <div class="form-group">
            <label for="notifyUsername">Notification Username:</label>
            <input type="text" class="form-control" id="notifyUsername" placeholder="Enter username" data-bind="value: notifyUsername">
          </div>
          <div class="form-group">
            <label for="notifyPassword">Notification Password:</label>
            <input type="text" class="form-control" id="notifyPassword" placeholder="Enter password" data-bind="value: notifyPassword">
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
