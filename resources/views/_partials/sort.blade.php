<div class="btn-group">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
        <span class="text-muted">Sort:</span>
        <span id="sort">{{ str_replace('-', ' ', ucfirst(request()->get('sort'))) }}</span>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu sort">
        @foreach($sort_by as $sort)
            <li><a href="{{ Request::fullUrlWithQuery(['sort' => str_slug($sort)]) }}">{{ $sort }}</a></li>
        @endforeach
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