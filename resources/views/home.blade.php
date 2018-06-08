@extends('layouts.app')

@section('content')
    <section id="main" class="main container">
        <div class="sections">
            @include('home.main')

            @include('home.articles')

            {{--@include('home.services')--}}

            {{--@include('home.references')--}}

            {{--@include('home.contact-us')--}}

            @include('layouts.footer')
        </div>
    </section>
@endsection