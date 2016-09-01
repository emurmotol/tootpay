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

    @include('dashboard.client._partials.modals.tap_card')
    @include('dashboard.client._partials.modals.enter_pin')
    @include('dashboard.client._partials.modals.menu')
    @include('dashboard.client._partials.modals.enter_load_amount')
    @include('dashboard.client._partials.modals.enter_user_id')
    @include('dashboard.client._partials.modals.loading')
    @include('dashboard.client._partials.modals.validation')
    @include('dashboard.client.orders._partials.modals.user_order')
    @include('dashboard.client.transactions._partials.modals.toot_card_details')
@endsection

@section('style')
    <style>
        body {
            padding-top: 0px;
            padding-bottom: 0px;
        }
    </style>
@endsection