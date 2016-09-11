@extends('layouts.app')

@section('title', 'Transfer Toot Card')

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
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            @if(\App\Models\TootCard::available()->count())
                                <div class="col-md-6">
                                    <h4><strong>From:</strong></h4>
                                    <ul class="list-unstyled">
                                        <li><strong>Cardholder Information:</strong></li>
                                        <li>User ID: {{ $user->id }}</li>
                                        <li>Name: <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></li>
                                        <li><strong>Toot Card Information:</strong></li>
                                        <li>UID: <a href="{{ route('toot_cards.show', $toot_card->id) }}">#{{ $toot_card->uid }}</a></li>
                                        <li>Load: P{{ number_format($toot_card->load, 2, '.', ',') }}</li>
                                        <li>Points: {{ number_format($toot_card->points, 2, '.', ',') }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h4><strong>To:</strong></h4>
                                    {!! Form::open(['route' => ['users.proceed_transfer', $user->id, $toot_card->id]]) !!}
                                    <div class="form-group{{ $errors->has('toot_card_id') ? ' has-error' : '' }}">
                                        <label for="toot_card_id">Select Toot Card:</label>
                                        <select id="toot_card_id" name="toot_card_id" class="form-control">
                                            @foreach(\App\Models\TootCard::available() as $toot_card)
                                                <option value="{{ $toot_card->id }}" {{ (old('toot_card_id') == $toot_card->id) ? 'selected' : '' }}>{{ $toot_card->uid }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('toot_card_id'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('toot_card_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary"
                                            data-loading-text="{{ trans('loading.default') }}">Proceed Transfer
                                    </button>
                                    {!! Form::close() !!}
                                </div>
                            @else
                                <div class="col-md-6">
                                    <span class="help-block">{{ trans('toot_card.no_available') }}</span>
                                    @include('_partials.create', ['url' => route('toot_cards.create', ['redirect' => Request::fullUrl()]), 'what' => 'toot card'])
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection