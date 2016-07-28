<li {!! ((Route::is('toot_cards.index') || Request::is('toot_cards/*')) ? 'class="active"' : '') !!}>
    <a href="{{ route('toot_cards.index') }}">Toot Cards</a>
</li>