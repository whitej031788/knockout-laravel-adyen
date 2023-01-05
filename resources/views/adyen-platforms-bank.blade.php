@extends('layouts.main')

@section('content')
  <div class="row see-through mild-opacity m-2">
    <div class="col-md-12 text-center">
      <h2 class="text-center mb-2" style="text-decoration:underline;">Adyen for Platforms - Balance</h2>
    </div>
    <div class="col-md-8 offset-md-2 text-center">
      <p>The first step in the process is creating the sub-merchant an account on Adyen.</p>
    </div>
    <div class="col-md-4">
      <h4>Method / URL</h4>
      <div class="col-md-12 p-0" data-bind="text: apiUrlOrMethod"></div>
      <h4>Request</h4>
      <div class="col-md-12 back-white">
        <pre data-bind="html: apiRequest"></pre>
      </div>
      <h4>Response</h4>
      <p>Last Entity ID: <span data-bind="text: lastEntityId"></span> </p>
      <div class="col-md-12 back-white">
        <pre data-bind="html: apiResponse"></pre>
      </div>
    </div>
    <div class="col-md-8">
      <nav class="nav nav-pills flex-column flex-sm-row">
        <a class="flex-sm-fill text-sm-center nav-link" data-bind="click: changeTab.bind($data, 'legalEntity'), css: {active: currentTab() == 'legalEntity'}" href="#">Legal Entity</a>
        <a class="flex-sm-fill text-sm-center nav-link" data-bind="click: changeTab.bind($data, 'accountHolder'), css: {active: currentTab() == 'accountHolder'}" href="#">Account Holder</a>
      </nav>
      <div class="col-md-12" data-bind="css: {'d-none': currentTab() != 'legalEntity'}">
        <h3 class="mt-3">Legal Entity</h3>
        <form data-bind="submit: createLegalEntity">
          <div class="form-group">
            <label>Legal Entity Type</label>
            <select class="form-control mb-2" style="border: 2px solid white;background: white;" data-bind="options: legalEntityTypeOptions, value: legalEntity().type">
            </select>
          </div>
          <div class="form-group">
            <label for="legalEntity.organization.legalName">Legal Entity Name:</label>
            <input type="text" class="form-control" id="legalEntity.organization.legalName" placeholder="Enter Legal Entity Name" data-bind="value: legalEntity().organization.legalName">
          </div>
          <div class="form-group">
            <label for="legalEntity.organization.registeredAddress.country">Country:</label>
            <input type="text" maxlength="2" class="form-control" id="legalEntity.organization.registeredAddress.country" placeholder="Enter country code" data-bind="value: legalEntity().organization.registeredAddress.country" onkeyup="this.value = this.value.toUpperCase();">
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
          <div class="row mt-2">
            <div class="col-md-12">
              <div data-bind="foreach: entityAssociations">
                <button type="button" class="close" aria-label="Close" data-bind="click: $parent.removeEntityAssociation">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="form-group">
                  <label data-bind="attr: { for: 'jobTitle' + $index() }">Job Title:</label>
                  <input type="text" class="form-control" data-bind="attr: { id: 'jobTitle' + $index() }, value: jobTitle" placeholder="Enter job title">
                </div>
                <div class="form-group">
                  <label data-bind="attr: { for: 'legalEntityId' + $index() }">Legal Entity ID:</label>
                  <input type="text" class="form-control" data-bind="attr: { id: 'legalEntityId' + $index() }, value: legalEntityId" placeholder="Enter entity ID">
                </div>
                <div class="form-group">
                  <label data-bind="attr: { for: 'type' + $index() }">Type:</label>
                  <input type="text" class="form-control" data-bind="attr: { id: 'type' + $index() }, value: type" placeholder="Enter entity type">
                </div>
              </div>
              <button type="button" data-bind="click: addEntityAssociation" class="btn btn-primary mb-2">Add Entity Association</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-12" data-bind="css: {'d-none': currentTab() != 'accountHolder'}">
        <h3 class="mt-3">Account Holder</h3>
        <form>
          <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" class="form-control" id="accountHolderDescription" placeholder="Enter description" data-bind="value: accountHolder().description">
          </div>
          <div class="row">
            <div class="col-md-6">
              <button type="submit" data-bind="click: createAccountHolder" class="btn btn-primary">Create Account Holder</button>
            </div>
            <div class="col-md-6" data-bind="css: {'d-none': accountHolderId() === ''}">
              <button type="submit" data-bind="click: createOnboardingLink" class="btn btn-primary">Create HOP URL</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
