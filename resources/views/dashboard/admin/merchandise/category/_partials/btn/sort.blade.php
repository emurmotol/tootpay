<div class="btn-group">
    <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="text-muted">Sort:</span>
        <span id="sort">{{ str_replace('-', ' ', ucfirst(Request::get('sort'))) }}</span>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu sort">
        <li><a href="{{ Request::fullUrlWithQuery(['sort' => str_slug(trans('sort.name'))]) }}">{{ trans('sort.name') }}</a></li>
        <li><a href="{{ Request::fullUrlWithQuery(['sort' => str_slug(trans('sort.recently_updated'))]) }}">{{ trans('sort.recently_updated') }}</a></li>
        <li><a href="{{ Request::fullUrlWithQuery(['sort' => str_slug(trans('sort.most_entries'))]) }}">{{ trans('sort.most_entries') }}</a></li>
        <li><a href="{{ Request::fullUrlWithQuery(['sort' => str_slug(trans('sort.fewest_entries'))]) }}">{{ trans('sort.fewest_entries') }}</a></li>
    </ul>
</div>

@include('_partials.sort')