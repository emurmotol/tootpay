@extends('layouts.app')

@section('title', 'Create Expense')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <span class="pull-left">@yield('title')</span>
                        <span class="pull-right"></span>
                    </div>
                    <div class="panel-body">
                        @include('dashboard.admin.expenses._partials.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('_partials.spinner')