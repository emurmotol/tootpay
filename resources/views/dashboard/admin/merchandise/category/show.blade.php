@extends('layouts.app')

@section('title', $merchandise_category->name . ' - ' . \App\Models\Merchandise::byCategory($merchandise_category->id)->get()->count() . ' entries')

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
                        @if(\App\Models\Merchandise::byCategory($merchandise_category->id)->get()->count())
                            @include('dashboard.admin.merchandise._partials.btn.sort')
                        @endif
                        <span class="pull-right">
                            @include('dashboard.admin.merchandise._partials.btn.create')
                            @include('dashboard.admin.merchandise.category._partials.btn.create')
                        </span>
                    </div>
                    @if(\App\Models\Merchandise::byCategory($merchandise_category->id)->get()->count())
                        @include('dashboard.admin.merchandise._partials.table')
                    @else
                        @include('_partials.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection