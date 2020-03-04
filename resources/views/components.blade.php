@extends('layouts.main')

@section('content')
  <div class="row see-through mild-opacity mt-3">
    <div class="col-md-12 text-center">
      <h1 class="text-center">Adyen Components Web Integration</h1>
    </div>
    <div class="col-md-6 offset-md-3">
      @component('layouts.payment-methods-form')
      @endcomponent
    </div>
  </div>
@endsection
