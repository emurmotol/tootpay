<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Merchandises <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{ route('merchandises.daily_menu.index') }}">Daily Menu</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('merchandises.index') }}">All</a></li>
        <li><a href="{{ route('merchandises.available.index') }}">Available</a></li>
        <li><a href="{{ route('merchandises.unavailable.index') }}">Unavailable</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('merchandise.categories.index') }}">Categories</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('merchandises.create') }}"><i class="fa fa-plus"></i> Merchandise</a></li>
        <li><a href="{{ route('merchandise.categories.create') }}"><i class="fa fa-plus"></i> Category</a></li>
    </ul>
</li>