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
                        <span class="pull-right">Results: {{ $merchandise_categories->total() }}</span>
                    </div>
                    @if(\App\Models\MerchandiseCategory::count())
                        <div class="panel-body">
                            <ul class="list-inline panel-actions">
                                <li>
                                    @include('_partials.search', ['what' => 'categories'])
                                </li>
                                <li>
                                    @include('_partials.sort', ['sort_by' => trans('sort.categories')])
                                </li>
                                <li>
                                    @include('_partials.create', ['url' => route('merchandises.create'), 'what' => 'merchandise'])
                                </li>
                                <li>
                                    @include('_partials.create', ['url' => route('merchandise.categories.create'), 'what' => 'category'])
                                </li>
                            </ul>
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