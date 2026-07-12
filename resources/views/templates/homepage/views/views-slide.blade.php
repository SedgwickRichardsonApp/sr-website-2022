<section class="tpl-homepage-views">
  <div class="views-group-title-wrapper">
    <div class="views-group-title">
      {{ __( 'Insights', 'sage' ) }}
    </div>
    <a class="views-group-view-all-link btn cursor-link " href="{{ get_permalink(18)}}">
      <div class="btn-label">
        {{ __( 'View all', 'sage' ) }}
      </div>
      <div class="btn-icon">
        <img alt="View all insights" src="@asset( 'images/icons/submit-arrow.png' )">
      </div>
    </a>
  </div>
  
  <div class="container-fluid">
    @unless ( empty( $views ) )
      <div class="swiper-container s-reveal">
        <div class="swiper-wrapper">
          @foreach ( $views as $view )
            <div class="swiper-slide s-sequenced">
              <a href="{{ $view['link'] }}" class="view-item-image-wrapper cursor-slider">
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

        <div class="swiper-button-wrapper">
          <div class="swiper-button-next cursor-slider"></div>
          <div class="swiper-button-prev cursor-slider"></div>
        </div>
        <div class="swiper-scrollbar"></div>
        {{-- <div class="swiper-pagination"></div> --}}
      </div>
    @endunless
  </div>
</section>