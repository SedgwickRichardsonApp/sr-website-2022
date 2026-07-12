<section class="tpl-contact-hero js-header-white">
  <div class="container-fluid">
    <div class="content-wrapper">
      @unless ( empty( $hero['hello_words'] ) )
        <div class="hello-words-wrapper"
            data-words="{{ implode( '||', $hero['hello_words'] ) }}">
          <h2 class="hello-word-title"><span></span></h2>
        </div>
      @endunless

{{--      <div class="brief-join-wrapper">--}}
{{--        <div class="brief-us-wrapper">--}}
{{--          @unless ( empty( $hero['brief_us_title'] ) )--}}
{{--            <h5 class="brief-join-title">{{ $hero['brief_us_title'] }}</h5>--}}
{{--          @endunless--}}

{{--          @unless ( empty( $hero['brief_us_link_text'] ) )--}}
{{--            <a class="hero-link cursor-link contact-modal-trigger" href="#">--}}
{{--              <span>{{ $hero['brief_us_link_text'] }}</span>--}}
{{--              <img src="@asset('images/icons/arrow-black.svg')"--}}
{{--                class="hero-link-arrow"--}}
{{--                loading="lazy"--}}
{{--                decoding="async"--}}
{{--                alt="Brief Us">--}}
{{--            </a>--}}
{{--          @endunless--}}
{{--        </div>--}}
{{--        <div class="join-us-wrapper">--}}
{{--          @unless ( empty( $hero['join_us_title'] ) )--}}
{{--            <h5 class="brief-join-title">{{ $hero['join_us_title'] }}</h5>--}}
{{--          @endunless--}}

{{--          @unless ( empty( $hero['join_us_link_text'] ) )--}}
{{--            <a class="hero-link cursor-link goto-scroll" href="#" data-target="openPositions">--}}
{{--              <span>{{ $hero['join_us_link_text'] }}</span>--}}
{{--              <img src="@asset('images/icons/arrow-black.svg')"--}}
{{--                class="hero-link-arrow"--}}
{{--                loading="lazy"--}}
{{--                decoding="async"--}}
{{--                alt="Join Us">--}}
{{--              </a>--}}
{{--          @endunless--}}
{{--        </div>--}}
{{--      </div>--}}

      <div class="hero-images-gallery-wrapper s-reveal">
        @unless ( empty( $hero['hero_images'] ) )
          <div class="swiper-container">
            <div class="swiper-wrapper">
              @foreach ( $hero['hero_images'] as $image )
                <div class="swiper-slide">
                    <img src="{{ $image }}"
                    class="logo-item"
                    loading="lazy"
                    decoding="async"
                    alt="Image">
                </div>
              @endforeach
            </div>
          </div>
        @endunless
      </div>
    </div>
  </div>
</section>
