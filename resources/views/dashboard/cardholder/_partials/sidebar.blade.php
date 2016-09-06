<div class="panel panel-primary">
    <div class="panel-heading">My Account</div>

    <ul class="list-group">
        <a href="{{ route('users.profile_index', Auth::user()->id) }}" class="list-group-item {!! Route::is('users.profile_index') ? 'active' : '' !!}">Profile</a>
        <a href="{{ route('users.toot_card', Auth::user()->id) }}" class="list-group-item {!! Route::is('users.toot_card') ? 'active' : '' !!}">Toot Card</a>
        <a href="{{ route('users.order_history', Auth::user()->id) }}" class="list-group-item {!! Route::is('users.order_history') ? 'active' : '' !!}">
            Order History <span class="badge">0</span>
        </a>
    </ul>
</div>