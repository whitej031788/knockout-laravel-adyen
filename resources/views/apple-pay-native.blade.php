{{-- @extends('layouts.main')

@section('content')
  <div class="row see-through mild-opacity m-4">
    <div class="col-4 offset-4 text-center" data-bind="visible: showApplePayButton()">
      <a lang="us" class="applePayButton" style="-webkit-appearance: -apple-pay-button; -apple-pay-button-type: plain; -apple-pay-button-style: black; height: 30px; width: 150px;" data-bind="click: startApplePaySession" title="Start Apple Pay" role="link" tabindex="0"></a>
    </div>
  </div>
@endsection --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <div>
      <div data-bind="visible: showApplePayButton()">
        <a lang="us" class="applePayButton" style="-webkit-appearance: -apple-pay-button; -apple-pay-button-type: plain; -apple-pay-button-style: black; height: 30px; width: 150px;" data-bind="click: startApplePaySession" title="Start Apple Pay" role="link" tabindex="0"></a>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.0/knockout-min.js"></script>
    <script src="/js/knockout/apple-pay-native.js"></script>
  </body>
</html>
