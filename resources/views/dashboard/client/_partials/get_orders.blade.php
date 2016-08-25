@if(count($queued_orders))
    {{ config('static.status')[9] }}:
    @foreach(\App\Models\Merchandise::orderIdOnly($queued_orders) as $order_id)
        ORDER_ID: {{ $order_id }}
        @foreach($queued_orders as $order)
            @if($order->order_id == $order_id)
                MERCHANDISE_ID: {{ $order->merchandise_id }}, ORDER_ID: {{ $order->order_id }}
            @endif
        @endforeach
    @endforeach
@endif

@if(count($on_hold_orders))
    {{ config('static.status')[11] }}:
    @foreach(\App\Models\Merchandise::orderIdOnly($on_hold_orders) as $order_id)
        ORDER_ID: {{ $order_id }}
        @foreach($on_hold_orders as $order)
            @if($order->order_id == $order_id)
                MERCHANDISE_ID: {{ $order->merchandise_id }}, ORDER_ID: {{ $order->order_id }}
            @endif
        @endforeach
    @endforeach
@endif

@if(count($pending_orders))
    {{ config('static.status')[4] }}:
    @foreach(\App\Models\Merchandise::orderIdOnly($pending_orders) as $order_id)
        ORDER_ID: {{ $order_id }}
        @foreach($pending_orders as $order)
            @if($order->order_id == $order_id)
                MERCHANDISE_ID: {{ $order->merchandise_id }}, ORDER_ID: {{ $order->order_id }}
            @endif
        @endforeach
    @endforeach
@endif