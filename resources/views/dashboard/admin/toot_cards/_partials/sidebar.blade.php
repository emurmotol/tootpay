<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-credit-card" aria-hidden="true"></i> Toot Cards</div>

    <ul class="list-group">
        <a href="{{ route('toot_cards.index') }}" class="list-group-item {!! Route::is('toot_cards.index') ? 'active' : '' !!}">
            All <span class="badge">{{ \App\Models\TootCard::count() }}</span>
        </a>
        <a href="{{ route('toot_cards.active') }}" class="list-group-item {!! Route::is('toot_cards.active') ? 'active' : '' !!}">
            Active <span class="badge">{{ \App\Models\TootCard::active()->get()->count() }}</span>
        </a>
        <a href="{{ route('toot_cards.inactive') }}" class="list-group-item {!! Route::is('toot_cards.inactive') ? 'active' : '' !!}">
            Inactive <span class="badge">{{ \App\Models\TootCard::inactive()->get()->count() }}</span>
        </a>
        <a href="{{ route('toot_cards.expired') }}" class="list-group-item {!! Route::is('toot_cards.expired') ? 'active' : '' !!}">
            Expired <span class="badge">{{ \App\Models\TootCard::expired()->get()->count() }}</span>
        </a>
        <a href="{{ route('toot_cards.not_associated') }}" class="list-group-item {!! Route::is('toot_cards.not_associated') ? 'active' : '' !!}">
            Not Associated <span class="badge">{{ \App\Models\TootCard::notAssociated()->get()->count() }}</span>
        </a>
    </ul>
</div>