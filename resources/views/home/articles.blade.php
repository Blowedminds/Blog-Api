<!-- s-content
   ================================================== -->
<section class="s-content">

    <div class="columns masonry-wrap">
        <div class="masonry">

        </div>
    </div>

    <div class="row masonry-wrap">

        <div class="masonry">

            <div class="grid-sizer"></div>
            @foreach($articles as $article)
                <article class="masonry__brick entry format-standard">

                    <div class="entry__thumb">
                        <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'articles/'.$article['slug'])}}"
                           class="entry__thumb-link">
                            <img src="/image/image/{{$article['image']}}"
                                 alt="">
                        </a>
                    </div>

                    <div class="entry__text">
                        <div class="entry__header">

                            <div class="entry__date">
                                <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'articles/'.$article['slug'])}}">{{$article['content']['created_at']}}</a>
                            </div>
                            <h1 class="entry__title">
                                <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'articles/'.$article['slug'])}}">{{$article['content']['title']}}</a>
                            </h1>

                        </div>
                        <div class="entry__excerpt">
                            <p>{{$article['content']['sub_title']}}</p>
                        </div>
                        <div class="entry__meta">
                            <span class="entry__meta-links">
                                @foreach($article['categories'] as $category)
                                    <a href="/categories/{{$category['slug']}}">{{$category['name']}}</a>
                                @endforeach
                            </span>
                        </div>
                    </div>

                </article> <!-- end article -->
            @endforeach

        </div> <!-- end masonry -->
    </div> <!-- end masonry-wrap -->

    {{--<div class="row">--}}
        {{--<div class="col-full">--}}
            {{--<nav class="pgn">--}}
                {{--<ul>--}}
                    {{--@isset($articles['prev_page_url'])--}}
                        {{--<li><a class="pgn__prev" href="{{$articles['prev_page_url']}}">Prev</a></li>--}}
                    {{--@endisset--}}

                    {{--@for($i = 1; $i <= $articles['last_page']; $i++)--}}
                        {{--@if($i == $articles['current_page'])--}}
                            {{--<li><span class="pgn__num current" href="{{$articles['path']}}?page={{$i}}">{{$i}}</span>--}}
                            {{--</li>--}}
                        {{--@else--}}
                            {{--<li><a class="pgn__num" href="{{$articles['path']}}?page={{$i}}">{{$i}}</a></li>--}}
                        {{--@endif--}}
                    {{--@endfor--}}

                    {{--@isset($articles['next_page_url'])--}}
                        {{--<li><a class="pgn__next" href="{{$articles['next_page_url']}}">Next</a></li>--}}
                    {{--@endisset--}}
                {{--</ul>--}}
            {{--</nav>--}}
        {{--</div>--}}
    {{--</div>--}}

</section>