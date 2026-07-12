{{--
Template Name: Careers
--}}

@extends('layouts.app')

@section('content')
@while(have_posts()) @php the_post() @endphp

@include('templates.careers.hero')
@include('templates.careers.being-sr')
@include('templates.careers.open-positions')

@endwhile
@endsection
