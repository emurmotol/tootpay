@extends('layouts.app')

@section('title', 'Unavailable Merchandise')

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
                        @include('dashboard.admin.merchandise._partials.btn.sort')
                        <span class="pull-right">
                            @include('dashboard.admin.merchandise._partials.btn.create')
                            @include('dashboard.admin.merchandise.category._partials.btn.create')
                        </span>
                    </div>
                    @if(\App\Models\Merchandise::unavailable()->get()->count())
                        @include('dashboard.admin.merchandise._partials.table')
                    @else
                        @include('_partials.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection