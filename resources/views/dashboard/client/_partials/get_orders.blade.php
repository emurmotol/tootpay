<div class="modal-header">
    <h4 class="modal-title huge text-center">
        <strong><i class="fa fa-user"></i> {{ $user->id }}</strong>
    </h4>
</div>
<div class="modal-body">
    <ul class="nav nav-tabs">
        @if(count($queued))
            <li {{ count($queued) ? 'class=active' : '' }}>
                <a data-toggle="tab" href="#queued">Queued</a>
            </li>
        @endif

        @if(count($on_hold))
            <li {{ (count($on_hold) && count($queued) == 0) ? 'class=active' : '' }}>
                <a data-toggle="tab" href="#on_hold">On-Hold</a>
            </li>
        @endif

        @if(count($pending))
            <li {{ (count($pending) && count($queued) == 0 && count($on_hold) == 0) ? 'class=active' : '' }}>
                <a data-toggle="tab" href="#pending">Pending</a>
            </li>
        @endif
    </ul>

    <div class="tab-content">
        @if(count($queued))
            <div id="queued" class="tab-pane fade in {{ count($queued) ? 'active' : '' }}">
                <div class="user-orders">
                    <strong>Queued Orders</strong>
                </div>
                {{--@foreach(\App\Models\Merchandise::groupOrderIds($queued) as $order_id)--}}
                    {{--ORDER_ID: {{ $order_id }},--}}
                    {{--QUEUE_NUMBER: {{ \App\Models\Merchandise::orders($order_id)->first()->queue_number }}--}}
                    {{--@foreach(\App\Models\Merchandise::orders($order_id)->get() as $order)--}}
                        {{--MERCHANDISE_ID: {{ $order->merchandise_id }}, ORDER_ID: {{ $order->order_id }}--}}
                    {{--@endforeach--}}
                {{--@endforeach--}}
            </div>
        @endif

        @if(count($on_hold))
            <div id="on_hold" class="tab-pane fade in {{ (count($on_hold) && count($queued) == 0) ? 'active' : '' }}">
                <div class="user-orders">
                    <strong>On-Hold Orders</strong>
                </div>
                {{--@foreach(\App\Models\Merchandise::groupOrderIds($on_hold) as $order_id)--}}
                    {{--ORDER_ID: {{ $order_id }}--}}
                    {{--@foreach(\App\Models\Merchandise::orders($order_id)->get() as $order)--}}
                        {{--MERCHANDISE_ID: {{ $order->merchandise_id }}, ORDER_ID: {{ $order->order_id }}--}}
                    {{--@endforeach--}}
                {{--@endforeach--}}
            </div>
        @endif

        @if(count($pending))
            <div id="pending" class="tab-pane fade in {{ (count($pending) && count($queued) == 0 && count($on_hold) == 0) ? 'active' : '' }}">
                <div class="user-orders">
                    <strong>Pending Orders</strong>
                </div>
                {{--@foreach(\App\Models\Merchandise::groupOrderIds($pending) as $order_id)--}}
                    {{--ORDER_ID: {{ $order_id }}--}}
                    {{--@foreach(\App\Models\Merchandise::orders($order_id)->get() as $order)--}}
                        {{--MERCHANDISE_ID: {{ $order->merchandise_id }}, ORDER_ID: {{ $order->order_id }}--}}
                    {{--@endforeach--}}
                {{--@endforeach--}}
            </div>
        @endif
    </div>
</div>