@extends('layouts.app')

@section('title', Auth::user()->name . ' (' . \App\Models\Role::find(cashier())->name . ')')

@section('content')
    <div class="cashier-view">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading clearfix">
                    <span class="pull-left">
                        <strong>{{ \App\Models\Role::find(cashier())->name }}: {{ Auth::user()->name }}</strong>
                    </span>
                    <span class="pull-right">
                        <a href="{{ url('logout') }}" class="logout">
                            <strong><i class="fa fa-btn fa-sign-out"></i>Logout</strong>
                        </a>
                    </span>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li>
                            <strong>Transaction: <span class="pull-right">#<span id="transaction_id">123432</span></span></strong>
                        </li>
                        <li><hr></li>
                        <li>
                            <strong>Amount Due: <span class="pull-right">P<span id="transaction_amount_due">0.00</span></span></strong>
                        </li>
                        <li><hr></li>
                        <li class="text-right">
                            <form class="form-inline">
                                <div class="form-group">
                                    <label for="cash_received" class="pull-left">Cash Received:</label>
                                    <button class="btn btn-default" id="cash_received_minus"><i class="fa fa-minus"></i></button>
                                    <div class="input-group">
                                        <span class="input-group-addon">P</span>
                                        <input type="number" class="form-control" id="cash_received">
                                    </div>
                                    <button class="btn btn-default" id="cash_received_plus"><i class="fa fa-plus"></i></button>
                                    <button class="btn btn-warning" id="cash_received_backspace"><i class="fa fa-arrow-left"></i></button>
                                    <button class="btn btn-danger" id="cash_received_clear"><i class="fa fa-times"></i></button>
                                </div>
                            </form>
                        </li>
                        <li class="text-right cash-suggestion">
                            <button class="btn btn-default" id="cash_suggestion_1">1</button>
                            <button class="btn btn-default" id="cash_suggestion_5">5</button>
                            <button class="btn btn-default" id="cash_suggestion_10">10</button>
                            <button class="btn btn-default" id="cash_suggestion_20">20</button>
                            <button class="btn btn-default" id="cash_suggestion_50">50</button>
                            <button class="btn btn-default" id="cash_suggestion_100">100</button>
                            <button class="btn btn-default" id="cash_suggestion_500">500</button>
                            <button class="btn btn-default" id="cash_suggestion_1000">1000</button>
                        </li>
                        <li><hr></li>
                        <li>
                            <strong>Change: <span class="pull-right">P<span id="transaction_change">0.00</span></span></strong>
                        </li>
                        <li class="text-right cashier-actions">
                            <button class="btn btn-success" id="transaction_done"><strong><i class="fa fa-check"></i> Done</strong></button>
                            <button class="btn btn-warning" id="transaction_cancel"><strong><i class="fa fa-times"></i> Cancel</strong></button>
                        </li>
                        <li><hr></li>
                        <li class="text-right">
                            <button class="btn btn-primary" id="create_cardholder"><strong>Create Cardholder</strong></button>
                            <button class="btn btn-primary" id="queued_orders"><strong>Queued Orders <span class="badge" id="queued_orders_count">0</span></strong></button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading clearfix">
                    <span class="pull-left">
                        <strong>Transactions: {{ ucfirst(strtolower(\App\Models\StatusResponse::find(5)->name)) }}</strong>
                    </span>
                    <span class="pull-right">
                        <strong>Payment Method: {{ ucfirst(strtolower(\App\Models\PaymentMethod::find(1)->name)) }}</strong>
                    </span>
                </div>
                <div class="panel-body">
                    <div id="transactions"></div>
                </div>
            </div>
        </div>
    </div>
@endsection