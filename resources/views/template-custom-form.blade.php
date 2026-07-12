{{--
  Template Name: Custom Form
--}}

@extends('layouts.app')

@section('content')
  <section class="custom-form-content">
    <div class="container">

      <div class="content-wrapper">
  
      <div class="custom-form-wrapper cf-show">
        <div class="grid grid-cols-1 lg:grid-cols-8 gap-11 lg:gap-0">
          <div class="col-span-1 lg:col-span-4">
            @unless ( empty( $custom_form['heading'] ) )
              <h2 class="custom-form-heading">
                {!! $custom_form['heading'] !!}
              </h2>
            @endunless
            @unless ( empty( $custom_form['subheading'] ) )
              <p class="custom-form-subheading">
                {!! $custom_form['subheading'] !!}
              </p>
            @endunless
          </div>

          <div class="col-span-1 lg:col-span-3 ">
            @unless ( empty( $custom_form['form'] ) )
              <div class="custom-form-element">
                {!! $custom_form['form'] !!}

                <div class="submit-button-wrapper">
                  <button class="submit-button btn cursor-link">
                    <div class="btn-label">
                      {{ __( 'Submit', 'sage' ) }}
                    </div>
                    <div class="btn-icon">
                      <img alt="Submit" src="@asset( 'images/icons/submit-arrow.png' )">
                    </div>
                  </button>
                </div>
              </div>
            @endunless
          </div>
        </div>
      </div>

      <div class="custom-form-thank-you cf-hide">
        @unless ( empty( $custom_form['thank_you_message'] ) )
          <h2 class="custom-form-thank-you-message">
            {!! $custom_form['thank_you_message'] !!}
          </h2>
        @endunless

        <div class="home-button-wrapper">
          <a href="{{ home_url() }}" class="home-button btn cursor-link">
            <div class="btn-label">
              {{ __( 'Back to home', 'sage' ) }}
            </div>
            <div class="btn-icon">
              <img alt="Back to home" src="@asset( 'images/icons/submit-arrow.png' )">
            </div>
          </a>
        </div>
      </div>

    </div>

  </section>
@endsection
