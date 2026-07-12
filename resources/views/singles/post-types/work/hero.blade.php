<section class="cpt-work-hero cursor-normal">
  <div class="hero-image-wrapper js-header-transparent">
    @if( !empty( $hero['image'] || !empty($hero['video_url']) ) )
      @if( $hero['use_video'] )
        <div class="acf-video-player hero-image {{ ! empty( $hero['mobile_image'] ) ? 'has-mobile-image' : '' }}">
          @switch($hero['video_format'])
            @case('iframe')
              {!! $hero['video_iframe'] !!}
              @break
            @default
            <video
              class="acf-video-player hero-image {{ ! empty( $hero['mobile_image'] ) ? 'has-mobile-image' : '' }}"
              src="{{$hero['video_url']}}"
              autoplay
              loop
              muted
              playsinline
            >
            </video> 
          @endswitch
        </div>
      @endif
      @if ( empty($hero['video_url']) && !empty($hero['image']) )
        @unless ( empty( $hero['image'] ) )
          <img src="{{ $hero['image'] }}"
              class="hero-image {{ ! empty( $hero['mobile_image'] ) ? 'has-mobile-image' : '' }}"
              loading="lazy"
              decoding="async"
              alt="{{ $title }}"
          />
        @endunless
      @endif
    @endif

    @if( !empty( $hero['mobile_image'] || !empty($hero['use_video_mobile']) ) )
      @if( $hero['use_video_mobile'] )
        <div class="acf-video-player hero-image {{ ! empty( $hero['mobile_image'] ) ? 'has-mobile-image' : '' }}">
          @switch($hero['video_format_mobile'])
            @case('iframe')
              {!! $hero['video_iframe_mobile'] !!}
              @break
            @default
            <video
              class="acf-video-player hero-image {{ ! empty( $hero['mobile_image'] ) ? 'has-mobile-image' : '' }}"
              src="{{$hero['video_url_mobile']}}"
              autoplay
              loop
              muted
              playsinline
            >
            </video> 
          @endswitch
        </div>
      @endif
      @if ( empty($hero['use_video_mobile']) && !empty($hero['mobile_image']) )
        @unless ( empty( $hero['mobile_image'] ) )
          <img src="{{ $hero['mobile_image'] }}"
              class="hero-mobile-image"
              loading="lazy"
              decoding="async"
              alt="{{ $title }}"
          />
        @endunless
      @endif
    @endif
  </div>

  {{-- <div class="hero-content-wrapper">
    <div class="container-fluid">
      <div class="hero-content">
        @unless ( empty( $expertise_and_service_terms ) )
          <ul class="hero-terms">
            @foreach ( $expertise_and_service_terms as $term )
              <li class="term-item">
                {{ $term }}
              </li>
            @endforeach
          </ul>
        @endunless

        <div class="hero-title-wrapper">
          @unless ( empty( $hero['client_name'] ) )
            <h4 class="hero-client-name">
              {{ $hero['client_name'] }}
            </h4>
          @endunless

          @unless ( empty( $title ) )
            <h1 class="hero-title">
              {{ $title }}
            </h1>
          @endunless
        </div>
      </div>
    </div>
  </div> --}}
</section>
