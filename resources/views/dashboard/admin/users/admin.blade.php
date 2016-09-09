@extends('layouts.app')

@section('title', 'Administrators')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.admin.users._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <span class="pull-left">@yield('title')</span>
                        <span class="pull-right">Results: {{ $users->total() }}</span>
                    </div>
                    @if($users->total())
                        <div class="panel-body">
                            <ul class="list-inline panel-actions">
                                <li>
                                    @include('_partials.search', ['what' => 'user'])
                                </li>
                                <li>
                                    @include('_partials.sort', ['sort_by' => trans('sort.users')])
                                </li>
                                <li>
                                    @include('_partials.create', ['url' => route('users.create'), 'what' => 'user'])
                                </li>
                            </ul>
                        </div>
                        @include('dashboard.admin.users._partials.table')
                    @else
                        @include('_partials.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection