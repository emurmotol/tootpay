<li {!! ((Route::is('merchandises.daily_menu.index') || Route::is('merchandises.index') || Request::is('merchandises/*') || Route::is('merchandise.categories.index') || Request::is('categories/*')) ? 'class="active"' : '') !!}>
    <a href="{{ route('merchandises.daily_menu.index') }}">Merchandises</a>
</li>