<div class="panel panel-default">
    <div class="panel-heading">Merchandises</div>

    <ul class="list-group">
        <a href="{{ route('merchandises.daily_menu.index') }}" class="list-group-item {!! Route::is('merchandises.daily_menu.index') ? 'active' : '' !!}">
            Daily Menu <span class="badge">{{ date("l", strtotime(\Carbon\Carbon::now())) }}</span>
        </a>
        <a href="{{ route('merchandises.index') }}" class="list-group-item {!! Route::is('merchandises.index') ? 'active' : '' !!}">
            All <span class="badge">{{ \App\Models\Merchandise::count() }}</span>
        </a>
        <a href="{{ route('merchandises.available.index') }}" class="list-group-item {!! Route::is('merchandises.available.index') ? 'active' : '' !!}">
            Available <span class="badge">{{ \App\Models\Merchandise::available()->get()->count() }}</span>
        </a>
        <a href="{{ route('merchandises.unavailable.index') }}" class="list-group-item {!! Route::is('merchandises.unavailable.index') ? 'active' : '' !!}">
            Unavailable <span class="badge">{{ \App\Models\Merchandise::unavailable()->get()->count() }}</span>
        </a>
        <a href="{{ route('merchandise.categories.index') }}" class="list-group-item {!! Route::is('merchandise.categories.index') ? 'active' : '' !!}">
            Categories <span class="badge">{{ \App\Models\MerchandiseCategory::count() }}</span>
        </a>
    </ul>
</div>