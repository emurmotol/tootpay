<div class="panel panel-primary order">
    <div class="panel-heading clearfix">
        <span class="pull-left">
            Queue: <strong>#<span id="queue_number">{{ \App\Models\Merchandise::queueNumber() }}</span></strong>
        </span>
        <span class="pull-right">
            Order: <strong>#<span id="order_id">{{ \App\Models\Merchandise::orderId() }}</span></strong>
        </span>
    </div>
    <table class="table table-responsive table-striped" id="table_orders">
        <thead>
        <tr>
            <th>Name</th>
            <th class="text-center">Qty</th>
            <th>Each</th>
            <th>Total</th>
            <th class="text-center"><i class="fa fa-trash"></i></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div class="panel-body clearfix">
        <div class="pull-right">
            <div class="text-right">
                <div class="grand_total text-right">
                    <strong>P<span id="grand_total">0.00</span></strong>
                </div>
            </div>
            <ul class="list-inline order-actions">
                <li>
                    <button class="btn btn-warning btn-lg" id="btn_cancel"
                            data-loading-text="<i class='fa fa-spinner fa-pulse'></i> Please wait...">Cancel Order
                    </button>
                </li>
                <li>
                    <strong>Pay using:</strong>
                    <button class="btn btn-primary btn-lg" id="btn_pay_using_toot_card" disabled>
                        <strong>Toot Card</strong>
                    </button>
                    <button class="btn btn-success btn-lg" id="btn_pay_using_cash" disabled>
                        <strong>Cash</strong>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</div>