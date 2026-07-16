{{--
  Template Name: Privacy
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
  <section class="privacy-legal-content">
    <div class="container">
      <h1 class="h3">
        @unless ( empty( $content['page_title'] ) )
        {!! $content['page_title'] !!}
        @endunless
      </h1>

      <div class="content-wrapper">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 lg:gap-7">
          <div class="col-span-1 md:col-span-3">
            @include('templates.privacy.menu')
          </div>

          <div class="col-span-1 lg:col-span-7 lg:col-start-6 terms-content-wrapper">
            @include('templates.privacy.terms')
          </div>
        </div>
      </div>
    
    </div>
  </section>
  @endwhile
@endsection
