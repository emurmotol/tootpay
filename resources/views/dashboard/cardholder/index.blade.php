@extends('layouts.app')

@section('title', Auth::user()->name . ' (Cardholder)')

@section('content')
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Cardholder Dashboard</div>

            <div class="panel-body">
                {{ trans('auth.logged_in') }}
            </div>
        </div>
    </div>
@endsection