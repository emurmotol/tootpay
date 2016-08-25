<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">
        <i class="fa fa-times fa-2x" aria-hidden="true"></i>
    </button>
    <h4 class="modal-title huge text-center">
        <strong><i class="fa fa-user"></i> {{ $user->id }}: Orders</strong>
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
            <li {{ (count($on_hold) && !count($queued)) ? 'class=active' : '' }}>
                <a data-toggle="tab" href="#on_hold">On-Hold</a>
            </li>
        @endif

        @if(count($pending))
            <li {{ (count($pending) && !count($queued) && !count($on_hold)) ? 'class=active' : '' }}>
                <a data-toggle="tab" href="#pending">Pending</a>
            </li>
        @endif
    </ul>

    <div class="tab-content">
        @if(count($queued))
            <div id="queued" class="tab-pane fade in {{ count($queued) ? 'active' : '' }}">
                <div class="user-orders">
                    @foreach(\App\Models\Merchandise::groupOrderIds($queued) as $order_id)
                        ORDER_ID: {{ $order_id }},
                        QUEUE_NUMBER: {{ \App\Models\Merchandise::orders($order_id)->first()->queue_number }}
                        @foreach(\App\Models\Merchandise::orders($order_id)->get() as $order)
                            MERCHANDISE_ID: {{ $order->merchandise_id }}, ORDER_ID: {{ $order->order_id }}
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endif

        @if(count($on_hold))
            <div id="on_hold" class="tab-pane fade in {{ (count($on_hold) && !count($queued)) ? 'active' : '' }}">
                <div class="user-orders">
                    @foreach(\App\Models\Merchandise::groupOrderIds($on_hold) as $order_id)
                        ORDER_ID: {{ $order_id }}
                        @foreach(\App\Models\Merchandise::orders($order_id)->get() as $order)
                            MERCHANDISE_ID: {{ $order->merchandise_id }}, ORDER_ID: {{ $order->order_id }}
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endif

        @if(count($pending))
            <div id="pending"
                 class="tab-pane fade in {{ (count($pending) && !count($queued) && !count($on_hold)) ? 'active' : '' }}">
                <div class="user-orders">
                    @foreach(\App\Models\Merchandise::groupOrderIds($pending) as $order_id)
                        ORDER_ID: {{ $order_id }}
                        @foreach(\App\Models\Merchandise::orders($order_id)->get() as $order)
                            MERCHANDISE_ID: {{ $order->merchandise_id }}, ORDER_ID: {{ $order->order_id }}
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>