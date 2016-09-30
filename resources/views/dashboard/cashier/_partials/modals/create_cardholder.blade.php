<div id="create_cardholder" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal">
                <div class="modal-header">
                    <div class="modal-title huge text-center"><strong>Create Cardholder</strong></div>
                </div>
                <div class="modal-body">
                    <div class="form-group form-group-lg">
                        <label for="name" class="col-md-4 control-label">Name:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label for="email" class="col-md-4 control-label">Email Address:</label>

                        <div class="col-md-8">
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label for="phone_number" class="col-md-4 control-label">Phone Number:</label>

                        <div class="col-md-8">
                            <input type="number" class="form-control" id="phone_number" name="phone_number">
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label for="user_id" class="col-md-4 control-label">User ID:</label>

                        <div class="col-md-8">
                            <input type="number" class="form-control" id="user_id" name="user_id">
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label for="toot_card_uid" class="col-md-4 control-label">Toot Card UID:</label>

                        <div class="col-md-8">
                            @if(\App\Models\TootCard::available()->count())
                                <select id="toot_card_uid" name="toot_card_uid" class="form-control">
                                    @foreach(\App\Models\TootCard::available() as $toot_card)
                                        <option value="{{ $toot_card->uid }}" {{ (old('toot_card_id') == $toot_card->id) ? 'selected' : '' }}>{{ $toot_card->uid }}</option>
                                    @endforeach
                                </select>
                            @else
                                <p class="form-control-static text-muted">{{ trans('toot_card.no_available') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="pull-left">
                        <button type="button" class="btn btn-warning huge" data-dismiss="modal">Cancel</button>
                    </span>
                    <span class="pull-right">
                        <button type="button" class="btn btn-primary huge" id="create_card_holder">Create</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>