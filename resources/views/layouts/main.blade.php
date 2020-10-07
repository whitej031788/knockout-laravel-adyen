<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Jamie Adyen Integration</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Style Sheets -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/adyen-custom.css">

    {{-- <link rel="stylesheet" href="https://checkoutshopper-test.adyen.com/checkoutshopper/sdk/3.11.4/adyen.css"
    integrity="sha384-gTrHdtmLDTaHuDUKM1okZAVgBTwjiI+E66Tz3K71+10Lhd7zxvtUF5lrHc35cNIR"
    crossorigin="anonymous"> --}}
    <link rel="stylesheet"
        type="text/css"
        href="https://checkoutshopper-test.adyen.com/checkoutshopper/sdk/3.11.4/adyen.css"
        integrity="sha384-gTrHdtmLDTaHuDUKM1okZAVgBTwjiI+E66Tz3K71+10Lhd7zxvtUF5lrHc35cNIR"
        crossorigin="anonymous">
    <!-- Adyen provides the SRI hash that you include as the integrity attribute. Refer to our release notes to get the SRI hash for the specific version. https://docs.adyen.com/checkout/release-notes -->

  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Adyen</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/components">Components</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/api-only">API Only</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/classic-client-encryption">Classic CSE / Authorise EP</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/classic-hpp">Classic HPP</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/pos-terminal-api">POS Terminal API</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/custom-card-component">Custom Card Component</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/secured-fields">Secured Fields</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/apple-pay-native">Apple Pay Native</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/adyen-platforms">Adyen Platforms</a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="container-fluid">
      @yield('content')
    </div>
    <script src="https://pay.google.com/gp/p/js/pay.js"></script>
    {{-- <script src="https://checkoutshopper-test.adyen.com/checkoutshopper/sdk/3.11.4/adyen.js"
    integrity="sha384-r6VzatKWD1SDwT5pfnl6sfkNJYAsTAUlUOO6PEbIhMwWFkPrE28R/8cjAKBp9yCd"
    crossorigin="anonymous"></script> --}}
    <script src="https://checkoutshopper-test.adyen.com/checkoutshopper/sdk/3.11.4/adyen.js"
         integrity="sha384-r6VzatKWD1SDwT5pfnl6sfkNJYAsTAUlUOO6PEbIhMwWFkPrE28R/8cjAKBp9yCd"
         crossorigin="anonymous"></script>
    <!-- Adyen provides the SRI hash that you include as the integrity attribute. Refer to our release notes to get the SRI hash for the specific version. https://docs.adyen.com/checkout/release-notes -->

  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/require.js/2.3.6/require.min.js"></script> --}}
  {{-- <script>
  require(["https://checkoutshopper-test.adyen.com/checkoutshopper/sdk/3.7.0/adyen.js"], function(AdyenCheckout) {
    window.AdyenCheckout = AdyenCheckout;
  });
  </script> --}}

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.0/knockout-min.js"></script>
    <script src="/js/knockout/{{$view_name}}.js" type="module"></script>
    <script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
    </script>
    <script src="https://x.klarnacdn.net/kp/lib/v1/api.js" async></script>
  </body>
</html>
