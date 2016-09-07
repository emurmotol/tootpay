@extends('layouts.app')

@section('title', 'Change Pin Code')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.cardholder._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <span class="pull-left">@yield('title')</span>
                    </div>
                    <div class="panel-body">
                        @include('dashboard.cardholder.toot_card._partials.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection