@if(count($queued))
    {{ config('static.status')[9] }}:
    @foreach(\App\Models\Merchandise::groupOrderIds($queued) as $order_id)
        ORDER_ID: {{ $order_id }}, QUEUE_NUMBER: {{ \App\Models\Merchandise::orders($order_id)->first()->queue_number }}
        @foreach(\App\Models\Merchandise::orders($order_id)->get() as $order)
            MERCHANDISE_ID: {{ $order->merchandise_id }}, ORDER_ID: {{ $order->order_id }}
        @endforeach
    @endforeach
@endif

@if(count($on_hold))
    {{ config('static.status')[11] }}:
    @foreach(\App\Models\Merchandise::groupOrderIds($on_hold) as $order_id)
        ORDER_ID: {{ $order_id }}
        @foreach(\App\Models\Merchandise::orders($order_id)->get() as $order)
            MERCHANDISE_ID: {{ $order->merchandise_id }}, ORDER_ID: {{ $order->order_id }}
        @endforeach
    @endforeach
@endif

@if(count($pending))
    {{ config('static.status')[4] }}:
    @foreach(\App\Models\Merchandise::groupOrderIds($pending) as $order_id)
        ORDER_ID: {{ $order_id }}
        @foreach(\App\Models\Merchandise::orders($order_id)->get() as $order)
            MERCHANDISE_ID: {{ $order->merchandise_id }}, ORDER_ID: {{ $order->order_id }}
        @endforeach
    @endforeach
@endif