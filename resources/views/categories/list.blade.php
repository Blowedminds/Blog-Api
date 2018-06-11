<ul>
    @foreach($categories as $category)
        <li>
            <a href="@localizeURL('category/'.  $category->slug)">{{$category->name}}</a>
        </li>
    @endforeach
</ul>
