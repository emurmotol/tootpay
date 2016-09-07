@extends('layouts.app')

@section('title', 'Order History')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.cardholder._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <span class="pull-left">Order History</span>
                        <span class="pull-right">Transactions: {{ $transactions->count() }}</span>
                    </div>
                    @if ($transactions->count())
                        <div class="panel-body">
                            @foreach($transactions as $transaction)
                                <div class="well well-sm">
                                    <div class="transaction-heading">
                                        <span class="pull-left"><strong>Transaction #{{ $transaction->id }}</strong></span>
                                        <span class="pull-right" data-livestamp="{{ strtotime($transaction->created_at) }}"></span>
                                    </div>
                                    <table class="table table-responsive table-transaction">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            @if($order->pivot->transaction_id == $transaction->id)
                                                <tr>
                                                    <td>{{ \App\Models\Merchandise::find($order->merchandise_id)->name }}</td>
                                                    <td>{{ $order->quantity }}</td>
                                                    <td>P{{ number_format($order->total, 2, '.', ',') }}</td>
                                                </tr>

                                                @if($orders->where('pivot.transaction_id', $transaction->id)->last()->id == $order->id)
                                                    <tr class="grand-total">
                                                        <td></td>
                                                        <td  class="text-right">
                                                            <strong>Amount Due:</strong>
                                                        </td>
                                                        <td>
                                                            <strong>P{{ number_format($orders->where('pivot.transaction_id', $transaction->id)->pluck('total')->sum(), 2, '.', ',') }}</strong>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    @else
                        @include('_partials.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection