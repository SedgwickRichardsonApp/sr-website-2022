{{--
  Template Name: Coming Soon
--}}

@extends('layouts.app')

@section('content')
<section class="coming-soon-content">
  @unless ( empty($language))
    <div class="coming-container ">
      <div class="whole-page-container">
       
        @if($language == 'vi')
          <a class="home-btn cursor-hover cursor-link btn-vi" href="/"></a>
          <a class="email clipboard cursor-copy-email email-vi element-mobile" href="mailto:saigon@sedgwick-richardson.com"></a>
          <span class="email clipboard cursor-copy-email email-vi element-desktop" data-text="saigon@sedgwick-richardson.com"></span>
        @else
          <a class="home-btn cursor-hover cursor-link btn-zh" href="/"></a>
          <a class="email clipboard cursor-copy-email email-zh element-mobile" href="mailto:hongkong@sedgwick-richardson.com"></a>
          <span class="email clipboard cursor-copy-email email-zh element-desktop" data-text="hongkong@sedgwick-richardson.com"></span>
        @endif

        <img class="page-img page-img-2xl" src="@asset( 'images/coming-soon/coming-lg-'.$language.'.svg' )">
        <img class="page-img page-img-md" src="@asset( 'images/coming-soon/coming-md-'.$language.'.svg' )">
        <img class="page-img page-img-sm" src="@asset( 'images/coming-soon/coming-'.$language.'.svg' )">
      </div>
    </div>
  @endunless
</section>

@endsection
