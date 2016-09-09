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
                            <div class="col-md-6">
                                {!! Form::open(['route' => ['users.proceed_transfer', $user->id, $toot_card->id]]) !!}
                                <div class="form-group{{ $errors->has('toot_card_id') ? ' has-error' : '' }}">
                                    <label for="toot_card_id">Select Toot Card:</label>
                                    <select id="toot_card_id" name="toot_card_id" class="form-control">
                                        @foreach(\App\Models\TootCard::all() as $toot_card)
                                            <option value="{{ $toot_card->id }}" {{ (old('toot_card_id') == $toot_card->id) ? 'selected' : '' }}>{{ $toot_card->uid }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('toot_card_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('toot_card_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary" data-loading-text="{{ trans('loading.default') }}">Proceed Transfer</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection