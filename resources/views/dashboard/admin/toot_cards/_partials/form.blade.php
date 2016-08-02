<div class="row">
    @if(request()->has('redirect'))
        {!! Form::open([
            'route' => (Route::is('toot_cards.edit')) ? ['toot_cards.update', $toot_card->id, 'redirect' => request()->get('redirect')] : ['toot_cards.store', 'redirect' => request()->get('redirect')],
            'class' => ''
        ]) !!}
    @else
        {!! Form::open([
            'route' => (Route::is('toot_cards.edit')) ? ['toot_cards.update', $toot_card->id] : 'toot_cards.store',
            'class' => ''
        ]) !!}
    @endif

    @if(Route::is('toot_cards.edit'))
        {{ Form::hidden('_method', 'PUT') }}
    @endif

    <div class="col-md-6">
        @if(Route::is('toot_cards.edit'))
            <div class="form-group">
                @if(is_null($toot_card->users()->first()))
                    <p class="help-block">{{ trans('toot_card.no_user') }}</p>
                @else
                    <label>This card is associated to:</label>
                    <p class="form-control-static">
                        <a href="{{ route('users.edit', $toot_card->users()->first()->id) }}">
                            <strong>{{ $toot_card->users()->first()->name }}</strong>
                        </a>
                    </p>
                @endif
            </div>
        @endif

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

        <div class="form-group{{ $errors->has('load') ? ' has-error' : '' }}">
            <label for="load">Load:</label>

            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="form-control" id="load" name="load"
                       value="{{ number_format((Route::is('toot_cards.edit')) ? $toot_card->load : old('load'), 2, '.', ',') }}"
                       pattern="^\d+\.\d{2}$" placeholder="">
            </div>

            @if ($errors->has('load'))
                <span class="help-block">
                    <strong>{{ $errors->first('load') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('points') ? ' has-error' : '' }}">
            <label for="points">Points:</label>

            <input type="text" class="form-control" id="points" name="points"
                   value="{{ number_format((Route::is('toot_cards.edit')) ? $toot_card->points : old('points'), 2, '.', ',') }}"
                   pattern="^\d+\.\d{2}$" placeholder="">

            @if ($errors->has('points'))
                <span class="help-block">
                    <strong>{{ $errors->first('points') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('pin_code') ? ' has-error' : '' }}">
            <label for="pin_code">Pin Code:</label>

            <div class="input-group">
                <input type="password" class="form-control" id="password" name="pin_code" value="{{ (Route::is('toot_cards.edit')) ? $toot_card->pin_code : old('pin_code') }}" placeholder="">
                <span class="input-group-addon"><i class="fa fa-eye" aria-hidden="true"></i></span>
            </div>

            @if ($errors->has('pin_code'))
                <span class="help-block">
                    <strong>{{ $errors->first('pin_code') }}</strong>
                </span>
            @endif
        </div>

        @if(Route::is('toot_cards.edit'))
            <div class="checkbox">
                <input type="hidden" value="off" name="is_active">
                <label for="is_active">
                    <input type="checkbox" value="on" name="is_active"
                           id="is_active" {{ $toot_card->is_active ? 'checked' : '' }}> Active
                </label>
            </div>
        @endif

        <button type="submit" id="btn-submit" class="btn btn-primary"
                data-loading-text="<i class='fa fa-spinner fa-pulse'></i> Loading...">
            {{ (Route::is('toot_cards.edit')) ? 'Update' : 'Create' }} toot card
        </button>
    </div>
    {!! Form::close() !!}
</div>

@include('_partials.password')