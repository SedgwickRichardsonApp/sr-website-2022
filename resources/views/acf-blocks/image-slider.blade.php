@php
    
    $images_arr = [];
    if (!empty(($gallery = get_field('gallery'))) && is_array($gallery)) {
        foreach ($gallery as $image) {
            if (!empty($image) && is_array($image)) {
                $ext = pathinfo($image['filename'], PATHINFO_EXTENSION);
                if( $ext !== 'mp4' && $ext !== 'gif' )  {
                    $images_arr[] = $image['sizes']['thumbnails-1800x1000'];
                }else {
                    $images_arr[] = $image['url'];
                }
            }
        }
    }
    
@endphp

<div id="{{ $block_id }}" class="acf-block s-reveal image-slider-block {{ $margin_class }}">
    <div class="content-wrapper">
        @unless(empty($images_arr))
            <div class="image-slider">
                <div class="swiper-container cursor-slider">
                    <div class="swiper-wrapper">
                        @foreach ($images_arr as $image)
                            <div class="swiper-slide">
                              @if (pathinfo($image, PATHINFO_EXTENSION) == 'mp4')
                                    <div class="acf-video-block">
                                      <video 
                                        class="acf-video-player"
                                        src="{{$image}}" 
                                        autoplay
                                        loop
                                        muted
                                        playsinline
                                      >
                                      </video>
                                    </div>
                                  @else
                                <div class="item-image-wrapper">
                                    <img src="{{ $image }}" class="item-image" loading="lazy" decoding="async"
                                        alt="image" />
                                  
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-wrapper">
                        <div class="swiper-button-next cursor-slider"></div>
                        <div class="swiper-button-prev cursor-slider"></div>
                    </div>
                </div>
            </div>
            <div class="images-wrapper">
                <div class="grid grid-cols-1 gap-5">
                    @foreach ($images_arr as $image)
                      @if (pathinfo($image, PATHINFO_EXTENSION) == 'mp4')
                        <div class="acf-video-block">
                          <video 
                            class="acf-video-player"
                            src="{{$image}}" 
                            autoplay
                            loop
                            muted
                            playsinline
                          >
                          </video>
                        </div>
                      @else
                        <div class="item-image-wrapper">
                          <img src="{{ $image }}" class="item-image" loading="lazy" decoding="async"
                              alt="image" />
                        </div>
                      @endif
                    @endforeach
                </div>
            </div>
        @endunless
    </div>
</div>
