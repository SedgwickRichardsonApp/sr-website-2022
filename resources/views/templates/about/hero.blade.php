<section class="tpl-about-hero js-header-black">
  <div class="container-fluid">
    <div class="content-wrapper">
      <div class="hero-title-wrapper">
        @unless ( empty( $hero['title'] ) )
          <h1 class="hero-h1-title">{!! $title !!}</h1>
          <h2 class="hero-title">
            {!! $hero['title'] !!}
          </h2>
        @endunless
      </div>

      @unless ( empty( $hero['animation_json_file'] ) )
        <lottie-player src="{{ $hero['animation_json_file'] }}"
                       class="hero-animation {{ ! empty( $hero['mobile_animation_json_file'] ) ? 'has-mobile-animation' : '' }}"
                       mode="normal"
                       autoplay
                       preserveAspectRatio="xMidYMid"
        >
        </lottie-player>
      @endunless

      @unless ( empty( $hero['mobile_animation_json_file'] ) )
        <lottie-player src="{{ $hero['mobile_animation_json_file'] }}"
                       class="hero-mobile-animation"
                       mode="normal"
                       autoplay
                       preserveAspectRatio="xMidYMid"
        >
        </lottie-player>
      @endunless
    </div>
  </div>
</section>
