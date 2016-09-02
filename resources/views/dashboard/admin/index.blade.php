@extends('layouts.app')

@section('title', Auth::user()->name . ' (Administrator)')

@section('content')
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Administrator Dashboard</div>
            <div class="panel-body">
                {{ trans('auth.logged_in') }}
            </div>
        </div>
    </div>
@endsection