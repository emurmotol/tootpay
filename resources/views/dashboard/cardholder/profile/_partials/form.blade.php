<div class="row">
    {!! Form::open(['route' => ['users.profile_update', $user->id], 'class' => '']) !!}
    {{ Form::hidden('_method', 'PUT') }}

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
            <label for="id">User ID:</label>
            <input type="number" class="form-control" id="id" name="id" value="{{ $user->id }}">

            @if ($errors->has('id'))
                <span class="help-block">
                    <strong>{{ $errors->first('id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">E-Mail Address:</label>
            <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
            <label for="phone_number">Phone Number:</label>
            <input type="number" class="form-control" id="phone_number" name="phone_number" value="{{ $user->phone_number }}">

            @if ($errors->has('phone_number'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
            @endif
        </div>

        <button type="submit" id="btn-submit" class="btn btn-primary" data-loading-text="{{ trans('loading.default') }}">Update profile</button>
    </div>
    {!! Form::close() !!}
</div>