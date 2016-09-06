<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Account <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{ route('users.profile', $user->id) }}">Profile</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('users.toot_card', $user->id) }}">Toot Card</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('users.order_history', $user->id) }}">Order History</a></li>
        <li><a href="{{ route('users.reload_history', $user->id) }}">Reload History</a></li>
    </ul>
</li>