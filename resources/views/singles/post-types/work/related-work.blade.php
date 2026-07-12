@unless ( empty( $related_work ) )
  <section class="cpt-work-related-work js-header-transparent">
    <a href="{{ $related_work['link'] }}" class="banner-work-link ">
      @unless ( empty( $related_work['image'] ) )
        <div class="related-work-image-wrap">
          <img src="{{ $related_work['image'] }}"
              class="related-work-image"
              loading="lazy"
              decoding="async"
              alt="{{ $related_work['title'] }}"
          />
        </div>
      @endunless

      <div class="related-work-content-wrapper">
        <div class="container">
          <div class="related-work-content cursor-link">
            
            <h5 class="link-subtitle">
              {{ __( 'View next case study', 'sage' ) }}
            </h5>

            @unless ( empty( $related_work['title'] ) )
              <h4 class="link-title">
                {{ $related_work['title'] }}
              </h4>
            @endunless

            @unless ( empty( $related_work['client_name'] ) )
              <div class="link-client-name">
                {{ $related_work['client_name'] }}
              </div>
            @endunless
          
          </div>
        </div>
      </div>
    </a>
  </section>
@endunless
