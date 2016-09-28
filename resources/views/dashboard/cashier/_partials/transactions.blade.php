@foreach($transactions as $transaction)
    <a href="#{{ $transaction->id }}" class="transaction-entry" data-transaction_id="{{ $transaction->id }}">
        <div class="well well-sm well-transaction">
            <div class="transaction-heading">
                <span class="pull-left"><strong>Transaction #{{ $transaction->id }}</strong></span>
                <span class="pull-right" data-livestamp="{{ strtotime($transaction->created_at) }}"></span>
            </div>
            @if($transaction->reloads()->get()->count())
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
                            <td><strong>Toot Card (Reload)</strong></td>
                            <td>P<span id="grand_total">{{ number_format($reload->load_amount, 2, '.', ',') }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
             @elseif($transaction->soldCards()->get()->count())
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
                            <td><strong>Toot Card (New)</strong></td>
                            <td>P<span id="grand_total">{{ number_format($sold_card->price, 2, '.', ',') }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @elseif($transaction->cashExtensions()->get()->count())
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
                            <td><strong>Cash Extension</strong></td>
                            <td>P<span id="grand_total">{{ number_format($cash_extension->amount, 2, '.', ',') }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @elseif($transaction->orders()->get()->count())
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
                        <td  class="text-right">
                            <strong>Total:</strong>
                        </td>
                        <td>
                            <strong>P<span id="grand_total">{{ number_format($transaction->orders()->pluck('total')->sum(), 2, '.', ',') }}</span></strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </a>
@endforeach