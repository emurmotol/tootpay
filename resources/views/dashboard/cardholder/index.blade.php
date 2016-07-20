@extends('layouts.app')

@section('title', 'Cardholder Dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Cardholder Dashboard</div>

                    <div class="panel-body">
                        {{ trans('auth.logged_in') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection