<p>Digital Purchase Information: {{ \Carbon\Carbon::now()->toDayDateTimeString() }}</p>
<p>Transaction: #{{ $data->id }}</p>
<p>Queue: #{{ $data->queue_number }}</p>
<p>Orders:</p>
@foreach($data->orders()->get() as $order)
    <p>{{ \App\Models\Merchandise::find($order->merchandise_id)->name }}, Qty: {{ $order->quantity }}, Total: P{{ number_format($order->total, 2, '.', ',') }}</p>
@endforeach
<p>with the total amount of: P{{ number_format(collect($data->orders()->get())->pluck('total')->sum(), 2, '.', ',') }}.</p>
<p>Thank you. Enjoy your meal!</p>
<p>Sent from {{ url('/') }}.</p>