@extends('layouts.app')

@section('title', $toot_card->id)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.admin.toot_cards._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-credit-card" aria-hidden="true"></i> @yield('title')
                        <span class="pull-right">
                            {!! Form::open([
                                'route' => ['toot_cards.destroy', $toot_card->id,
                                'redirect=' . request()->get('redirect')],
                                'class' => '']) !!}
                            {!! Form::hidden('_method', 'DELETE') !!}
                            <a href="{{ route('toot_cards.edit', [$toot_card->id, 'redirect' => Request::fullUrl()]) }}"
                               class="btn btn-default btn-xs">Edit</a>
                                <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                            {!! Form::close() !!}
                        </span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-unstyled">
                                    <li>
                                        <h4>Toot Card ID: <strong>{{ $toot_card->id }}</strong></h4>
                                        <h4>Cardholder:
                                            @if(is_null($toot_card->users()->first()))
                                                <strong>Not associated</strong>
                                            @else
                                                <a href="{{ route('users.show', $toot_card->users()->first()->id) }}">
                                                    <strong>{{ $toot_card->users()->first()->name }}</strong>
                                                </a>
                                            @endif
                                        </h4>
                                        <h4>Load: <strong>P{{ number_format($toot_card->load, 2, '.', ',') }}</strong> as of {{ \Carbon\Carbon::now()->toDayDateTimeString() }}</h4>
                                        <h4>Points: <strong>{{ number_format($toot_card->points, 2, '.', ',') }}</strong> as of {{ \Carbon\Carbon::now()->toDayDateTimeString() }}</h4>
                                        <h4>Active? <strong>{{ $toot_card->is_active ? 'Yes' : 'No' }}</strong></h4>
                                        <h4>Expiration Date: <strong>{{ $toot_card->expires_at->toFormattedDateString() }}</strong></h4>
                                        <h4>Created: <strong>{{ $toot_card->created_at->toFormattedDateString() }}</strong></h4>
                                        <h4>Updated: <strong>{{ $toot_card->updated_at->diffForHumans() }}</strong></h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection