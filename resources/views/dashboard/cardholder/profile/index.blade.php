@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.cardholder._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <span class="pull-left">@yield('title')</span>
                        <span class="pull-right">
                            <a href="{{ route('users.profile_edit', $user->id) }}" class="btn btn-default btn-xs">Edit</a>
                        </span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="img-user">
                                    <a href="{{ $user->gravatar }}">
                                        <img src="{{ $user->gravatar }}" class="img-responsive img-rounded" alt="{{ $user->name }}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <ul class="list-unstyled">
                                    <li><h4>User ID: <strong>{{ $user->id }}</strong></h4></li>
                                    <li><h4>Name: <strong>{{ $user->name }}</strong></h4></li>
                                    <li><h4>E-Mail Address: <strong>{{ $user->email }}</strong></h4></li>
                                    <li><h4>Phone Number: <strong>{{ $user->phone_number }}</strong></h4></li>
                                    <li><h4>Created: <strong data-livestamp="{{ strtotime($user->created_at) }}"></strong></h4></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection