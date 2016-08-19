<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-users" aria-hidden="true"></i> Users</div>

    <ul class="list-group">
        <a href="{{ route('users.index') }}" class="list-group-item {!! Route::is('users.index') ? 'active' : '' !!}">
            All <span class="badge">{{ \App\Models\User::count() }}</span>
        </a>
    </ul>
</div>