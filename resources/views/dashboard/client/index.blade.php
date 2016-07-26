@extends('layouts.app')

@section('title', 'Client Dashboard')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Client Dashboard</div>

            <div class="panel-body">
                {{ trans('auth.logged_in') }}
            </div>
        </div>
    </div>
@endsection