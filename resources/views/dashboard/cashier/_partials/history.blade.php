@foreach($transactions as $transaction)
    @if($transaction->loadShares()->get()->count())
        @continue
    @endif

    @if($transaction->reloads()->get()->count())
        <div class="well well-sm history-entry">
            <div class="transaction-heading">
                <span class="pull-left"><strong>Transaction #{{ $transaction->id }}</strong></span>
                <span class="pull-right" data-livestamp="{{ strtotime($transaction->created_at) }}"></span>
            </div>
            <table class="table table-responsive table-transaction">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transaction->reloads()->get() as $reload)
                    <tr>
                        <td>Toot Card (Reload)</td>
                        <td><strong>P{{ number_format($reload->load_amount, 2, '.', ',') }}</strong></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @elseif($transaction->soldCards()->get()->count())
        <div class="well well-sm history-entry">
            <div class="transaction-heading">
                <span class="pull-left"><strong>Transaction #{{ $transaction->id }}</strong></span>
                <span class="pull-right" data-livestamp="{{ strtotime($transaction->created_at) }}"></span>
            </div>
            <table class="table table-responsive table-transaction">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transaction->soldCards()->get() as $sold_card)
                    <tr>
                        <td>Toot Card (New)</td>
                        <td><strong>P{{ number_format($sold_card->price, 2, '.', ',') }}</strong></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @elseif($transaction->cashExtensions()->get()->count())
        <div class="well well-sm history-entry">
            <div class="transaction-heading">
                <span class="pull-left"><strong>Transaction #{{ $transaction->id }}</strong></span>
                <span class="pull-right" data-livestamp="{{ strtotime($transaction->created_at) }}"></span>
            </div>
            <table class="table table-responsive table-transaction">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transaction->cashExtensions()->get() as $cash_extension)
                    <tr>
                        <td>Cash Extension</td>
                        <td><strong>P{{ number_format($cash_extension->amount, 2, '.', ',') }}</strong></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if($transaction->orders()->get()->count())
        <div class="well well-sm history-entry">
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
                @foreach($transaction->orders()->get() as $order)
                    <tr>
                        <td>{{ \App\Models\Merchandise::find($order->merchandise_id)->name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>P{{ number_format($order->total, 2, '.', ',') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td class="text-right">
                        <strong>Total:</strong>
                    </td>
                    <td>
                        <strong>P{{ number_format($transaction->orders()->pluck('total')->sum(), 2, '.', ',') }}</strong>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    @endif
@endforeach