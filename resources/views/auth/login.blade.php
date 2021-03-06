@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">@yield('title')</div>
                <div class="panel-body">
                    {!! Form::open(['url' => 'login', 'class' => 'form-horizontal']) !!}

                        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                            <label for="id" class="col-md-4 control-label">User ID:</label>

                            <div class="col-md-6">
                                <input id="id" type="number" class="form-control" name="id" value="{{ old('id') }}" placeholder="Your user id">

                                @if ($errors->has('id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password:</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control" name="password" placeholder="Your password">
                                    <span class="input-group-addon"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" name="remember" value="true">

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" id="btn-submit" class="btn btn-primary" data-loading-text="{{ trans('loading.default') }}">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
                                </button>
                                <a class="btn btn-link pull-right" href="{{ url('password/reset') }}">I forgot my password</a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('_partials.spinner')
@include('_partials.password')
