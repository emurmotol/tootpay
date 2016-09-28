@foreach($transactions as $transaction)
    <div class="well well-sm queued-entry">
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
                <td>
                    <button type="button" class="btn btn-success btn-lg btn-served-order" data-transaction_id="{{ $transaction->id }}"><strong>Served</strong></button>
                </td>
                <td class="text-right">
                    <strong>Total:</strong>
                </td>
                <td>
                    <strong>P<span>{{ number_format($transaction->orders()->pluck('total')->sum(), 2, '.', ',') }}</span></strong>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endforeach