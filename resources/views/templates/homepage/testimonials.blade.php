<section class="tpl-homepage-testimonials" data-background-color="#0a0a10">
  <div class="container-fluid">

    <div class="testimonials-section-container s-reveal">
      <div class="testimonials-wrapper">
        <h3 class="testimonials-title">
          {{ __( 'What Our Clients Say About Us', 'sage' ) }}
        </h3>
        @unless ( empty( $testimonials ) )
          <div class="swiper-button-wrapper">
            <button class="swiper-nav-button swiper-nav-prev cursor-link">
              <img alt="prev" src="@asset( 'images/icons/arrow-right-white.svg' )">
            </button>
            <button class="swiper-nav-button swiper-nav-next cursor-link">
              <img alt="next" src="@asset( 'images/icons/arrow-right-white.svg' )">
            </button>
          </div>
        @endunless
      </div>  
      <div class="testimonials-swiper-container">
        <div class="swiper-wrapper comment-wrapper s-revealed">
          @unless ( empty( $testimonials ) )
            @foreach ( $testimonials as $comment )
              <div class="client-comment swiper-slide ">
                <div class="cm-comment">
                  {!! $comment['testimonial'] !!}
                </div>
                <div class="cm-from-wrapper">
                  <span class="cm-client">{{ $comment['client_name'] }}</span>
                  <span class="cm-title">{{ $comment['client_title'] }}</span>
                  <span class="cm-company">{{ $comment['client_company'] }}</span>
                </div>
              </div>
            @endforeach
          @endunless
        </div>
      </div>    
    </div>

  </div>
</section>
