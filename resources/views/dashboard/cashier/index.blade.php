@extends('layouts.app')

@section('title', Auth::user()->name . ' (Cashier)')

@section('content')
    <div class="container">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-12">
                <h2 style="margin-top: -10px;">
                    <div class="pull-left">
                        QUEUE: <strong>5 Orders</strong>
                    </div>
                    <div class="pull-right">
                        {{ \Carbon\Carbon::now()->toDayDateTimeString() }}
                    </div>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="pull-left">
                            <strong>#1</strong>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-success btn-xs">DONE</button>
                            <button class="btn btn-default btn-xs">EDIT</button>
                            <button class="btn btn-info btn-xs">CANCEL</button>
                        </div>
                    </div>

                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th>ITEM</th>
                            <th>QTY</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>SINIGANG NA BABOY</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>RICE</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>COKE</td>
                            <td>1</td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="panel-footer clearfix">
                        <div class="pull-left">
                            ORDER ID: 234
                        </div>
                        <div class="pull-right">
                            {{ strtoupper(\Carbon\Carbon::now()->diffForHumans()) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="pull-left">
                            <strong>#2</strong>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-success btn-xs">DONE</button>
                            <button class="btn btn-default btn-xs">EDIT</button>
                            <button class="btn btn-info btn-xs">CANCEL</button>
                        </div>
                    </div>

                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th>ITEM</th>
                            <th>QTY</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>ADOBONG ULAM</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>RICE</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>PEPSI</td>
                            <td>1</td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="panel-footer clearfix">
                        <div class="pull-left">
                            ORDER ID: 23423
                        </div>
                        <div class="pull-right">
                            {{ strtoupper(\Carbon\Carbon::now()->diffForHumans()) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="pull-left">
                            <strong>#3</strong>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-success btn-xs">DONE</button>
                            <button class="btn btn-default btn-xs">EDIT</button>
                            <button class="btn btn-info btn-xs">CANCEL</button>
                        </div>
                    </div>

                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th>ITEM</th>
                            <th>QTY</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>SPAGHETTI</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>SKY FLAKES</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>COKE</td>
                            <td>1</td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="panel-footer clearfix">
                        <div class="pull-left">
                            ORDER ID: 345
                        </div>
                        <div class="pull-right">
                            {{ strtoupper(\Carbon\Carbon::now()->diffForHumans()) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="pull-left">
                            <strong>#4</strong>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-success btn-xs">DONE</button>
                            <button class="btn btn-default btn-xs">EDIT</button>
                            <button class="btn btn-info btn-xs">CANCEL</button>
                        </div>
                    </div>

                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th>ITEM</th>
                            <th>QTY</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>HUMBA</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>RICE</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>COKE</td>
                            <td>1</td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="panel-footer clearfix">
                        <div class="pull-left">
                            ORDER ID: 456
                        </div>
                        <div class="pull-right">
                            {{ strtoupper(\Carbon\Carbon::now()->diffForHumans()) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="pull-left">
                            <strong>#5</strong>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-success btn-xs">DONE</button>
                            <button class="btn btn-default btn-xs">EDIT</button>
                            <button class="btn btn-info btn-xs">CANCEL</button>
                        </div>
                    </div>

                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th>ITEM</th>
                            <th>QTY</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>SABAW</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>RICE</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>WATER</td>
                            <td>1</td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="panel-footer clearfix">
                        <div class="pull-left">
                            ORDER ID: 87
                        </div>
                        <div class="pull-right">
                            {{ strtoupper(\Carbon\Carbon::now()->diffForHumans()) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection