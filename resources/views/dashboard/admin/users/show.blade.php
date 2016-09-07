@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.admin.users._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <span class="pull-left"><i class="fa fa-user" aria-hidden="true"></i> @yield('title')</span>
                        <span class="pull-right">
                            {!! Form::open([
                                'route' => ['users.destroy', $user->id,
                                'redirect=' . request()->get('redirect')],
                                'class' => '']) !!}
                            {!! Form::hidden('_method', 'DELETE') !!}
                            <a href="{{ route('users.edit', [$user->id, 'redirect' => Request::fullUrl()]) }}"
                               class="btn btn-default btn-xs">Edit</a>
                                <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                            {!! Form::close() !!}
                        </span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="img-user">
                                    <a href="{{ $user->gravatar }}">
                                        <img src="{{ $user->gravatar }}" class="img-responsive img-rounded" alt="{{ $user->name }}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <ul class="list-unstyled">
                                    <li><h4>Name: <strong>{{ $user->name }}</strong></h4></li>
                                    <li><h4>Role: <strong>{{ $user->roles()->first()->name }}</strong></h4></li>
                                        @if($user->hasRole(cardholder()))
                                        <li>
                                            <h4>
                                                Toot Card ID:
                                                @if(is_null($user->tootCards()->first()))
                                                    <strong>Not set</strong>
                                                @else
                                                    <a href="{{ route('toot_cards.show', $user->tootCards()->first()->id) }}">
                                                        <strong>{{ $user->tootCards()->first()->id }}</strong>
                                                    </a>
                                                @endif
                                            </h4>
                                        </li>
                                        @endif
                                    <li><h4>User ID: <strong>{{ $user->id }}</strong></h4></li>
                                    <li><h4>E-Mail Address: <strong>{{ $user->email }}</strong></h4></li>
                                    <li><h4>Phone Number: <strong>{{ $user->phone_number }}</strong></h4></li>
                                    <li><h4>Created: <strong>{{ $user->created_at->toFormattedDateString() }}</strong></h4></li>
                                    <li><h4>Updated: <strong data-livestamp="{{ strtotime($user->updated_at) }}"></strong></h4></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @unless(is_null($user->tootCards()->first()))
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
                                                        <td>
                                                            <a href="{{ route('merchandises.show', [$order->merchandise_id, 'redirect' => Request::fullUrl()]) }}">
                                                                <strong>{{ \App\Models\Merchandise::find($order->merchandise_id)->name }}</strong>
                                                            </a>
                                                        </td>
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
                @endunless
            </div>
        </div>
    </div>
@endsection