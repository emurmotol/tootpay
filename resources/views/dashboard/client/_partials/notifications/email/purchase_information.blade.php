@include('dashboard.client._partials.notifications.email._partials.header')
<div class="message">
    <p>Digital Purchase Information: {{ $data->created_at->toDayDateTimeString() }}</p>
    <p>Transaction: #{{ $data->id }}</p>
    <p>Queue: #{{ $data->queue_number }}</p>
    <div class="well">
        <p>Orders:</p>
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>Name</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->orders()->get() as $order)
                <tr>
                    <td>{{ \App\Models\Merchandise::find($order->merchandise_id)->name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>P{{ number_format($order->total, 2, '.', ',') }}</td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td><strong>Total:</strong></td>
                <td><strong>P{{ number_format(collect($data->orders()->get())->pluck('total')->sum(), 2, '.', ',') }}</strong></td>
            </tr>
            </tbody>
        </table>
    </div>
    <p>Thank you. Enjoy your meal!</p>
</div>
@include('dashboard.client._partials.notifications.email._partials.footer')