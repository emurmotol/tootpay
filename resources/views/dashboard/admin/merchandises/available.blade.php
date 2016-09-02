@extends('layouts.app')

@section('title', 'Available Today')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.admin.merchandises._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <span class="pull-left">@yield('title')</span>
                        <span class="pull-right">Results: {{ $merchandises->total() }}</span>
                    </div>
                    @if($merchandises->total())
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
                        @include('dashboard.admin.merchandises._partials.table')
                    @else
                        @include('_partials.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection