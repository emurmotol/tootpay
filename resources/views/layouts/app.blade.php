<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('layouts._partials.app.meta')

    <title>@yield('title') - {{ ucfirst(config('static.app.name')) }}</title>

    @include('layouts._partials.app.stylesheets')

    @if(!Auth::guest() && Auth::user()->hasRole(cashier()))
        @include('layouts._partials.cashier.stylesheets')
    @endif

    @if(Route::is('order.order') || Route::is('transaction.idle'))
        @include('layouts._partials.client.stylesheets')
    @endif

    @yield('style')
</head>
<body>
@if(Route::is('order.order') || Route::is('transaction.idle'))
    @yield('content')
@elseif(!Auth::guest() && Auth::user()->hasRole(cashier()))
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
                        @if(Auth::user()->hasRole(admin()))
                            @include('dashboard.admin.merchandises._partials.navbar')
                            @include('dashboard.admin.toot_cards._partials.navbar')
                            @include('dashboard.admin.users._partials.navbar')
                            @include('dashboard.admin.settings._partials.navbar')
                            @include('dashboard.admin.expenses._partials.navbar')
                            @include('dashboard.admin.sales_report._partials.navbar')
                        @elseif(Auth::user()->hasRole(cashier()))
                        @elseif(Auth::user()->hasRole(cardholder()))
                            @include('dashboard.cardholder._partials.navbar')
                        @endif
                    @endif
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::guest())
                        <li {!! (Request::is('login') ? 'class="active"' : '') !!}>
                            <a href="{{ url('login') }}">Login</a>
                        </li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                @if(Auth::user()->hasRole(admin()))
                                    <li><a href="{{ route('users.show', Auth::user()->id) }}">Your Profile</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ route('sales_report.print_daily', \Carbon\Carbon::now()->toDateString()) }}" target="_blank">Sales Report</a></li>
                                    <li><a href="{{ route('expenses.print_daily', \Carbon\Carbon::now()->toDateString()) }}" target="_blank">Expenses</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ route('settings.toot_card') }}">Settings</a></li>
                                @elseif(Auth::user()->hasRole(cashier()))
                                @elseif(Auth::user()->hasRole(cardholder()))
                                    <li><a href="{{ url('faq') }}">FAQ</a></li>
                                @endif
                                <li role="separator" class="divider"></li>
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

@if(!Auth::guest() && Auth::user()->hasRole(cashier()))
    @include('layouts._partials.cashier.scripts')
@endif

@if(Route::is('order.order') || Route::is('transaction.idle'))
    @include('layouts._partials.client.scripts')
@endif

@yield('javascript')
</body>
</html>
