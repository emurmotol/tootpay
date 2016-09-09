@extends('layouts.app')

@section('title', 'Not Associated Toot Cards')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.admin.toot_cards._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <span class="pull-left">@yield('title')</span>
                        <span class="pull-right">Results: {{ $toot_cards->total() }}</span>
                    </div>
                    @if($toot_cards->total())
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