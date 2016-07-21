@extends('layouts.app')

@section('title', 'Available Merchandise')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.common.merchandise._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @yield('title')
                        <span class="pull-right">
                            @include('dashboard.common.merchandise._partials.create')
                        </span>
                    </div>
                    @if(count(\App\Models\Merchandise::available()))
                        <div class="panel-body">
                            @include('_tootpay.flash')
                            @include('_tootpay.search')
                        </div>
                        @include('dashboard.common.merchandise._partials.table')
                    @else
                        @include('_tootpay.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection