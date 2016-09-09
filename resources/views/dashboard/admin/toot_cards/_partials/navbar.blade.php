<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Toot Cards <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{ route('toot_cards.index') }}">All</a></li>
        <li><a href="{{ route('toot_cards.active') }}">Active</a></li>
        <li><a href="{{ route('toot_cards.inactive') }}">Inactive</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('toot_cards.expired') }}">Expired</a></li>
        <li><a href="{{ route('toot_cards.not_associated') }}">Not Associated</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('toot_cards.create') }}"><i class="fa fa-plus"></i> Toot Card</a></li>
    </ul>
</li>