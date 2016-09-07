<div class="row">
    {!! Form::open(['route' => ['users.profile_update_password', $user->id], 'class' => '']) !!}
    {{ Form::hidden('_method', 'PUT') }}

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password">New Password:</label>

            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="New password">
                <span class="input-group-addon"><i class="fa fa-eye" aria-hidden="true"></i></span>
            </div>

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <button type="submit" id="btn-submit" class="btn btn-primary" data-loading-text="{{ trans('loading.default') }}">Reset password</button>
    </div>
    {!! Form::close() !!}
</div>

@include('_partials.password')