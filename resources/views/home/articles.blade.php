<!-- s-content
   ================================================== -->
<section class="s-content">

    <div class="masonry">
        <div class="articles long-row masonry-wrap">

            @foreach($articles as $articleColumn)
                <div class="long-column">
                    @foreach($articleColumn as $article)
                        <article class="masonry__brick entry format-standard">

                            <div class="entry__thumb">
                                <a href="@localizeURL('articles/'.$article['slug'])"
                                   class="entry__thumb-link">
                                    <img src="/image/image/{{$article['image']}}"
                                         alt="">
                                </a>
                            </div>

                            <div class="entry__text">
                                <div class="entry__header">

                                    <div class="entry__date">
                                        <a class="" href="@localizeURL('articles/'.$article['slug'])">@datetime($article['content']['created_at'])</a>
                                    </div>
                                    <h1 class="entry__title">
                                        <a href="@localizeURL('articles/'.$article['slug'])">{{$article['content']['title']}}</a>
                                    </h1>

                                </div>
                                <div class="entry__excerpt">
                                    <p class="">{{$article['content']['sub_title']}}</p>
                                </div>
                                <div class="entry__meta">
                            <span class="entry__meta-links">
                                @foreach($article['categories'] as $category)
                                    <a class="" href="@localizeURL('category/'. $category['slug'])">{{$category['name']}}</a>
                                @endforeach
                            </span>
                                </div>
                            </div>

                        </article> <!-- end article -->
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

</section>