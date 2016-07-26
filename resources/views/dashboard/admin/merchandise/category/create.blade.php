@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.admin.merchandise._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @yield('title')
                        <span class="pull-right">
                            @include('_partials.cancel', ['url' => route('merchandise.categories.index')])
                        </span>
                    </div>
                    <div class="panel-body">
                        @include('dashboard.admin.merchandise.category._partials.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('_partials.spinner')