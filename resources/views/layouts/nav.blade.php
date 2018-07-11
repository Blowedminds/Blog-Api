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

            <a class="header__search-trigger" href="">Search <i class="fa fa-search"></i></a>

            <div class="header__search">

                <form role="search" method="get" class="header__search-form" action="/results">
                    <label>
                        <span class="hide-content">Search for</span>
                        <input type="search" class="search-field" placeholder="Type Keywords" value="" name="q"
                               title="Search for" autocomplete="off">
                    </label>
                    <input type="submit" class="search-submit" value="Search">
                </form>

                <a href="" title="Close Search" class="header__overlay-close">Close</a>

            </div>  <!-- end header__search -->

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

        var searchTrigger = document.getElementsByClassName('header__search-trigger').item(0),
            searchOverlay = document.getElementsByClassName('header__search').item(0),
            searchClose = document.getElementsByClassName('header__overlay-close').item(0);

        searchTrigger.addEventListener('click', function(e) {
           e.preventDefault();
           e.stopPropagation();

           searchOverlay.style.opacity = 1;
           searchOverlay.style.visibility = 'visible';
        });

        searchClose.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            searchOverlay.style.opacity = 0;
            setTimeout(function() {
                searchOverlay.style.visibility = 'hidden';
            }, 1000);
        })
    })();
</script>
@endsection