<div class="pageheader-content row">
    <div class="col-full">

        <div class="featured">

            @if(!empty($latest_big))
                <div class="featured__column featured__column--big">
                    <div class="entry" style="background-image:url('/image/image/{{$latest_big['image']}}');">

                        <div class="entry__content">
                            @if(!empty($latest_big['categories']))
                                <span class="entry__category">
                                    <a href="@localizeURL('category/' . $latest_big['categories'][0]['slug'])">
                                        {{$latest_big['categories'][0]['name']}}
                                    </a>
                                </span>
                            @endif
                            <h1>
                                <a href="@localizeURL('articles/'.$latest_big['slug'])"
                                   title="">
                                    {{$latest_big['content']['title']}}
                                </a>
                            </h1>

                            <div class="entry__info">
                                {{--<a href="#0" class="entry__profile-pic">--}}
                                    {{--<img class="avatar" src="images/avatars/user-03.jpg" alt="">--}}
                                {{--</a>--}}

                                <ul class="entry__meta">
                                    <li>{{$latest_big['author']['name']}}</li>
                                    <li>@datetime($latest_big['content']['created_at'])</li>
                                </ul>
                            </div>
                        </div> <!-- end entry__content -->

                    </div> <!-- end entry -->
                </div> <!-- end featured__big -->
            @endif

            <div class="featured__column featured__column--small">
                @foreach($latest as $article)
                <div class="entry" style="background-image:url('/image/image/{{$article['image']}}');">

                    <div class="entry__content">
                        @if(!empty($article['categories']))
                            <span class="entry__category">
                                    <a href="@localizeURL('category/' . $article['categories'][0]['slug'])">
                                        {{$article['categories'][0]['name']}}
                                    </a>
                                </span>
                        @endif

                        <h1>
                            <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'articles/'.$article['slug'])}}"
                               title="">
                                {{$article['content']['title']}}
                            </a>
                        </h1>

                        <div class="entry__info">
                            {{--<a href="#0" class="entry__profile-pic">--}}
                                {{--<img class="avatar" src="images/avatars/user-03.jpg" alt="">--}}
                            {{--</a>--}}

                            <ul class="entry__meta">
                                <li><a href="#0">{{$article['author']['name']}}</a></li>
                                <li>@datetime($article['content']['created_at'])</li>
                            </ul>
                        </div>
                    </div> <!-- end entry__content -->

                </div> <!-- end entry -->
                @endforeach

            </div> <!-- end featured__small -->
        </div> <!-- end featured -->

    </div> <!-- end col-full -->
</div> <!-- end pageheader-content row -->