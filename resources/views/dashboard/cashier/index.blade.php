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
                            <strong>Amount Due: <span class="pull-right">P0.00</span></strong>
                        </li>
                        <li><hr></li>
                        <li class="text-right">
                            <form class="form-inline">
                                <div class="form-group">
                                    <label for="cash_received" class="pull-left">Cash Received:</label>
                                    <button class="btn btn-default"><i class="fa fa-minus"></i></button>
                                    <div class="input-group">
                                        <span class="input-group-addon">P</span>
                                        <input type="number" class="form-control" id="cash_received">
                                    </div>
                                    <button class="btn btn-default"><i class="fa fa-plus"></i></button>
                                    <button class="btn btn-warning"><i class="fa fa-arrow-left"></i></button>
                                    <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                                </div>
                            </form>
                        </li>
                        <li class="text-right cash-suggestion">
                            <button class="btn btn-default">1</button>
                            <button class="btn btn-default">5</button>
                            <button class="btn btn-default">10</button>
                            <button class="btn btn-default">20</button>
                            <button class="btn btn-default">50</button>
                            <button class="btn btn-default">100</button>
                            <button class="btn btn-default">500</button>
                            <button class="btn btn-default">1000</button>
                        </li>
                        <li><hr></li>
                        <li>
                            <strong>Change: <span class="pull-right">P0.00</span></strong>
                        </li>
                        <li><hr></li>
                        <li class="text-right">
                            <button class="btn btn-success"><strong>Done</strong></button>
                            <button class="btn btn-warning"><strong>Cancel</strong></button>
                        </li>
                        <li><hr></li>
                        <li class="text-right">
                            <div class="well well-sm">
                                <button class="btn btn-primary"><strong>Make Cardholder</strong></button>
                            </div>
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

                </div>
            </div>
        </div>
    </div>
@endsection