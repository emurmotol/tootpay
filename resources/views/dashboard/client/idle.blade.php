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
                <input type="number" class="input-unstyled" id="idle_toot_card_id" pattern="[0-9]{10}" maxlength="10" autofocus>
            </div>
        </div>
    </div>

    @include('dashboard.client._partials.tap_card')
    @include('dashboard.client._partials.enter_pin')
    @include('dashboard.client._partials.menu')
    @include('dashboard.client._partials.toot_card_details')
    @include('dashboard.client._partials.enter_load_amount')
    @include('dashboard.client._partials.enter_user_id')
    @include('dashboard.client._partials.undone_orders')
    @include('dashboard.client._partials.loading')
    @include('dashboard.client._partials.validation')
@endsection

@section('style')
    <style>
        body {
            padding-top: 0px;
            padding-bottom: 0px;
        }
    </style>
@endsection