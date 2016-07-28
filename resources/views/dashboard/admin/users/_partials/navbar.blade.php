<li {!! ((Route::is('users.index') || Request::is('users/*')) ? 'class="active"' : '') !!}>
    <a href="{{ route('users.index') }}">Users</a>
</li>