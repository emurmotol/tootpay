@extends('layouts.app')

@section('title', 'Administrator Dashboard')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Administrator Dashboard</div>

            <div class="panel-body">
                {{ trans('auth.logged_in') }}
            </div>
        </div>
    </div>
@endsection