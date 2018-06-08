@extends('layouts.app')

@section('styles')
    <style>

    </style>
@endsection

@section('content')

    <section id="main" class="main">
        <div class="sections">

            @include('article.article')

            @include('layouts.footer')

        </div>
    </section>
@endsection