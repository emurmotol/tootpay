@extends('layouts.app')

@section('title', 'All Toot Cards')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.admin.toot_cards._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @yield('title')
                        <span class="pull-right">
                            <strong>Results: {{ $toot_cards->total() }}</strong>
                        </span>
                    </div>
                    @if(\App\Models\TootCard::count())
                        <div class="panel-body">
                            <ul class="list-inline panel-actions">
                                <li>
                                    @include('_partials.search', ['what' => 'toot card'])
                                </li>
                                <li>
                                    @include('_partials.sort', ['sort_by' => trans('sort.toot_cards')])
                                </li>
                                <li>
                                    @include('_partials.create', ['url' => route('toot_cards.create'), 'what' => 'toot card'])
                                </li>
                            </ul>
                        </div>
                        @include('dashboard.admin.toot_cards._partials.table')
                    @else
                        @include('_partials.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection