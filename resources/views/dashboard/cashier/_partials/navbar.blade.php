<li {!! ((Route::is('cashier.queue')) ? 'class="active"' : '') !!}>
    <a href="{{ route('cashier.queue') }}">Queue</a>
</li>
<li {!! ((Route::is('cashier.reloads')) ? 'class="active"' : '') !!}>
    <a href="{{ route('cashier.reloads') }}">Reloads</a>
</li>