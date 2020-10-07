@extends('layouts.main')

@section('content')
  <div class="row see-through mild-opacity mt-3">
    <div class="col-md-6 offset-md-3">
      <h3 class="text-center mb-5">Cell Centre Iframe</h3>
    </div>
    <div class="col-md-10 offset-md-1">
      <iframe src="https://callcenter-test.adyen.com/callcenter/action/login.shtml" style="width: 100%; height: 500px;" title="W3Schools Free Online Web Tutorials"></iframe>
    </div>
  </div>
@endsection
