{{--
  Template Name: Expertise
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp

  @include('templates.expertise.hero')
  @include('templates.expertise.content')

  @endwhile
@endsection
