<li {!! ((Route::is('merchandises.index') || Request::is('merchandises/*') || Route::is('merchandise.categories.index') || Request::is('categories/*')) ? 'class="active"' : '') !!}>
    <a href="{{ route('merchandises.index') }}">Merchandises</a>
</li>