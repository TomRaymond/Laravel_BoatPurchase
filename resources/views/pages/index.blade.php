@extends('layouts.app')

@section('content')

<div class="container-lg my-5">
    <div class="row mb-3">
        <h3>Introducing the all-new Boat</h3>
    </div>
    <div class="row mb-3">
        <h5>They say money can't buy you happiness, but who needs happiness when you can have a boat?</h5>
    </div>
    <div class="row mb-3">
        <div class="col">
            <img src ="{{ URL('images/Boat_2560x1440.jpg') }}" width="100%" alt="">
        </div>
        <div class="col col-1"></div>
        <div class="col my-auto">
            <h2>Only £500,000!</h2>
        </div>
    </div>    
    <div class="row">
        <p class="card-text">Contains the latest features:</p>
    </div>
    <div class="row">
        <div class="col-6">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">- Floats on water</li>
            <li class="list-group-item">- Unlikely to get stuck in the Suez canal</li>
            <li class="list-group-item">- Raises your self-esteem</li>
        </ul>
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-primary btn-lg" onclick="window.location='{{ URL::route('checkout.credit-card'); }}'">Buy Now!</button>
    </div>      
</div>
@endsection