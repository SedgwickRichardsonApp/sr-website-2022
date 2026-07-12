<section class="cpt-work-image-grid">
  <div class="container-fluid">
   
    @unless ( empty( $work_image_grid ) )
    <div class="image-grid-container s-reveal">
      <div class="image-grid-wrapper">
        @foreach ( $work_image_grid as $key => $image )
        @if ($image['type'] === 'video') 
          <video 
            class="acf-video-player image-wrap g-wrap-{{$key}}"
            autoplay
            loop
            muted
            playsinline
          >
            <source src="{{$image['url']}}"  type="video/mp4">
          </video>
        @else 
          <div class="image-wrap g-wrap-{{$key}}">
            <img src="{{ $image['url'] }}"
                class="grid-image g-image-{{$key}}"
                loading="lazy"
                decoding="async"
                alt="image"
            />
          </div>
        @endif
          
        @endforeach
      </div>
    </div>
    @endunless

  </div>
</section>
