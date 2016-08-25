<div id="exceed_reload_limit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title huge text-danger text-center">
                    <strong><i class="fa fa-times"></i> Whoops! The amount you entered exceeds the reload limit. Maximum reload is P{{ number_format(\App\Models\Setting::value('reload_limit'), 2, '.', ',') }}</strong>
                </h4>
            </div>
        </div>
    </div>
</div>