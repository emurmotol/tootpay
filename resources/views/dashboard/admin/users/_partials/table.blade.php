<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Role</th>
            @if(Route::is('users.index') || Route::is('users.cardholder'))
                <th class="text-center">Toot Card</th>
            @endif
            <th class="text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>
                    <a href="{{ route('users.show', [$user->id, 'redirect' => Request::fullUrl()]) }}">
                        <strong>{{ $user->id }}</strong>
                    </a>
                </td>
                <td>
                    <strong>{{ $user->name }}</strong>
                </td>
                <td class="text-muted">
                    {{ $user->roles()->first()->name }}
                </td>
                @if(Route::is('users.index') || Route::is('users.cardholder'))
                    <td class="text-center">
                        @if(is_null($user->tootCards()->first()) && $user->hasRole(cardholder()))
                            <strong>Not set</strong>
                        @elseif(!$user->hasRole(cardholder()))
                            <strong>N/A</strong>
                        @else
                            <a href="{{ route('toot_cards.show', [$user->tootCards()->first()->id, 'redirect' => Request::fullUrl()]) }}">
                                <strong>#{{ $user->tootCards()->first()->uid }}</strong>
                            </a>
                        @endif
                    </td>
                @endif
                <td class="text-center">
                    {!! Form::open(['route' => ['users.destroy', $user->id], 'class' => '']) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-default btn-xs">Edit</a>
                    <button type="submit" class="btn btn-danger btn-xs" {{ (Auth::id() == $user->id) ? 'disabled' : '' }}>Delete</button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="text-center">{{ $users->links() }}</div>