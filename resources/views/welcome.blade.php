@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="welcome">
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <img src="{{ asset('img/logo.png') }}" class="img-responsive logo-welcome" alt="Toot Card Logo">
                        <p>A cashless payment system using digital wallet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
