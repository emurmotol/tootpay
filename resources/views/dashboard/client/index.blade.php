@extends('layouts.app')

@section('title', 'Client Order')

@section('content')
    <div class="client-order">
        <div class="col-md-6">
            @include('dashboard.client._partials.orders')
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading clearfix">
                    <span class="pull-left">
                        <strong>Today's Menu ({{ date('l') }})</strong>
                    </span>
                    <span class="pull-right">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="panel-body merchandise-list" id="todays_menu"></div>
            </div>
        </div>
    </div>

    @include('dashboard.client._partials.tap_card')
    @include('dashboard.client._partials.enter_pin')

    @include('dashboard.client._partials.validations.invalid_card')
    @include('dashboard.client._partials.validations.wrong_pin')
    @include('dashboard.client._partials.validations.empty_pin')
    @include('dashboard.client._partials.validations.insufficient_load')
    @include('dashboard.client._partials.validations.payment_success')
@endsection