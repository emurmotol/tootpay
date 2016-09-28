<div class="row">
    {!! Form::open(['route' => ['users.toot_card_update_pin_code', $user->id], 'class' => '']) !!}
    {{ Form::hidden('_method', 'PUT') }}

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('pin_code') ? ' has-error' : '' }}">
            <label for="pin_code">Pin Code:</label>

            <div class="input-group">
                <input type="password" class="form-control" id="password" name="pin_code" value="{{ $user->tootCards()->first()->pin_code }}">
                <span class="input-group-addon"><i class="fa fa-eye" aria-hidden="true"></i></span>
            </div>

            @if ($errors->has('pin_code'))
                <span class="help-block">
                    <strong>{{ $errors->first('pin_code') }}</strong>
                </span>
            @endif
        </div>

        <button type="submit" id="btn-submit" class="btn btn-primary" data-loading-text="{{ trans('loading.default') }}">Update pin code</button>
        @include('_partials.cancel', ['url' => route('users.toot_card', $user->id)])
    </div>
    {!! Form::close() !!}
</div>

@include('_partials.password')
@include('_partials.spinner')