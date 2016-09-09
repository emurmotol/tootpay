<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-users" aria-hidden="true"></i> Users</div>

    <ul class="list-group">
        <a href="{{ route('users.index') }}" class="list-group-item {!! Route::is('users.index') ? 'active' : '' !!}">
            All <span class="badge">{{ \App\Models\User::count() }}</span>
        </a>
        <a href="{{ route('users.admin') }}" class="list-group-item {!! Route::is('users.admin') ? 'active' : '' !!}">
            Administrators <span class="badge">{{ \App\Models\User::admin()->get()->count() }}</span>
        </a>
        <a href="{{ route('users.cashier') }}" class="list-group-item {!! Route::is('users.cashier') ? 'active' : '' !!}">
            Cashiers <span class="badge">{{ \App\Models\User::cashier()->get()->count() }}</span>
        </a>
        <a href="{{ route('users.cardholder') }}" class="list-group-item {!! Route::is('users.cardholder') ? 'active' : '' !!}">
            Cardholders <span class="badge">{{ \App\Models\User::cardholder()->get()->count() }}</span>
        </a>
        <a href="{{ route('users.guest') }}" class="list-group-item {!! Route::is('users.guest') ? 'active' : '' !!}">
            Guests <span class="badge">{{ \App\Models\User::guest()->get()->count() }}</span>
        </a>
    </ul>
</div>