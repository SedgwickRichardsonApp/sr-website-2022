@php

isset( $works ) or $works = [];

@endphp

@unless ( empty( $works ) )
  <section class="tpl-homepage-works-one-column s-sequence-group">
    <div class="container-fluid">
      <div class="grid grid-cols-1 md:grid-cols-12">
        @foreach ( $works as $work )
          <div class="col-span-1 md:col-span-12">
            <a href="{{ $work['link'] }}" class="work-item">
              @if( !empty( $work['image'] || !empty($work['use_video']) ) )
                <div class="work-item-image-wrapper cursor-view {{$work['cursor_icon']}} s-sequenced">
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
                <div class="work-item-client-name-wrapper">
                  @unless ( empty( $work['client_name'] ) )
                    <h5 class="work-item-client-name cursor-link">
                      {{ $work['client_name'] }}
                    </h5>
                  @endunless
                  @unless ( empty( $work['title'] ) )
                    <h6 class="work-item-title cursor-link">
                      {{ $work['title'] }}
                    </h6>
                  @endunless
                  {{-- @unless ( empty( $work['terms'] ) )
                    <div class="block md:hidden">
                      <ul class="work-item-terms cursor-link">
                        @foreach ( $work['terms'] as $term )
                          <li class="term-item">
                            {{ $term }}
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  @endunless --}}
                </div>
                {{-- <div class="work-item-title-wrapper">
                  @unless ( empty( $work['title'] ) )
                    <h6 class="work-item-title cursor-link">
                      {{ $work['title'] }}
                    </h6>
                  @endunless

                  @unless ( empty( $work['terms'] ) )
                    <div class="hidden md:block">
                      <ul class="work-item-terms cursor-link">
                        @foreach ( $work['terms'] as $term )
                          <li class="term-item">
                            {{ $term }}
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  @endunless
                </div> --}}

              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endunless
