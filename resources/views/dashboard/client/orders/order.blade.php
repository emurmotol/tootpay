@extends('layouts.app')

@section('title', 'Client Ordering')

@section('content')
    <div class="client-order">
        <div class="col-md-6">
            <div class="panel panel-primary order">
                <div class="panel-heading clearfix">
                    <span class="pull-left"><strong>Orders</strong></span>
                    <span class="pull-right">
                        <i class="fa fa-question-circle" aria-hidden="true" id="edit_orders_help"></i>
                    </span>
                </div>
                <table class="table table-responsive table-striped" id="table_orders">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th class="text-center">Qty</th>
                        <th>Each</th>
                        <th>Total</th>
                        <th class="text-center"><i class="fa fa-trash"></i></th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="panel-body clearfix">
                    <div class="pull-right">
                        <div class="text-right">
                            <div class="grand_total text-right">
                                <strong>P<span id="grand_total">0.00</span></strong>
                            </div>
                        </div>
                        <div class="order-actions">
                            <ul class="list-inline">
                                <li>
                                    <button class="btn btn-warning btn-lg" id="btn_cancel" data-loading-text="{{ trans('loading.default') }}">
                                        <strong>Cancel Order</strong>
                                    </button>
                                </li>
                                <li>
                                    <button class="btn btn-info btn-lg" id="btn_hold" disabled>
                                        <strong>Hold Order</strong>
                                    </button>
                                </li>
                            </ul>
                            <ul class="list-inline">
                                <li>
                                    <strong>Pay using:</strong>
                                </li>
                                <li>
                                    <button class="btn btn-primary btn-lg" id="btn_pay_using_toot_card" disabled>
                                        <strong>Toot Card</strong>
                                    </button>
                                </li>
                                <li>
                                    <button class="btn btn-success btn-lg" id="btn_pay_using_cash" disabled>
                                        <strong>Cash</strong>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
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

    @include('dashboard.client._partials.modals.tap_card')
    @include('dashboard.client._partials.modals.enter_pin')
    @include('dashboard.client._partials.modals.validation')
    @include('dashboard.client.orders._partials.modals.transaction_complete_with_queue_number')
@endsection