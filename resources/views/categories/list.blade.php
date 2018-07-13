<div class="columns">
    <div class="column is-4">
        <aside class="menu">

            <ul class="menu-list">
                @foreach($categories as $category)
                    <li>
                        <a class="is-size-3" href="@localizeURL('category/'.  $category->slug)">{{$category->name}}</a>
                    </li>
                @endforeach
            </ul>

        </aside>
    </div>
</div>
