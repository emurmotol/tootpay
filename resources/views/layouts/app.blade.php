<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('layouts._partials.app.meta')

    <title>@yield('title') - {{ config('static.app.name') }}</title>

    @include('layouts._partials.app.stylesheets')

    @if(Route::is('order.order') || Route::is('transaction.idle'))
        @include('layouts._partials.client.stylesheets')
    @endif

    @yield('style')
</head>
<body id="app-layout">
@if(Route::is('order.order') || Route::is('transaction.idle'))
    @yield('content')
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            @include('layouts._partials.app.header', ['url' => url('/')])
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav">
                    @if(Auth::guest())
                        <li {!! (Request::is('faq') ? 'class="active"' : '') !!}>
                            <a href="{{ url('faq') }}">FAQ</a>
                        </li>
                    @else
                        @if(Auth::user()->hasRole(\App\Models\Role::json(0)))
                            @include('dashboard.admin.merchandises._partials.navbar')
                            @include('dashboard.admin.toot_cards._partials.navbar')
                            @include('dashboard.admin.users._partials.navbar')
                            @include('dashboard.admin.sales_report._partials.navbar')
                            @include('dashboard.admin.settings._partials.navbar')
                        @elseif(Auth::user()->hasRole(\App\Models\Role::json(1)))
                            @include('dashboard.cashier._partials.navbar')
                        @elseif(Auth::user()->hasRole(\App\Models\Role::json(2)))
                        @endif
                    @endif
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::guest())
                        <li {!! (Request::is('login') ? 'class="active"' : '') !!}>
                            <a href="{{ url('login') }}">Login</a>
                        </li>
                        <li {!! (Request::is('register') ? 'class="active"' : '') !!}>
                            <a href="{{ url('register') }}">Register</a>
                        </li>
                    @else
                        @if(Auth::user()->hasRole(\App\Models\Role::json(0)))
                        @elseif(Auth::user()->hasRole(\App\Models\Role::json(1)))
                        @elseif(Auth::user()->hasRole(\App\Models\Role::json(2)))
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @include('_partials.flash')
    </div>

    @yield('content')
    @include('layouts._partials.app.footer')
@endif

@include('layouts._partials.app.scripts')
@include('_partials.javascript')

@if(Route::is('order.order') || Route::is('transaction.idle'))
    @include('layouts._partials.client.scripts')
@endif

@yield('javascript')
</body>
</html>
