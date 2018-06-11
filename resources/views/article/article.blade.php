<section class="article s-content s-content--narrow s-content--no-padding-bottom">
    <div class="container">
        <article class="row format-standard">

            <div class="s-content__header col-full">
                <h1 class="s-content__header-title">
                    {{$article->content->title}}
                </h1>
                <ul class="s-content__header-meta">
                    <li class="date">{{$article->content->created_at}}</li>
                    <li class="cat">
                        @foreach($article['categories'] as $category)
                            <a href="/categories/{{$category['slug']}}">{{$category['name']}}</a>
                        @endforeach
                    </li>
                </ul>
            </div> <!-- end s-content__header -->

            <div class="s-content__media col-full">
                <div class="s-content__post-thumb">
                    <img src="/image/image/{{$article->image}}"
                         alt="">
                </div>
            </div> <!-- end s-content__media -->

            <div class="col-full s-content__main">
                {!! $article->content->body !!}
            </div> <!-- end s-content__main -->


            <p class="s-content__tags">
                <span>@lang('article/article.postTag')</span>

                <span class="s-content__tag-list">
                    @foreach($article['content']['keywords'] as $keyword)
                        <a>{{$keyword}}</a>
                    @endforeach
                </span>
            </p> <!-- end s-content__tags -->

            <div class="s-content__author">

                <img src="/images/author/{{$article['author']['userData']['profile_image']}}" alt="">

                <div class="s-content__author-about">
                    <h4 class="s-content__author-name">
                        {{$article->author->name}}
                    </h4>

                    <p>{{$article['author']['userData']['biography'][LaravelLocalization::getCurrentLocale()]}}</p>
                </div>
            </div>

        </article>

        <!-- comments
     ================================================== -->
        <div class="comments-wrap">

            <div id="comments" class="row">
                <div class="col-full">

                    <h3 class="h2">Comments</h3>

                    <div id="disqus_thread"></div>

                </div> <!-- end col-full -->

            </div> <!-- end row comments -->
        </div> <!-- end comments-wrap -->
    </div>
</section>

@section('scripts')
    <script>

        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
        var disqus_config = function () {
            this.page.url = "@localizeURL('articles/'. $article->slug)";  // Replace PAGE_URL with your page's canonical URL variable
            this.page.identifier = '{{$article->slug}}'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };

        (function () { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = 'https://dusunce-kozasi.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by
            Disqus.</a></noscript>

@endsection