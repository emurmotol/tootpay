<li {!! ((Request::is('merchandises') || Request::is('merchandises/*')) ? 'class="active"' : '') !!}>
    <a href="{{ url('merchandises') }}">Merchandises</a>
</li>