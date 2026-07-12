{{--
  Template Name: Contact
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp

    @include('templates.contact.contact')
{{--    @include('templates.contact.hero')--}}
    @include('templates.contact.intro')
    @include('templates.contact.offices')
{{--    @include('templates.contact.being-sr')--}}
{{--    @include('templates.contact.open-positions')--}}

  @endwhile
@endsection
