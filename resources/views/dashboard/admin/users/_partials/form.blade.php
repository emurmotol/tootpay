<div class="row">
    @if(request()->has('redirect'))
        {!! Form::open([
            'route' => (Route::is('users.edit')) ? ['users.update', $user->id, 'redirect' => request()->get('redirect')] : ['users.store', 'redirect' => request()->get('redirect')],
            'class' => ''
        ]) !!}
    @else
        {!! Form::open([
            'route' => (Route::is('users.edit')) ? ['users.update', $user->id] : 'users.store',
            'class' => ''
        ]) !!}
    @endif

    @if(Route::is('users.edit'))
        {{ Form::hidden('_method', 'PUT') }}
    @endif

    <div class="col-md-6">
        @if(Route::is('users.create'))
            <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                <label for="role">Role:</label>
                <select id="role" name="role" class="form-control">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ (old('role') == $role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>

                @if ($errors->has('role'))
                    <span class="help-block">
                    <strong>{{ $errors->first('role') }}</strong>
                </span>
                @endif
            </div>
        @endif

        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
            <label for="id">User ID:</label>
            <input type="number" class="form-control" id="id" name="id"
                   value="{{ (Route::is('users.edit')) ? $user->id : old('id') }}">

            @if ($errors->has('id'))
                <span class="help-block">
                    <strong>{{ $errors->first('id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ (Route::is('users.edit')) ? $user->name : old('name') }}">

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">E-Mail Address:</label>
            <input type="text" class="form-control" id="email" name="email"
                   value="{{ (Route::is('users.edit')) ? $user->email : old('email') }}">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
            <label for="phone_number">Phone Number:</label>
            <input type="number" class="form-control" id="phone_number" name="phone_number"
                   value="{{ (Route::is('users.edit')) ? $user->phone_number : old('phone_number') }}">

            @if ($errors->has('phone_number'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
            @endif
        </div>

        <button type="submit" id="btn-submit" class="btn btn-primary"
                data-loading-text="<i class='fa fa-spinner fa-pulse'></i> Loading...">
            {{ (Route::is('users.edit')) ? 'Update' : 'Create' }} user
        </button>
    </div>
    {!! Form::close() !!}
</div>