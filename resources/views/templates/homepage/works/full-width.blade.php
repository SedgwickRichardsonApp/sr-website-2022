@php

isset( $work ) or $work = [];

@endphp

@unless ( empty( $work ) )
  <section class="tpl-homepage-works-full-width">
    <a href="{{ $work['link'] }}" class="work-item">
      @if( !empty( $work['image'] || $work['use_video']) )
        <div class="work-item-image-wrapper js-header-transparent cursor-view {{$work['cursor_icon']}} s-reveal">
          @if( $work['use_video'] )
            @switch($work['video_format'])
              @case('iframe')
                <div class="acf-video-player iframe">
                  {!! $work['video_iframe'] !!}
                </div>
                @break
              @default
                <video
                  class="acf-video-player"
                  src="{{$work['video_url']}}"
                  autoplay
                  loop
                  muted
                  playsinline
                >
                </video>
            @endswitch
          @endif
          @if ( !$work['use_video'] && !empty($work['image']) )
            <img src="{{ $work['image'] }}"
                class="work-item-image"
                loading="lazy"
                decoding="async"
                alt="{{ $work['title'] }}"
            />
          @endif
        </div>
      @endif

      <div class="work-item-content-wrapper">
        <div class="work-item-title-wrapper s-reveal">
          @unless ( empty( $work['title'] ) )
            <h6 class="work-item-title cursor-link">
              {{ $work['title'] }}
            </h6>
          @endunless

          @unless ( empty( $work['terms'] ) )
            <div class="hidden md:block">
              <ul class="work-item-terms s-reveal cursor-link">
                @foreach ( $work['terms'] as $term )
                  <li class="term-item">
                    {{ $term }}
                  </li>
                @endforeach
              </ul>
            </div>
          @endunless
        </div>

        <div class="work-item-client-name-wrapper">
          @unless ( empty( $work['client_name'] ) )
            <h5 class="work-item-client-name s-reveal cursor-link">
              {{ $work['client_name'] }}
            </h5>
          @endunless

          @unless ( empty( $work['terms'] ) )
            <div class="block md:hidden">
              <ul class="work-item-terms s-reveal cursor-link">
                @foreach ( $work['terms'] as $term )
                  <li class="term-item">
                    {{ $term }}
                  </li>
                @endforeach
              </ul>
            </div>
          @endunless
        </div>
      </div>
    </a>
  </section>
@endunless
