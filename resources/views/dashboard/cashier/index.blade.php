@extends('layouts.app')

@section('title', Auth::user()->name . ' (Cashier)')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Cashier Dashboard</div>

            <div class="panel-body">
                {{ trans('auth.logged_in') }}
            </div>
        </div>
    </div>
@endsection