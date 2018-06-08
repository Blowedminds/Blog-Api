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
                <span></span>

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
    </div>
</section>
