@extends('layouts.app')

@section('content')
  <section class="four-zero-four-content cursor-sad">
    <div class="container">

      <img class="page-title" src="@asset( 'images/404.png' )" />
      <div class="content-wrapper">
        <div class="white-space"></div>

        <div class="text-wrapper">
          <span class="sad-face-wrapper">@asset_svg( 'images/icons/sad-face.svg' )</span>
          <h5 class="sorry-text">{{ __( 'Sorry. The page you’re looking for isn’t available.', 'sage' ) }}</h5>
          <a class="btn cursor-hover cursor-link" href="{{ get_home_url() }}">
            {{ __( 'Back to home', 'sage' ) }}
            <span class="btn-icon">
              <img alt="Back to home" src="@asset( 'images/icons/submit-arrow.png' )">
            </span>
          </a>
          <p class="contact-text">
            {{ __( 'Still a problem? Please contact us at:', 'sage' ) }}
            <br />
            <span class="email clipboard cursor-copy-email underline element-desktop" data-text="{{ $page_contact['404_email'] }}">{{ $page_contact['404_email'] }}</span>
            <a class="email clipboard cursor-copy-email underline element-mobile" href="{{ $page_contact['404_email'] }}">{{ $page_contact['404_email'] }}</a>
          </p>
        </div>
      </div>
      
    </div>
  </section>
@endsection
