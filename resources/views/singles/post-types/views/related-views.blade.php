<section class="cpt-views-related-views" style="display: {{ in_array( $restriction_type, [ 'pdf_file_request', 'pdf_file_auto_response', 'reveal' ] ) ? 'none' : 'block' }};">
  <div class="container-fluid">
    @unless ( empty( $related_views ) )
      <h6 class="section-title">{{ __( 'More Views', 'sage' ) }}</h6>

      <div class="related-views-wrapper grid grid-cols-3 gap-10">
        @foreach ( $related_views as $view )
          <div class="col-span-1">
            <div class="view-item">
              <a href="{{ $view['link'] }}" class="view-item-image-wrapper mb-4 block">
                @unless ( empty( $view['image'] ) )
                  <img src="{{ $view['image'] }}"
                       class="view-item-image"
                       loading="lazy"
                       decoding="async"
                       alt="{{$view['title']}}"
                  />
                @endunless
              </a>

              @unless ( empty( $view['title'] ) )
                <a href="{{ $view['link'] }}"  class="view-item-title-wrapper cursor-link">
                  <h5 class="h7 view-item-title">{{ $view['title'] }}</h5>
                </a>
              @endunless
            </div>
          </div>
        @endforeach
      </div>
    @endunless
  </div>
</section>
