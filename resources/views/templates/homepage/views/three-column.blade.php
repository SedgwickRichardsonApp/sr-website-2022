@unless ( empty( $views ) )
  <section class="tpl-homepage-views-three-column s-sequence-group">
    <div class="container-fluid">
      <div class="grid grid-cols-1 gap-11 md:grid-cols-3 md:gap-10 ">
        @foreach ( $views as $view )
          <div class="col-span-1 s-sequenced">
            <a href="{{ $view['link'] }}" class="view-item-image-wrapper cursor-view">
              @if( $view['use_video'] )
                @switch($view['video_format'])
                  @case('iframe')
                    <div class="acf-video-player iframe">
                      {!! $view['video_iframe'] !!}
                    </div>
                    @break
                  @default
                  <video
                    class="acf-video-player"
                    src="{{$view['video_url']}}"
                    autoplay
                    loop
                    muted
                    playsinline
                  >
                  </video> 
                @endswitch
              @endif
              @if ( !$view['use_video'] && !empty($view['image']) )
                <img src="{{ $view['image'] }}"
                  class="view-item-image "
                  loading="lazy"
                  decoding="async"
                  alt="{{ $view['title'] }}"
                />
              @endif
            </a>
            
            @unless ( empty( $view['title'] ) )
              <a href="{{ $view['link'] }}" class="view-item-title-wrapper cursor-link">
                <h5 class="view-item-title">
                  {{ $view['title'] }}
                </h5>
              </a>
            @endunless
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endunless
