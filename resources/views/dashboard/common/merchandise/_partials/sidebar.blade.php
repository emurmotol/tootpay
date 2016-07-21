<div class="panel panel-default">
    <div class="panel-heading">Merchandises</div>

    <ul class="list-group">
        <a href="{{ url('merchandises') }}" class="list-group-item {!! (Request::is('merchandises') ? 'active' : '') !!}">
            All <span class="badge">{{ count(\App\Models\Merchandise::all()) }}</span>
        </a>
        <a href="{{ url('merchandises/available') }}" class="list-group-item {!! (Request::is('merchandises/available') ? 'active' : '') !!}">
            Available <span class="badge">{{ count(\App\Models\Merchandise::available()) }}</span>
        </a>
        <a href="{{ url('merchandises/unavailable') }}" class="list-group-item {!! (Request::is('merchandises/unavailable') ? 'active' : '') !!}">
            Unavailable <span class="badge">{{ count(\App\Models\Merchandise::unavailable()) }}</span>
        </a>
    </ul>
</div>