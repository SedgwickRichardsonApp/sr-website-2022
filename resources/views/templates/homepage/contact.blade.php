<section class="tpl-homepage-contact">
  @unless ( empty( $contact_us['title'] ) )
    <div class="contact-heading">
      {{ $contact_us['title'] }}
    </div>
  @endunless

  <div class="home-contact-button-wrapper">
    <button class="home-contact-button btn cursor-link contact-modal-trigger">
      <div class="btn-label">
        {{ __( 'Contact Us', 'sage' ) }}
      </div>
      <div class="btn-icon">
        <img alt="Contact Us" src="@asset( 'images/icons/submit-arrow.png' )">
      </div>
    </button>
  </div>

</section>