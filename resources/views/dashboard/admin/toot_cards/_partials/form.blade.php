<div class="row">
    @if(request()->has('redirect'))
        {!! Form::open([
            'route' => (Route::is('toot_cards.edit')) ? ['toot_cards.update', $toot_card->id, 'redirect' => request()->get('redirect')] : ['toot_cards.store', 'redirect' => request()->get('redirect')],
            'files' => true,
            'class' => ''
            // todo will fail on update
        ]) !!}
    @else
        {!! Form::open([
            'route' => (Route::is('toot_cards.edit')) ? ['toot_cards.update', $toot_card->id] : 'toot_cards.store',
            'files' => true,
            'class' => ''
            // todo will fail on update
        ]) !!}
    @endif

    @if(Route::is('toot_cards.edit'))
        {{ Form::hidden('_method', 'PUT') }}
    @endif

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
            <label for="id">Toot Card ID:</label>
            <input type="number" class="form-control" id="id" name="id"
                   value="{{ (Route::is('toot_cards.edit')) ? $toot_card->id : old('id') }}">

            @if ($errors->has('id'))
                <span class="help-block">
                    <strong>{{ $errors->first('id') }}</strong>
                </span>
            @endif
        </div>

        <button type="submit" id="btn-submit" class="btn btn-primary"
                data-loading-text="<i class='fa fa-spinner fa-pulse'></i> Loading...">
            {{ (Route::is('toot_cards.edit')) ? 'Update' : 'Create' }} toot card
        </button>
    </div>
    {!! Form::close() !!}
</div>