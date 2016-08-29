<div class="panel panel-primary order">
    <div class="panel-heading clearfix">
        <span class="pull-left">Orders</span>
        <span class="pull-right">
            <i class="fa fa-question-circle" aria-hidden="true" id="edit_orders_help"></i>
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
            <div class="order-actions">
                <ul class="list-inline">
                    <li>
                        <button class="btn btn-warning btn-lg" id="btn_cancel"
                                data-loading-text="<i class='fa fa-spinner fa-pulse'></i> Canceling order...">
                            <strong>Cancel Order</strong>
                        </button>
                    </li>
                    <li>
                        <button class="btn btn-info btn-lg" id="btn_hold" disabled>
                            <strong>Hold Order</strong>
                        </button>
                    </li>
                </ul>
                <ul class="list-inline">
                    <li>
                        <strong>Pay using:</strong>
                    </li>
                    <li>
                        <button class="btn btn-primary btn-lg" id="btn_pay_using_toot_card" disabled>
                            <strong>Toot Card</strong>
                        </button>
                    </li>
                    <li>
                        <button class="btn btn-success btn-lg" id="btn_pay_using_cash" disabled>
                            <strong>Cash</strong>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>