@extends('layouts.app')

@section('title', 'Client Ordering')

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
    @include('dashboard.client._partials.validation')
    @include('dashboard.client._partials.transaction_complete_with_queue_number')
@endsection