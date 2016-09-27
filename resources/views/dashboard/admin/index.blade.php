@extends('layouts.app')

@section('title', Auth::user()->name . ' (' . \App\Models\Role::find(admin())->name . ')')

@section('content')
    <div class="container">
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3 pull-left">
                            <i class="fa fa-users fa-4x" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-9 pull-right text-right">
                            <div class="huge-count"><strong>{{ \App\Models\User::count() }}</strong></div>
                            <div>Users</div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <a href="{{ route('users.index') }}">View Details<i class="fa fa-arrow-right pull-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3 pull-left">
                            <i class="fa fa-cutlery fa-4x" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-9 pull-right text-right">
                            <div class="huge-count"><strong>{{ \App\Models\Merchandise::count() }}</strong></div>
                            <div>Merchandises</div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <a href="{{ route('merchandises.available.index') }}">View Details<i class="fa fa-arrow-right pull-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3 pull-left">
                            <i class="fa fa-money fa-4x" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-9 pull-right text-right">
                            <div class="huge-count"><strong>P{{ number_format(collect(\App\Models\Transaction::dailySales(\Carbon\Carbon::now()->toDateString()))->pluck('_total')->sum(), 0, '.', ',') }}</strong></div>
                            <div>Sales</div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <a href="{{ route('sales_report.index') }}">View Details<i class="fa fa-arrow-right pull-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3 pull-left">
                            <i class="fa fa-credit-card-alt fa-4x" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-9 pull-right text-right">
                            <div class="huge-count"><strong>{{ \App\Models\TootCard::count()}}</strong></div>
                            <div>Toot Cards</div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <a href="{{ route('toot_cards.index') }}">View Details<i class="fa fa-arrow-right pull-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3 pull-left">
                            <i class="fa fa-minus-circle fa-4x" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-9 pull-right text-right">
                            <div class="huge-count"><strong>P{{ collect(\App\Models\Expense::daily(\Carbon\Carbon::now()->toDateString()))->pluck('amount')->sum() }}</strong></div>
                            <div>Expenses</div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <a href="{{ route('expenses.index') }}">View Details<i class="fa fa-arrow-right pull-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3 pull-left">
                            <i class="fa fa-hashtag fa-4x" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-9 pull-right text-right">
                            <div class="huge-count"><strong>{{ \App\Models\Transaction::queued()->count() }}</strong></div>
                            <div>Queued Orders</div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <a href="#next_queue_number">Next queue: <span class="pull-right"><strong>#{{ \App\Models\Transaction::queueNumber() }}</strong></span></a>
                </div>
            </div>
        </div>
    </div>
@endsection