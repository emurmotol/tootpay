<div class="panel panel-default">
    <div class="panel-heading">Merchandises</div>

    <ul class="list-group">
        <a href="{{ url('merchandises') }}" class="list-group-item {!! Request::is('merchandises') ? 'active' : '' !!}">
            All <span class="badge">{{ \App\Models\Merchandise::count() }}</span>
        </a>
        <a href="{{ url('merchandises/available') }}" class="list-group-item {!! Request::is('merchandises/available') ? 'active' : '' !!}">
            Available <span class="badge">{{ \App\Models\Merchandise::available()->get()->count() }}</span>
        </a>
        <a href="{{ url('merchandises/unavailable') }}" class="list-group-item {!! Request::is('merchandises/unavailable') ? 'active' : '' !!}">
            Unavailable <span class="badge">{{ \App\Models\Merchandise::unavailable()->get()->count() }}</span>
        </a>
        <a href="{{ url('merchandises/categories') }}" class="list-group-item {!! Request::is('merchandises/categories') ? 'active' : '' !!}">
            Categories <span class="badge">{{ \App\Models\MerchandiseCategory::count() }}</span>
        </a>
    </ul>
</div>