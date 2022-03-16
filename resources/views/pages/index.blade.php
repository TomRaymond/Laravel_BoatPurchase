@extends('layouts.app')

@section('content')

<div class="container-lg my-5">
    <div class="row">
        <h1>Introducing the all-new Boat</h1>
    </div>
</div>
<div class="container-lg my-5">
    <div class="row justify-content-center">
      <div class="col">
        <img src ="{{ URL('images/Boat_360x640.jpg') }}" alt="">
      </div>
      <div class="col text-align-left">
        <h3>They say money can't buy you happiness, but who needs happiness when you can have a boat?</h3>
      </div>
    </div>
</div>
<div class="container">
    <button type="button" class="btn btn-primary btn-lg" onclick="window.location='{{ URL::route('checkout.credit-card'); }}'">Buy Now!</button>
</div>

@endsection