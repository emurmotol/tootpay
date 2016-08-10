<div id="tap_card" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times fa-2x" aria-hidden="true"></i>
                </button>
                <h4 class="modal-title huge text-center">
                    <strong>Please tap your toot card!</strong>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="#enter_pin_code" data-toggle="modal">
                            <img src="{{ asset('img/rfid-symbol-animated.gif') }}" class="img-responsive rfid-symbol-animated" alt="">
                        </a>
                    </div>
                </div>
                <input type="number" class="input-unstyled"
                       id="toot_card_id" pattern="[0-9]{10}" maxlength="10" autofocus>
            </div>
        </div>
    </div>
</div>