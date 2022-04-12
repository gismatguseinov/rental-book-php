<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/btsrap.js')}}"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}"></script>
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
        <div class="collapse navbar-collapse" style="margin-right: 55% " id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @if (Route::has('login'))
                        <div class="row" style="display: flex;padding-left:60px;">
                            @auth
                                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                    <a class="navbar-brand" href="{{route('site.index')}}">Home</a>
                                    @if(\Illuminate\Support\Facades\Auth::user()->is_librarian == 1)
                                        <a class="navbar-brand" href="{{route('dashboard.borrows')}}">Dashboard</a>
                                    @endif
                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('site.books')}}">Books</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('site.borrow-list')}}">My
                                                    Borrows</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('site.about-us')}}">About
                                                    Us</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('site.profile')}}">Profile</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                    Logout
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                      class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                            @else
                                <a href="{{ route('login') }}"
                                   class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                       class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                @endguest
            </ul>
        </div>
    </nav>
    <main class="py-4 mt-5">
        @yield('content')
    </main>
</div>
</body>
</html>

