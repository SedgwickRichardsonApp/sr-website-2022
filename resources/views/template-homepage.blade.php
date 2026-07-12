{{--
  Template Name: Homepage
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp

  @include('templates.homepage.hero')

  @include('templates.homepage.expertise')

  @include('templates.homepage.works')
 
  <section class="js-header-black s-sequence-group"
    data-background-color="#0A0A10"
    data-text-color="#fff"
  >
    @include('templates.homepage.testimonials')
  </section>

  @include('templates.homepage.clients')

  @include('templates.homepage.contact')

  @include('templates.homepage.views.views-slide')

  @endwhile
@endsection
