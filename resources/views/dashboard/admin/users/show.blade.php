@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.admin.users._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <i class="fa fa-user" aria-hidden="true"></i> @yield('title')
                        <span class="pull-right">
                            {!! Form::open([
                                'route' => ['users.destroy', $user->id,
                                'redirect=' . request()->get('redirect')],
                                'class' => '']) !!}
                            {!! Form::hidden('_method', 'DELETE') !!}
                            <a href="{{ route('users.edit', [$user->id, 'redirect' => Request::fullUrl()]) }}"
                               class="btn btn-default btn-xs">Edit</a>
                                <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                            {!! Form::close() !!}
                        </span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-unstyled">
                                    <li>
                                        <h4>Name: <strong>{{ $user->name }}</strong></h4>
                                        <h4>Role: <strong>{{ $user->roles()->first()->name }}</strong></h4>
                                        @if($user->hasRole(cardholder()))
                                            <h4>
                                                Toot Card ID:
                                                @if(is_null($user->tootCards()->first()))
                                                    <strong>Not set</strong>
                                                @else
                                                    <a href="{{ route('toot_cards.show', $user->tootCards()->first()->id) }}">
                                                        <strong>{{ $user->tootCards()->first()->id }}</strong>
                                                    </a>
                                                @endif
                                            </h4>
                                        @endif
                                        <h4>User ID: <strong>{{ $user->id }}</strong></h4>
                                        <h4>E-Mail Address: <strong>{{ $user->email }}</strong></h4>
                                        <h4>Phone Number: <strong>{{ $user->phone_number }}</strong></h4>
                                        <h4>Created: <strong>{{ $user->created_at->toFormattedDateString() }}</strong></h4>
                                        <h4>Updated: <strong>{{ $user->updated_at->diffForHumans() }}</strong></h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @unless(is_null($user->tootCards()->first()))
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Payment History
                        </div>
                        {{--<div class="panel-body">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-md-12">--}}
                                    {{----}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        @include('_partials.empty')
                    </div>
                @endunless
            </div>
        </div>
    </div>
@endsection