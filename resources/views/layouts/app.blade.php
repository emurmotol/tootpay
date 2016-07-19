<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('layouts.app.meta')

    <title>@yield('title') - {{ config('static.app.name') }}</title>

    @include('layouts.app.stylesheets')
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            @include('layouts.app.header')

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav">
                    @if (Auth::guest())
                        <li {!! (Request::is('faq') ? 'class="active"' : '') !!}>
                            <a href="{{ url('faq') }}">FAQ</a>
                        </li>
                    @else
                        {{--<li><a href="{{ url('merchandise') }}">Merchandise</a></li>--}}
                    @endif
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li {!! (Request::is('login') ? 'class="active"' : '') !!}>
                            <a href="{{ url('login') }}">Login</a>
                        </li>
                        <li {!! (Request::is('register') ? 'class="active"' : '') !!}>
                            <a href="{{ url('register') }}">Register</a>
                        </li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
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

    @yield('content')

    <footer>
        <div class="container text-muted text-center">
            <hr><i class="fa fa-copyright" aria-hidden="true"></i> {{ date('Y') }} Toot Pay
        </div>
    </footer>

    @include('layouts.app.scripts')

    @yield('javascript')
</body>
</html>
