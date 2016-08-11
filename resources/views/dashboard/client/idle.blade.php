@extends('layouts.app')

@section('title', 'Client Idle')

@section('content')
    <div id="toot_idle" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            @foreach(glob('img/slides/*.png') as $img)
                <div class="item {{ (glob('img/slides/*.png')[0] == $img) ? 'active' : '' }}">
                    <img src="{{ asset($img) }}" class="img-responsive">
                </div>
            @endforeach
            <div class="carousel-caption">
                <h1 id="touch">Touch the screen to interact.</h1>
            </div>
        </div>
    </div>
    @include('dashboard.client._partials.tap_card')
    @include('dashboard.client._partials.enter_pin')
    @include('dashboard.client._partials.invalid_card')
    @include('dashboard.client._partials.wrong_pin')
    @include('dashboard.client._partials.empty_pin')
    @include('dashboard.client._partials.menu')
    @include('dashboard.client._partials.loading')
    @include('dashboard.client._partials.check_balance')
    @include('dashboard.client._partials.enter_load_amount')
    @include('dashboard.client._partials.empty_load_amount')
    @include('dashboard.client._partials.waiting_for_payment')
    @include('dashboard.client._partials.reload_paid')
    @include('dashboard.client._partials.reload_canceled')
@endsection

@section('style')
    <style>
        body {
            padding-top: 0px;
            padding-bottom: 0px;
        }
    </style>
@endsection