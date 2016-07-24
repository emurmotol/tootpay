<div class="btn-group">
    <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="text-muted">Sort:</span>
        <span id="sort">{{ str_replace('-', ' ', ucfirst(Request::get('sort'))) }}</span>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu sort">
        @if(Route::is('merchandises.index') || Request::is('merchandises/available') || Request::is('merchandises/unavailable') || Route::is('merchandises.categories.show'))
            <li><a href="{{ Request::url() }}?sort={!! str_slug('Name') !!}">Name</a></li>
            <li><a href="{{ Request::url() }}?sort={!! str_slug('Recently updated') !!}">Recently updated</a></li>
            <li><a href="{{ Request::url() }}?sort={!! str_slug('Highest price') !!}">Highest price</a></li>
            <li><a href="{{ Request::url() }}?sort={!! str_slug('Lowest price') !!}">Lowest price</a></li>
        @endif

        @if(Route::is('merchandises.categories.index'))
            <li><a href="{{ Request::url() }}?sort={!! str_slug('Name') !!}">Name</a></li>
            <li><a href="{{ Request::url() }}?sort={!! str_slug('Recently updated') !!}">Recently updated</a></li>
            <li><a href="{{ Request::url() }}?sort={!! str_slug('Most entries') !!}">Most entries</a></li>
            <li><a href="{{ Request::url() }}?sort={!! str_slug('Fewest entries') !!}">Fewest entries</a></li>
        @endif
    </ul>
</div>

@section('sort')
    <script>
        $(function () {
            $(".sort li a").click(function () {
                $("#sort").text($(this).text());
                $("#sort").val($(this).text());
            });
        });
    </script>
@endsection