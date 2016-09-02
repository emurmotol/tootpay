<li {!! ((Route::is('settings.toot_card') || Route::is('settings.operation_day')) ? 'class="active"' : '') !!}>
    <a href="{{ route('settings.toot_card') }}">Settings</a>
</li>