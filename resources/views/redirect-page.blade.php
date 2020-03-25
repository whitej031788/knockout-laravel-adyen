@extends('layouts.main')

@section('content')
  <script>
    bladeJsonObj = {!! $serverObject !!};
  </script>
  <div class="row see-through mild-opacity mt-3">
    <div class="col-md-6 offset-md-3">
      <h3 class="text-center">Adyen Redirect Result</h3>
      <p>Many Adyen payment methods redirect the shopper away, and then eventually redirect them back.
       At this point, we need to check the paymentData and details</p>
       <h4 data-bind="text: apiUrlOrMethod"></h4>
       <div class="col-md-12 back-white">
         <pre data-bind="html: apiRequest"></pre>
       </div>
       <div class="col-md-12 back-white">
         <pre data-bind="html: apiResponse"></pre>
       </div>
    </div>
  </div>
@endsection
