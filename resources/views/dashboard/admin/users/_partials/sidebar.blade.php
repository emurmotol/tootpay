<div class="panel panel-default">
    <div class="panel-heading">Users</div>

    <ul class="list-group">
        <a href="{{ route('users.index') }}" class="list-group-item {!! Route::is('users.index') ? 'active' : '' !!}">
            All <span class="badge">{{ \App\Models\User::count() }}</span>
        </a>
    </ul>
</div>