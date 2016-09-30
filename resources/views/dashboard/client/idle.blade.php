@extends('layouts.app')

@section('title', 'Client Idle')

@section('content')
    <div id="toot_idle" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            @foreach(glob('img/slides/*.jpg') as $img)
                <div class="item {{ (glob('img/slides/*.jpg')[0] == $img) ? 'active' : '' }}">
                    <img src="{{ asset($img) }}" class="img-responsive">
                </div>
            @endforeach
            <div class="carousel-caption">
                <h1 id="touch">Touch the screen to interact.</h1>
            </div>
        </div>
    </div>

    @include('dashboard.client._partials.modals.please_wait')
    @include('dashboard.client._partials.modals.tap_card')
    @include('dashboard.client._partials.modals.enter_pin')
    @include('dashboard.client._partials.modals.menu')
    @include('dashboard.client._partials.modals.enter_load_amount')
    @include('dashboard.client._partials.modals.enter_user_id')
    @include('dashboard.client._partials.modals.loading')
    @include('dashboard.client._partials.modals.validation')
    @include('dashboard.client.transactions._partials.modals.toot_card_details')
@endsection