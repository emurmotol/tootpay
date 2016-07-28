<div class="panel panel-default">
    <div class="panel-heading">Toot Cards</div>

    <ul class="list-group">
        <a href="{{ route('toot_cards.index') }}" class="list-group-item {!! Route::is('toot_cards.index') ? 'active' : '' !!}">
            All <span class="badge">{{ \App\Models\TootCard::count() }}</span>
        </a>
    </ul>
</div>