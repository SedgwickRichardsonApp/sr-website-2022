<section class="cpt-work-testimonial">
  <div class="container-fluid">
   
    @unless ( empty( $related_testimonial ) )
    <div class="related-testimonial-container s-reveal">
      <div class="testimonials-wrapper">
        <h3 class="testimonials-title">
          {{ __( 'What Our Clients Say About Us', 'sage' ) }}
        </h3>
      </div>  

      <div class=" comment-wrapper s-revealed">
        <div class="client-comment ">
          <div class="cm-comment">
            @unless (empty($related_testimonial['testimonial']))
            {!! $related_testimonial['testimonial'] !!}
            @endunless
          </div>
          <div class="cm-from-wrapper">
            @unless(empty($related_testimonial['client_name']))
              <span class="cm-client">{{ $related_testimonial['client_name'] }}</span>
            @endunless
            @unless(empty($related_testimonial['client_title']))
              <span class="cm-title">{{ $related_testimonial['client_title'] }}</span>
            @endunless
            @unless(empty($related_testimonial['client_company']))
              <span class="cm-company">{{ $related_testimonial['client_company'] }}</span>
            @endunless
          </div>
        </div>
      </div>

    </div>
    @endunless

  </div>
</section>
