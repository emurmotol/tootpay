<div class="row">
    {!! Form::open(['route' => 'settings.update_toot_card', 'class' => '']) !!}
    {{ Form::hidden('_method', 'PUT') }}

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('toot_card_price') ? ' has-error' : '' }}">
            <label for="toot_card_price">Toot Card Price:</label>

            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input id="toot_card_price" type="text" class="form-control" name="toot_card_price"
                       value="{{ \App\Models\Setting::value('toot_card_price') }}" placeholder="Toot card price">
            </div>

            @if ($errors->has('toot_card_price'))
                <span class="help-block">
                    <strong>{{ $errors->first('toot_card_price') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('toot_card_default_load') ? ' has-error' : '' }}">
            <label for="toot_card_default_load">Default Toot Load:</label>

            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input id="toot_card_default_load" type="text" class="form-control" name="toot_card_default_load"
                       value="{{ \App\Models\Setting::value('toot_card_default_load') }}"
                       placeholder="Default toot load">
            </div>

            @if ($errors->has('toot_card_default_load'))
                <span class="help-block">
                    <strong>{{ $errors->first('toot_card_default_load') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('toot_card_max_load_limit') ? ' has-error' : '' }}">
            <label for="toot_card_max_load_limit">Max Load Limit:</label>

            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input id="toot_card_max_load_limit" type="text" class="form-control" name="toot_card_max_load_limit"
                       value="{{ \App\Models\Setting::value('toot_card_max_load_limit') }}"
                       placeholder="Max load limit">
            </div>

            @if ($errors->has('toot_card_max_load_limit'))
                <span class="help-block">
                    <strong>{{ $errors->first('toot_card_max_load_limit') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('toot_card_min_load_limit') ? ' has-error' : '' }}">
            <label for="toot_card_min_load_limit">Min Load Limit:</label>

            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input id="toot_card_min_load_limit" type="text" class="form-control" name="toot_card_min_load_limit"
                       value="{{ \App\Models\Setting::value('toot_card_min_load_limit') }}"
                       placeholder="Min load limit">
            </div>

            @if ($errors->has('toot_card_min_load_limit'))
                <span class="help-block">
                    <strong>{{ $errors->first('toot_card_min_load_limit') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('per_point') ? ' has-error' : '' }}">
            <label for="per_point">Per Toot Points:</label>

            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input id="per_point" type="text" class="form-control" name="per_point"
                       value="{{ \App\Models\Setting::value('per_point') }}" placeholder="Per toot points">
            </div>

            @if ($errors->has('per_point'))
                <span class="help-block">
                    <strong>{{ $errors->first('per_point') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('toot_card_expire_year_count') ? ' has-error' : '' }}">
            <label for="toot_card_expire_year_count">Expire Year Count:</label>

            <div class="input-group">
                <input id="toot_card_expire_year_count" type="number" class="form-control" name="toot_card_expire_year_count"
                       value="{{ \App\Models\Setting::value('toot_card_expire_year_count') }}"
                       placeholder="Expire year count">
                <span class="input-group-addon">Years</span>
            </div>

            @if ($errors->has('toot_card_expire_year_count'))
                <span class="help-block">
                    <strong>{{ $errors->first('toot_card_expire_year_count') }}</strong>
                </span>
            @endif
        </div>

        <button type="submit" id="btn-submit" class="btn btn-primary" data-loading-text="{{ trans('loading.default') }}">Save</button>
    </div>
    {!! Form::close() !!}
</div>