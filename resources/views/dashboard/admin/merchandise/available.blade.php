@extends('layouts.app')

@section('title', 'Available Merchandise')

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
                        <span class="pull-right">Results: {{ $merchandises->total() }}</span>
                    </div>
                    @if(\App\Models\Merchandise::available()->get()->count())
                        <div class="panel-body">
                            <ul class="list-inline panel-actions">
                                <li>
                                    @include('_partials.search', ['what' => 'available'])
                                </li>
                                <li>
                                    @include('_partials.sort', ['sort_by' => trans('sort.merchandises')])
                                </li>
                                <li>
                                    @include('_partials.create', ['url' => route('merchandises.create'), 'what' => 'merchandise'])
                                </li>
                                <li>
                                    @include('_partials.create', ['url' => route('merchandise.categories.create'), 'what' => 'category'])
                                </li>
                            </ul>
                        </div>
                        @include('dashboard.admin.merchandise._partials.table')
                    @else
                        @include('_partials.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection