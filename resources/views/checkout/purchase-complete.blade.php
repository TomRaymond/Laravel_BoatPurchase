@extends('layouts.app')

@section('content')
@php
    $email = $_POST['email'];
    $token = $_POST['_token'];
@endphp

<div class="container-lg my-5">
    <div class="row">
        <h1>Thank you for your boat purchase</h1>
    </div>
    <div class="row mt-4">
        <h2>We will be in touch once your pre-order is available for delivery</h2>
    </div>
</div>

@endsection