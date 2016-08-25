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
                        <i class="fa fa-question-circle" aria-hidden="true" id="select_orders_help"></i>
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
    @include('dashboard.client._partials.validations.order_on_hold')
    @include('dashboard.client._partials.validations.insufficient_balance')
    @include('dashboard.client._partials.validations.transaction_complete')
    @include('dashboard.client._partials.validations.transaction_complete_with_queue_number')
    @include('dashboard.client._partials.validations.loading')
    @include('dashboard.client._partials.validations.waiting_for_payment')
@endsection