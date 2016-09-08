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
                        <th>Amount Due</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transaction->reloads()->get() as $reload)
                        <tr>
                            <td>Reload</td>
                            <td>P<span id="grand_total">{{ number_format($reload->total, 2, '.', ',') }}</span></td>
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
                    <tr class="grand-total">
                        <td></td>
                        <td  class="text-right">
                            <strong>Amount Due:</strong>
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