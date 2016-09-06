<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Account <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{ route('users.profile_index', Auth::user()->id) }}">Profile</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('users.toot_card', Auth::user()->id) }}">Toot Card</a></li>
        <li><a href="{{ route('users.order_history', Auth::user()->id) }}">Order History</a></li>
    </ul>
</li>