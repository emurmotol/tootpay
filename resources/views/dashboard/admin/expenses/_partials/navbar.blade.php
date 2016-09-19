<li {!! ((Route::is('expenses.index') || Request::is('expenses/*')) ? 'class="active"' : '') !!}>
    <a href="{{ route('expenses.index') }}">Expenses</a>
</li>