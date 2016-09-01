<div id="menu" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header huge">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times fa-2x" aria-hidden="true"></i>
                </button>
                <img src="{{ asset('img/logo.png') }}" class="img-responsive logo-modal" alt="Toot Card Logo">
            </div>
            <div class="modal-body menu">
                <div class="row">
                    <div class="col-md-3">
                        <img id="menu_order_food" src="{{ asset('img/menu/order-food.png') }}" class="img-responsive">
                        <div class="text-center text-primary"><strong>Order Food</strong></div>
                    </div>
                    <div class="col-md-3">
                        <img id="menu_reload_toot_card" src="{{ asset('img/menu/reload-toot-card.png') }}" class="img-responsive">
                        <div class="text-center text-primary"><strong>Reload Toot Card</strong></div>
                    </div>
                    <div class="col-md-3">
                        <img id="menu_share_a_load" src="{{ asset('img/menu/share-a-load.png') }}" class="img-responsive">
                        <div class="text-center text-primary"><strong>Share-a-Load</strong></div>
                    </div>
                    <div class="col-md-3">
                        <img id="menu_check_balance" src="{{ asset('img/menu/check-balance.png') }}" class="img-responsive">
                        <div class="text-center text-primary"><strong>Check Balance</strong></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer menu-footer">
                <div class="text-center text-muted">
                    <i class="fa fa-copyright" aria-hidden="true"></i> {{ date('Y') }} {{ config('static.app.company') }}
                </div>
            </div>
        </div>
    </div>
</div>