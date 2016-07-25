@extends('layouts.app')

@section('title', 'Merchandise Categories')

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
                    </div>
                    @if(\App\Models\MerchandiseCategory::count())
                        <div class="panel-body">
                            @include('_partials.search')
                            @if(\App\Models\MerchandiseCategory::count())
                                @include('dashboard.admin.merchandise.category._partials.sort')
                            @endif
                            <span class="pull-right">
                                @include('_partials.create', ['url' => route('merchandises.create'), 'what' => 'merchandise'])
                                @include('_partials.create', ['url' => route('merchandise.categories.create'), 'what' => 'category'])
                            </span>
                        </div>
                        @include('dashboard.admin.merchandise.category._partials.table')
                    @else
                        @include('_partials.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection