@extends('layouts.app')

@section('styles')
    <style>

    </style>
@endsection

@section('content')

    <section id="main" class="main">
        <div class="sections">

            <section class="s-content">

                <article class="row format-standard">

                    <div class="s-content__header col-full">
                        <h1 class="s-content__header-title">
                            @lang('categories/categories.title')
                        </h1>

                    </div> <!-- end s-content__header -->

                    <div class="col-full">
                    </div> <!-- end s-content__main -->

                </article>
                <section class="section s-extra">
                    @include('categories.list')
                </section>
            </section> <!-- s-content -->

            @include('layouts.footer')

        </div>
    </section>
@endsection