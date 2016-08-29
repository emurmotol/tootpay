<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">
        <i class="fa fa-times fa-2x" aria-hidden="true"></i>
    </button>
    <div class="modal-title huge text-center">{{ trans('user.orders', ['user_id' => $user->id]) }}</div>
</div>
<div class="modal-body">
    <ul class="nav nav-tabs">
        @if($queued->count())
            <li {{ $queued->count() ? 'class=active' : '' }}>
                <a data-toggle="tab" href="#queued">Queued</a>
            </li>
        @endif

        @if($on_hold->count())
            <li {{ ($on_hold->count() && !$queued->count()) ? 'class=active' : '' }}>
                <a data-toggle="tab" href="#on_hold">On-Hold</a>
            </li>
        @endif

        @if($pending->count())
            <li {{ ($pending->count() && !$queued->count() && !$on_hold->count()) ? 'class=active' : '' }}>
                <a data-toggle="tab" href="#pending">Pending</a>
            </li>
        @endif
    </ul>

    <div class="tab-content">
        @if($queued->count())
            <div id="queued" class="tab-pane fade in {{ $queued->count() ? 'active' : '' }}">
                <div class="user-orders">
                    @foreach($queued->get() as $transaction)
                        TRANSACTION_ID: {{ $transaction->id }},
                        QUEUE_NUMBER: {{ \App\Models\Transaction::find($transaction->id)->queue_number }}
                        @foreach(\App\Models\Order::byTransaction($transaction->id) as $order)
                            MERCHANDISE: {{ \App\Models\Merchandise::find($order->merchandise_id)->name }}<br>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endif

        @if($on_hold->count())
            <div id="on_hold" class="tab-pane fade in {{ ($on_hold->count() && !$queued->count()) ? 'active' : '' }}">
                <div class="user-orders">
                    @foreach($on_hold->get() as $transaction)
                        TRANSACTION_ID: {{ $transaction->id }},
                        @foreach(\App\Models\Order::byTransaction($transaction->id) as $order)
                            MERCHANDISE: {{ \App\Models\Merchandise::find($order->merchandise_id)->name }}<br>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endif

        @if($pending->count())
            <div id="pending"
                 class="tab-pane fade in {{ ($pending->count() && !$queued->count() && !$on_hold->count()) ? 'active' : '' }}">
                <div class="user-orders">
                    @foreach($pending->get() as $transaction)
                        TRANSACTION_ID: {{ $transaction->id }},
                        @foreach(\App\Models\Order::byTransaction($transaction->id) as $order)
                            MERCHANDISE: {{ \App\Models\Merchandise::find($order->merchandise_id)->name }}<br>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

// todo rename get orders