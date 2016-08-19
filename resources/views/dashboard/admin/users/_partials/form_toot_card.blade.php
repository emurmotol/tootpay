@if($user->hasRole(cardholder()))
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-credit-card" aria-hidden="true"></i> Toot Card
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    @if(is_null($user->tootCards()->first()))
                        <p class="help-block">{{ trans('user.no_card') }}</p>
                    @else
                        @if(request()->has('redirect'))
                            {!! Form::open([
                                'route' => ['users.remove_card', $user->id, $user->tootCards()->first()->id, 'redirect' => request()->get('redirect')],
                                'class' => ''
                            ]) !!}
                        @else
                            {!! Form::open([
                                'route' => ['users.remove_card', $user->id, $user->tootCards()->first()->id],
                                'class' => ''
                            ]) !!}
                        @endif

                        <div class="form-group">
                            <p class="form-control-static">
                                <label>ID: </label>
                                <a href="{{ route('toot_cards.edit', $user->tootCards()->first()->id) }}">
                                    <strong>{{ $user->tootCards()->first()->id }}</strong>
                                </a>
                            </p>
                        </div>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true" data-loading-text="<i class='fa fa-spinner fa-pulse'></i> Please wait..."></i> Remove card</button>
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(is_null($user->tootCards()->first()))
        <div class="panel panel-primary">
            <div class="panel-heading">
                Associate toot card to {{ $user->name }}
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        @if(\App\Models\TootCard::where('is_active', false)->count())
                            @if(request()->has('redirect'))
                                {!! Form::open([
                                    'route' => ['users.associate_card', $user->id, 'redirect' => request()->get('redirect')],
                                    'class' => ''
                                ]) !!}
                            @else
                                {!! Form::open([
                                    'route' => ['users.associate_card', $user->id],
                                    'class' => ''
                                ]) !!}
                            @endif

                            <div class="form-group{{ $errors->has('toot_card_id') ? ' has-error' : '' }}">
                                <label for="toot_card_id">Select Toot Card:</label>
                                <select id="toot_card_id" name="toot_card_id" class="form-control">
                                    {{--Add condition if not active and not associated--}}
                                    @foreach(\App\Models\TootCard::where('is_active', false)->get() as $toot_card)
                                        <option value="{{ $toot_card->id }}" {{ (old('toot_card_id') == $toot_card->id) ? 'selected' : '' }}>{{ $toot_card->id }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('toot_card_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('toot_card_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-pulse'></i> Please wait...">Associate card</button>
                            {!! Form::close() !!}
                        @else
                            <span class="help-block">{{ trans('toot_card.no_available') }}</span>
                            @include('_partials.create', ['url' => route('toot_cards.create', ['redirect' => Request::fullUrl()]), 'what' => 'toot card'])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif