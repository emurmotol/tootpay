@extends('layouts.app')

@section('title', $toot_card->id)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.admin.toot_cards._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <span class="pull-left"><i class="fa fa-credit-card" aria-hidden="true"></i> @yield('title')</span>
                        <span class="pull-right"></span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="img-toot-card">
                                    <img src="{{ asset('img/toot-card.jpeg') }}" class="img-responsive" alt="{{ config('static.app.name') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li>
                                        <h4>Cardholder:
                                            @if(is_null($toot_card->users()->first()))
                                                <strong>Not associated</strong>
                                            @else
                                                <a href="{{ route('users.show', $toot_card->users()->first()->id) }}">
                                                    <strong>{{ $toot_card->users()->first()->name }}</strong>
                                                </a>
                                            @endif
                                        </h4>
                                    </li>
                                    <li><h4>ID: <strong>{{ $toot_card->id }}</strong></h4></li>
                                    <li><h4>UID: <strong>#{{ $toot_card->uid }}</strong></h4></li>
                                    <li><h4>Load: <strong>P{{ number_format($toot_card->load, 2, '.', ',') }}</strong></h4></li>
                                    <li><h4>Points: <strong>{{ number_format($toot_card->points, 2, '.', ',') }}</strong></h4></li>
                                    <li><h4>Active? {!! $toot_card->is_active ? '<strong class="text-success">Yes</strong>' : '<strong class="text-danger">No</strong>' !!}</h4></li>
                                    <li><h4>Expiration Date: <strong>{{ $toot_card->expires_at->toFormattedDateString() }}</strong></h4></li>
                                    <li><h4>Created: <strong>{{ $toot_card->created_at->toFormattedDateString() }}</strong></h4></li>
                                    <li><h4>Updated: <strong data-livestamp="{{ strtotime($toot_card->updated_at) }}"></strong></h4></li>
                                </ul>
                                {!! Form::open([
                                'route' => ['toot_cards.destroy', $toot_card->id,
                                'redirect=' . request()->get('redirect')],
                                'class' => '']) !!}
                                {!! Form::hidden('_method', 'DELETE') !!}
                                <a href="{{ route('toot_cards.edit', [$toot_card->id, 'redirect' => Request::fullUrl()]) }}"
                                   class="btn btn-default">Edit</a>
                                <button type="submit" class="btn btn-danger">Delete</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                @if ($reloads->count() || $load_shares->count())
                    <div class="panel panel-primary">
                        <div class="panel-heading clearfix">
                            <span class="pull-left">History</span>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                @if ($reloads->count())
                                    <li {{ ($reloads->count() && !$load_shares->count()) ? 'class=active' : '' }}>
                                        <a data-toggle="tab" href="#reload_activity">Reloads</a>
                                    </li>
                                @endif

                                @if ($load_shares->count())
                                    <li {{ (!$reloads->count() && $load_shares->count()) ? 'class=active' : '' }}>
                                        <a data-toggle="tab" href="#load_shares_activity">Load Shares</a>
                                    </li>
                                @endif
                            </ul>
                            <div class="tab-content">
                                @if ($reloads->count())
                                    <div id="reload_activity" class="tab-pane fade in {{ ($reloads->count() && !$load_shares->count()) ? 'active' : '' }}">
                                        <table class="table table-responsive table-transaction">
                                            <thead>
                                            <tr>
                                                <th>Amount Due</th>
                                                <th>Created</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($reloads as $reload)
                                                <tr>
                                                    <td>P{{ number_format($reload->load_amount, 2, '.', ',') }}</td>
                                                    <td data-livestamp="{{ strtotime($reload->created_at) }}"></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                @if ($load_shares->count())
                                    <div id="load_shares_activity" class="tab-pane fade in {{ (!$reloads->count() && $load_shares->count()) ? 'active' : '' }}">
                                        <table class="table table-responsive table-transaction">
                                            <thead>
                                            <tr>
                                                <th>Load Amount</th>
                                                <th>Shared To</th>
                                                <th>Created</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($load_shares as $load_share)
                                                <tr>
                                                    <td>P{{ number_format($load_share->load_amount, 2, '.', ',') }}</td>
                                                    <td>{{ \App\Models\TootCard::find($load_share->to_toot_card_id)->users()->first()->name }}</td>
                                                    <td data-livestamp="{{ strtotime($load_share->created_at) }}"></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection