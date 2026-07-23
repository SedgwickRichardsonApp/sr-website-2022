<section class="tpl-expertise-hero js-header-transparent">
  <div class="container-fluid">
    <div class="content-wrapper">
      <div class="hero-title-wrapper {{ $hero['slug'] === 'creating-value' ? 'cursor-link only-one' : ''}}">
        @unless ( empty( $hero['subtitle'] ) )
          <h1 class="hero-subtitle">
            {{ $hero['subtitle'] }}
          </h1>
        @endunless

        @unless ( empty( $hero['title'] ) )
          <h2 class="hero-title">
            {{ $hero['title'] }}
          </h2>
        @endunless
      </div>
      @unless ( empty( $hero['animation_json_file'] ) )
        <lottie-player src="{{ $hero['animation_json_file'] }}"
                      class="hero-animation {{ $hero['slug'] }} {{ ! empty( $hero['mobile_animation_json_file'] ) ? 'has-mobile-animation' : '' }}"
                      mode="normal"
                      autoplay
                      preserveAspectRatio="xMidYMid slice"
        >
        </lottie-player>
      @endunless

      @unless ( empty( $hero['mobile_animation_json_file'] ) )
        <lottie-player src="{{ $hero['mobile_animation_json_file'] }}"
                      class="hero-mobile-animation {{ $hero['slug'] }}"
                      mode="normal"
                      autoplay
                      preserveAspectRatio="xMidYMid slice"
        >
        </lottie-player>
      @endunless
    </div>
  </div>
</section>
