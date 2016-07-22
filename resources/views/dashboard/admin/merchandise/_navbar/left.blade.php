<li {!! ((Request::is('merchandises') || Request::is('merchandises/*') || Request::is('categories') || Request::is('categories/*')) ? 'class="active"' : '') !!}>
    <a href="{{ url('merchandises') }}">Merchandises</a>
</li>