<!DOCTYPE html>
<html>
<head>

  <script src="https://checkoutshopper-test.adyen.com/checkoutshopper/sdk/3.17.0/adyen.js"
  integrity="sha384-G9jkTAyCOIVdksXbtrNgdur2DyRi85ujYLXbqe5AvvH23rN21d7xiU7cRIqvsEaH"
  crossorigin="anonymous"></script>
  <!-- Adyen provides the SRI hash that you include as the integrity attribute. Refer to our release notes to get the SRI hash for the specific version. https://docs.adyen.com/checkout/release-notes -->

  <link rel="stylesheet" href="https://checkoutshopper-test.adyen.com/checkoutshopper/sdk/3.17.0/adyen.css"
  integrity="sha384-gbQyzqV1xX+snFEMrubEm0IpmYSufBjUnHzTaJZ+dcWCyxl0j94IZhnfC2gbxgeu"
  crossorigin="anonymous">
  <!-- Adyen provides the SRI hash that you include as the integrity attribute. Refer to our release notes to get the SRI hash for the specific version. https://docs.adyen.com/checkout/release-notes -->

  <script src="https://code.jquery.com/jquery-3.4.1.js" 	integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" 	crossorigin="anonymous"></script>

  <script src="/js/knockout/peter-imp.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

  <style>
  .pretty-border {
  	word-wrap:break-word;
  	border:1px solid #17a2b8;
  	padding: 1em;
  	border-radius: 5px;
  	min-width: 100%;

  }

  .col {
  	min-width: 50%;
  	max-width: 50%;
  }

  #left-col{
  	padding-left: 2em;
  	padding-top: 1em;
  }
  </style>
</head>


<body>

  <br />
  <div class="row">
    <div id="left-col" class="col">
      <div class="container">
        <div id="card-container"></div>
      </div>
      <div class="container">
        <div id="threeds-container"></div>
      </div>
      <br />
      <div class="container">
        <div id="ideal-container"></div>
      </div>
      <br />
      <div class="container">
        <div id="sepa-container"></div>
      </div>
      <div class="container">
        <div id="dropin-container"></div>
      </div>
    </div>
    <div class="col">
      <div class="container">
        <p>Response Data:</p>
        <pre class="pretty-border" id="results-container"></pre>
      <div class="bd-clipboard">
        <button type="button" class="btn btn-info" id="copy-button">Copy</button>
      </div>
      </div>
      <br />
      <div class="container">
        <p>Submission Data:</p>
        <textarea class="pretty-border" id="submission-container"></textarea>
      <div class="bd-clipboard">
        <button type="button" class="btn btn-info" id="submit-button">Submit</button>
      </div>
      </div>

    </div>
  </div>



<br />
  <textarea id="results-container-hidden"></textarea>

</body>
</html>
