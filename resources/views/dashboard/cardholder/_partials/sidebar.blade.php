<div class="panel panel-primary">
    <div class="panel-heading">My Account</div>

    <ul class="list-group">
        <a href="{{ route('users.profile', $user->id) }}" class="list-group-item {!! Route::is('users.profile') ? 'active' : '' !!}">
            Profile <span class="badge">0</span>
        </a>
        <a href="{{ route('users.toot_card', $user->id) }}" class="list-group-item {!! Route::is('users.toot_card') ? 'active' : '' !!}">
            Toot Card <span class="badge">0</span>
        </a>
        <a href="{{ route('users.order_history', $user->id) }}" class="list-group-item {!! Route::is('users.order_history') ? 'active' : '' !!}">
            Order History <span class="badge">0</span>
        </a>
        <a href="{{ route('users.reload_history', $user->id) }}" class="list-group-item {!! Route::is('users.reload_history') ? 'active' : '' !!}">
            Reload History <span class="badge">0</span>
        </a>
    </ul>
</div>