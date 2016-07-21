@extends('layouts.app')

@section('title', 'Unavailable Merchandise')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.common.merchandise._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">@yield('title')</div>
                    @if(count(\App\Models\Merchandise::unavailable()))
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