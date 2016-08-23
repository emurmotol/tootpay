@extends('layouts.app')

@section('title', 'Sales Report')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.admin.reports._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        @yield('title')
                        <span class="pull-right">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <strong>{{ \Carbon\Carbon::now()->toDayDateTimeString() }}</strong>
                        </span>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                            @foreach(\App\Models\OperationDay::purchaseDates() as $create)
                                @if (date('W', strtotime($create->date)) == date('W', strtotime(\Carbon\Carbon::now())))
                                    <li {{ (date('w', strtotime($create->date)) == date('w', strtotime(\Carbon\Carbon::now()))) ? 'class=active' : '' }}>
                                        <a data-toggle="tab"
                                           href="#{{ strtolower(date('l', strtotime($create->date))) }}">{{ date('l', strtotime($create->date)) }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @foreach(\App\Models\OperationDay::purchaseDates() as $create)
                                @if (date('W', strtotime($create->date)) == date('W', strtotime(\Carbon\Carbon::now())))
                                    <div id="{{ strtolower(date('l', strtotime($create->date))) }}"
                                         class="tab-pane fade in {{ date('w', strtotime($create->date)) == date('w', strtotime(\Carbon\Carbon::now())) ? 'active' : '' }}">
                                        <h4>
                                            <strong>{{ (date('w', strtotime($create->date)) == date('w', strtotime(\Carbon\Carbon::now()))) ? 'Today\'s Sales' : date('l', strtotime($create->date)) . ' Sales' }}</strong>
                                        </h4>

                                        @foreach(\App\Models\Merchandise::byPurchaseDate($create->date) as $merchandise)
                                            {{ \App\Models\Merchandise::find($merchandise->id)->name }} {{ $merchandise->merchandise_quantity }} {{ $merchandise->merchandise_sales }}<br>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection