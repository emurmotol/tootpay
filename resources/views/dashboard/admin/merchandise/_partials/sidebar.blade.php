<div class="panel panel-default">
    <div class="panel-heading">Merchandises</div>

    <ul class="list-group">
        <a href="{{ route('merchandises.index') }}" class="list-group-item {!! Route::is('merchandises.index') ? 'active' : '' !!}">
            All <span class="badge">{{ \App\Models\Merchandise::count() }}</span>
        </a>
        <a href="#" class="list-group-item">
            Menu <span class="badge">12</span>
        </a>
        <a href="{{ url('merchandises/available') }}" class="list-group-item {!! Request::is('merchandises/available') ? 'active' : '' !!}">
            Available <span class="badge">{{ \App\Models\Merchandise::available()->get()->count() }}</span>
        </a>
        <a href="{{ url('merchandises/unavailable') }}" class="list-group-item {!! Request::is('merchandises/unavailable') ? 'active' : '' !!}">
            Unavailable <span class="badge">{{ \App\Models\Merchandise::unavailable()->get()->count() }}</span>
        </a>
        <a href="{{ route('merchandise.categories.index') }}" class="list-group-item {!! Route::is('merchandise.categories.index') ? 'active' : '' !!}">
            Categories <span class="badge">{{ \App\Models\MerchandiseCategory::count() }}</span>
        </a>
    </ul>
</div>