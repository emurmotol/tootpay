@if($user->hasRole(cardholder()))
    <div class="row">
        <div class="col-md-6">
            @if(is_null($user->tootCards()->first()))
                <span class="help-block">{{ trans('user.no_card') }}</span>
            @else
                @if(request()->has('redirect'))
                    {!! Form::open([
                        'route' => ['users.remove_card', $user->id, $user->tootCards()->first()->id, 'redirect' => request()->get('redirect')],
                        'class' => 'form-inline'
                    ]) !!}
                @else
                    {!! Form::open([
                        'route' => ['users.remove_card', $user->id, $user->tootCards()->first()->id],
                        'class' => 'form-inline'
                    ]) !!}
                @endif

                <div class="form-group">
                    <label><i class="fa fa-credit-card" aria-hidden="true"></i> Toot Card ID:</label>
                    <p class="form-control-static">
                        <a href="{{ route('toot_cards.edit', $user->tootCards()->first()->id) }}">
                            <strong>{{ $user->tootCards()->first()->id }}</strong>
                        </a>&nbsp;&nbsp;&nbsp;&nbsp;---
                    </p>
                </div>

                @unless(is_null($user->tootCards()->first()))
                    <button type="submit" class="btn btn-link"><span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Remove card</span></button>
                @endunless
                <hr>
                {!! Form::close() !!}
            @endif
        </div>
    </div>
@endif