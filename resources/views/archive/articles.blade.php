<div class="columns is-multiline">
    @foreach($articles['data'] as $article)
        <div class="column is-half">
            <article class="media">
                <figure class="media-left">
                    <p class="image is-96x96 has-background-cover has-background-centered"
                       style="background-image: url('/image/thumb/{{$article['image']}}')">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <p>
                            <strong class="has-text-weight-bold">{{$article['author']['name']}}</strong>
                            <small>@datetime($article['content']['created_at'])</small>
                            <br>
                            <a class="has-text-weight-bold"
                               href="@localizeURL('articles/' . $article['slug'])">{{$article['content']['title']}}</a>
                        </p>
                    </div>
                    <nav class="level is-mobile">
                        <div class="level-left">
                        </div>
                    </nav>
                </div>
                <div class="media-right">
                </div>
            </article>
        </div>
    @endforeach
</div>

<div class="columns">
    <div class="column">
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
                    <li>
                        <a class="pgn__num" href="{{$articles['path']}}?page={{$articles['last_page']}}">
                            {{$articles['last_page']}}
                        </a>
                    </li>
                @endif

                @isset($articles['next_page_url'])
                    <li><a class="pgn__next" href="{{$articles['next_page_url']}}">Next</a></li>
                @endisset
            </ul>
        </nav>
    </div>
</div>
