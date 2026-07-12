<section class="newsletter-section js-header-black " 
        data-background-color="#0a0a10"
        data-text-color="#fff"
>
  <div class="container-fluid">
    <div class="content-wrapper">
      <div class="newsletter-form-wrapper">
        @unless ( empty( $newsletter['title'] ) )
          <h4 class="newsletter-title">
            {!! $newsletter['title'] !!}
          </h4>
        @endunless

        @unless ( empty( $newsletter['form'] ) )
          <div class="newsletter-form">
            {!! $newsletter['form'] !!}

            <button class="submit-button">
              <img src="@asset( 'images/icons/arrow-right-white.svg' )"
                   class="arrow-icon"
                   loading="lazy"
                   decoding="async"
                   alt="Submit"
              />
            </button>
          </div>
        @endunless
      </div>

      <div class="newsletter-cta-wrapper">
        @unless ( empty( $newsletter['cta_small_title'] ) )
          <div class="newsletter-cta-small-title">
            {{ $newsletter['cta_small_title'] }}
          </div>
        @endunless

        @unless ( empty( $newsletter['cta_title'] ) )
          <h2 class="newsletter-cta-title-wrapper">
            <a href="#" class="newsletter-cta-title contact-modal-trigger cursor-link">
              {{ $newsletter['cta_title'] }}
            </a>
          </h2>
        @endunless
      </div>
    </div>
  </div>
</section>
