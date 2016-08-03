<div class="panel panel-primary order">
    <div class="panel-heading clearfix">
        <div class="pull-left">
            <strong>{{ $customer_name }}</strong>
        </div>
        <div class="pull-right">
            Order: <strong>#{{ $order_id }}</strong>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table" id="table_orders">
            <thead>
            <tr>
                <th>Name</th>
                <th class="text-center">Qty</th>
                <th>Each</th>
                <th>Total</th>
                <th class="text-center"><i class="fa fa-trash"></i></th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="panel-body clearfix">
        <div class="pull-right">
            @if(Auth::check())
                <div class="row">
                    <div class="col-md-6">Sub Total:</div>
                    <div class="col-md-6 text-right huge-total">P<span id="sub_total">0.00</span></div>
                </div>
                <div class="row">
                    <div class="col-md-6">Discounts:</div>
                    <div class="col-md-6 text-right huge-total">P<span id="discount">0.00</span></div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">TOTAL:</div>
                <div class="col-md-6 text-right huge-total">
                    <strong>P<span id="grand_total">0.00</span></strong>
                </div>
            </div>
            <ul class="list-inline order-actions">
                <li>
                    <button class="btn btn-warning btn-lg" id="btn_cancel"  data-loading-text="<i class='fa fa-spinner fa-pulse'></i> Canceling...">Cancel Order</button>
                </li>
                @if(Auth::check())
                    <li>
                        <button class="btn btn-success btn-lg" id="btn_discount" disabled>Discount Order</button>
                    </li>
                @endif
                <li>
                    <button class="btn btn-primary btn-lg" id="btn_pay" disabled>
                        <strong>Pay</strong>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</div>