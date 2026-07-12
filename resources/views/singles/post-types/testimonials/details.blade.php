<section class="tpl-homepage-testimonials" data-background-color="#0a0a10">
  <div class="container-fluid">

    <div class="testimonials-section-container s-reveal">
      <div class="testimonials-wrapper">
          @unless ( empty( $details ) )
              <div class="client-comment swiper-slide ">
                <div class="cm-comment">
                  {!! $details['testimonial'] !!}
                </div>
                <div class="cm-from-wrapper">
                  <span class="cm-client">{{ $details['client_name'] }}</span>
                  <span class="cm-title">{{ $details['client_title'] }}</span>
                  <span class="cm-company">{{ $details['client_company'] }}</span>
                </div>
              </div>
          @endunless
        </div>
      </div>    
    </div>
</section>
