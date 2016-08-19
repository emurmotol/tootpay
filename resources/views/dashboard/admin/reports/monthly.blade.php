@extends('layouts.app')

@section('title', 'Monthly Sales Report')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.admin.reports._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        @yield('title')
                        <span class="pull-right">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <strong>{{ \Carbon\Carbon::now()->toDayDateTimeString() }}</strong>
                        </span>
                    </div>
                    <div class="panel-body">
                        <h1>todo</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection