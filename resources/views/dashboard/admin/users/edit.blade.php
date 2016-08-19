@extends('layouts.app')

@section('title', 'Edit - ' . $user->name . ' (' . $user->roles()->first()->name .  ')')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.admin.users._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        @yield('title')
                        <span class="pull-right">
                            @include('_partials.cancel', ['url' => route('users.index')])
                        </span>
                    </div>
                    <div class="panel-body">
                        @include('dashboard.admin.users._partials.form')
                    </div>
                </div>
                @include('dashboard.admin.users._partials.form_toot_card')
            </div>
        </div>
    </div>
@endsection

@include('_partials.spinner')