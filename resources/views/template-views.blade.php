{{--
  Template Name: Views
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp

  @include('templates.views.page-title')
  @include('templates.views.views-grid')

  @endwhile
@endsection
