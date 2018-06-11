{{--<section class="about-us">--}}
{{--<div class="container">--}}
{{--<div class="header">--}}
{{--<h1 class="title is-size-2 has-text-centered">--}}
{{--{{}}--}}
{{--</h1>--}}
{{--</div>--}}

{{--<div class="content">--}}
{{----}}
{{--</div>--}}
{{--</div>--}}
{{--</section>--}}
<section class="s-content s-content--narrow s-content--no-padding-bottom">

    <article class="row format-standard">

        <div class="s-content__header col-full">
            <h1 class="s-content__header-title">
                {{$article->content->title}}
            </h1>
        </div> <!-- end s-content__header -->

        <div class="col-full s-content__main">
            {!! $article->content->body !!}
        </div> <!-- end s-content__main -->

    </article>

</section> <!-- s-content -->
