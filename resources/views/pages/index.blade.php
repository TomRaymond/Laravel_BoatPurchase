@extends('layouts.app')

@section('content')

<link href="{{ asset('css/styles.css') }}" rel="stylesheet">

<div class="container-lg my-auto">
    <div class="row mb-3">
        <h3 class="text-responsive">Introducing the all-new Boat</h3>
    </div>
    <div class="row mb-3">
        <h5 class="text-responsive">They say money can't buy you happiness, but who needs happiness when you can have a boat?</h5>
    </div>
    <div class="row mb-3">
        <div class="col-8">
            <img src ="{{ URL('images/Boat_2560x1440.jpg') }}" width="100%" alt="">
        </div>
        <div class="col-1"></div>
        <div class="col my-auto">
            <h3 class="text-responsive">Only £500,000!</h3>
        </div>
    </div>    
    <div class="row text-responsive">
        <p class="card-text">Contains the latest features:</p>
    </div>
    <div class="row text-responsive">
        <div class="col-auto">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">- Floats on water</li>
            <li class="list-group-item">- Unlikely to get stuck in the Suez canal</li>
            <li class="list-group-item">- Raises your self-esteem</li>
        </ul>
        <button type="button" class="btn btn-primary btn-lg" onclick="window.location='{{ URL::route('checkout.credit-card'); }}'">Buy Now!</button>
    </div> 
</div>

@endsection