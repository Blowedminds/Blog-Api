<!-- pageheader
   ================================================== -->
<div class="s-pageheader">

    <header class="header">
        <div class="header__content row">

            <div class="header__logo">
                <a class="logo" href="/">
                    <img src="/images/logo.png" alt="{{env('APP_NAME', 'Düşünce Kozası')}}">
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

            <div class="header__search">

                <form role="search" method="get" class="header__search-form" action="#">
                    <label>
                        <span class="hide-content">Search for:</span>
                        <input type="search" class="search-field" placeholder="Type Keywords" value="" name="s"
                               title="Search for:" autocomplete="off">
                    </label>
                    <input type="submit" class="search-submit" value="Search">
                </form>

                <a href="#0" title="Close Search" class="header__overlay-close">Close</a>

            </div>  <!-- end header__search -->

            {{--<div class="header__language">--}}
                {{--<ul>--}}
                    {{--@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)--}}
                        {{--@if($localeCode != LaravelLocalization::getCurrentLocale())--}}
                            {{--<li>--}}
                                {{--<a rel="alternate" hreflang="{{ $localeCode }}" class="navbar-item"--}}
                                   {{--href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">--}}
                                    {{--{{ $properties['native'] }}--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        {{--@endif--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
            {{--</div>--}}

            <a class="header__toggle-menu" title="Menu"><span>Menu</span></a>

            <nav class="header__nav-wrap">

                <h2 class="header__nav-heading h6">Site Navigation</h2>

                <ul class="header__nav">
                    @foreach($menus as $menu)
                        <li>
                            <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), $menu->url, [], true) }}"
                               title="{{$menu->tooltip}}">{{$menu->name}}</a>
                        </li>
                    @endforeach
                </ul> <!-- end header__nav -->

                <a href="#0" title="Close Menu" id="header__nav-wrap-close" class="header__overlay-close close-mobile-menu">Close</a>

            </nav> <!-- end header__nav-wrap -->

        </div> <!-- header-content -->
    </header> <!-- header -->

</div> <!-- end s-pageheader -->

@section('scripts')
<script>
    (function() {
        var navWrap = document.getElementsByClassName('header__nav-wrap').item(0),
            closeNavWrap = document.getElementById('header__nav-wrap-close'),
            menuToggle = document.getElementsByClassName('header__toggle-menu').item(0),
            siteBody = document.getElementsByTagName('body').item(0);

        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            siteBody.classList.add('nav-wrap-is-visible');
        });

        closeNavWrap.addEventListener('click', function(e) {

            e.preventDefault();
            e.stopPropagation();

            var className = ' nav-wrap-is-visible ';
            if ( (" " + siteBody.className + " ").replace(/[\n\t]/g, " ").indexOf(className) > -1 ) {
                siteBody.classList.remove('nav-wrap-is-visible');
            }
        });

        // // open (or close) submenu items in mobile view menu.
        // // close all the other open submenu items.
        // $('.header__nav .has-children').children('a').on('click', function (e) {
        //     e.preventDefault();
        //
        //     if ($(".close-mobile-menu").is(":visible") == true) {
        //
        //         $(this).toggleClass('sub-menu-is-open')
        //             .next('ul')
        //             .slideToggle(200)
        //             .end()
        //             .parent('.has-children')
        //             .siblings('.has-children')
        //             .children('a')
        //             .removeClass('sub-menu-is-open')
        //             .next('ul')
        //             .slideUp(200);
        //
        //     }
        // });

    })();
</script>
@endsection