<div class="row md-six tab-full popular">
    <div class="block-1-2 block-m-full popular__posts">
        @foreach($articles['data'] as $article)
            <article class="col-block popular__post">
                <a href="@localizeURL('articles/' . $article['slug'])" class="popular__thumb">
                    <img src="/image/thumb/{{$article['image']}}" alt="">
                </a>
                <h5><a href="@localizeURL('articles/' . $article['slug'])">{{$article['content']['title']}}</a></h5>
                <section class="popular__meta">
                    <span class="popular__author"><span>By</span> <a> {{$article['author']['name']}}</a></span>
                    <span class="popular__date">
                        <span>on</span>
                        <time datetime="{{$article['content']['created_at']}}">{{$article['content']['created_at']}}
                        </time>
                    </span>
                </section>
            </article>
        @endforeach

        <div class="row">
            <div class="col-full">
                <nav class="pgn">
                    <ul>
                        @isset($articles['prev_page_url'])
                            <li><a class="pgn__prev" href="{{$articles['prev_page_url']}}">Prev</a></li>
                        @endisset

                        @for($i = max(1, $articles['current_page'] - 2);
                             $i <= min($articles['last_page'], max(5, $articles['current_page'] + 2));
                             $i++)
                            @if($i == $articles['current_page'])
                                <li>
                                    <span class="pgn__num current"
                                          href="{{$articles['path']}}?page={{$i}}">{{$i}}</span>
                                </li>
                            @else
                                <li><a class="pgn__num" href="{{$articles['path']}}?page={{$i}}">{{$i}}</a></li>
                            @endif
                        @endfor

                        @if($articles['current_page'] + 2 < $articles['last_page'])
                            <li>...</li>
                            <li><a class="pgn__num" href="{{$articles['path']}}?page={{$articles['last_page']}}">{{$articles['last_page']}}</a></li>
                        @endif

                        @isset($articles['next_page_url'])
                            <li><a class="pgn__next" href="{{$articles['next_page_url']}}">Next</a></li>
                        @endisset
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>