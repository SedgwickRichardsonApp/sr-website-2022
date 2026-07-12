{{--
  Template Name: About
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp

    @include('templates.about.hero')
    @include('templates.about.intro')
    @include('templates.about.team')

  @endwhile
@endsection
