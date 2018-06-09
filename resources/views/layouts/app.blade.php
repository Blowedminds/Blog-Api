<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
{{--    <link href="{{ asset('css/fontawesome-all.min.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    @yield('styles')

</head>
<body>
    <div id="app">

        <header class="header" style="position: unset;">
            <div class="header__content row">

                <div class="header__logo">
                    <a class="logo" href="/">
                        <img src="/images/logo.png" alt="Homepage">
                    </a>
                </div> <!-- end header__logo -->

                <ul class="header__social">
                    <li>
                        <a href="#0"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#0"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#0"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#0"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                    </li>
                </ul> <!-- end header__social -->

                <a class="header__search-trigger" href="#0"></a>

                <ul class="language-selector">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        @if($localeCode != LaravelLocalization::getCurrentLocale())
                            <li>
                                <a rel="alternate" hreflang="{{ $localeCode }}" class="navbar-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="header__search">

                    <form role="search" method="get" class="header__search-form" action="#">
                        <label>
                            <span class="hide-content">Search for:</span>
                            <input type="search" class="search-field" placeholder="Type Keywords" value="" name="s" title="Search for:" autocomplete="off">
                        </label>
                        <input type="submit" class="search-submit" value="Search">
                    </form>

                    <a href="#0" title="Close Search" class="header__overlay-close">Close</a>

                </div>  <!-- end header__search -->


                <a class="header__toggle-menu" href="#0" title="Menu"><span>Menu</span></a>

                <nav class="header__nav-wrap">

                    <h2 class="header__nav-heading h6">Site Navigation</h2>

                    <ul class="header__nav">
                        @foreach($menus as $menu)
                            <li class="current">
                                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), $menu->url, [], true) }}"
                                   title="{{$menu->tooltip}}">{{$menu->name}}</a>
                            </li>
                        @endforeach

                        {{--<li class="has-children">--}}
                            {{--<a href="#0" title="">Categories</a>--}}
                            {{--<ul class="sub-menu">--}}
                                {{--<li><a href="category.html">Lifestyle</a></li>--}}
                                {{--<li><a href="category.html">Health</a></li>--}}
                                {{--<li><a href="category.html">Family</a></li>--}}
                                {{--<li><a href="category.html">Management</a></li>--}}
                                {{--<li><a href="category.html">Travel</a></li>--}}
                                {{--<li><a href="category.html">Work</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                    </ul> <!-- end header__nav -->

                    <a href="#0" title="Close Menu" class="header__overlay-close close-mobile-menu">Close</a>

                </nav> <!-- end header__nav-wrap -->

            </div> <!-- header-content -->
        </header> <!-- header -->

        <main class="py-4">
            @yield('content')
        </main>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Get all "navbar-burger" elements
            var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

            // Check if there are any navbar burgers
            if ($navbarBurgers.length > 0) {

                // Add a click event on each of them
                $navbarBurgers.forEach(function ($el) {
                    $el.addEventListener('click', function () {

                        // Get the target from the "data-target" attribute
                        var target = $el.dataset.target;
                        var $target = document.getElementById(target);

                        // Toggle the class on both the "navbar-burger" and the "navbar-menu"
                        $el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');

                    });
                });
            }

        });
    </script>
    @yield('scripts')
</body>
</html>
