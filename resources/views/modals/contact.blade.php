<div class="right-side-modal contact-modal">
  <div class="modal-overlay"></div>
  <div class="modal-content">
    <div class="modal-close contact-modal-close cursor-link">
      <div class="label">
        {{ __( 'Close', 'sage' ) }}
      </div>
      <div class="icon">
        @asset_svg('images/icons/close.svg')
      </div>
    </div>

    <div class="contact-form-wrapper">
      <div class="grid grid-cols-1 lg:grid-cols-8 gap-11 lg:gap-0">
        <div class="col-span-1 lg:col-span-4">
          @unless ( empty( $contact['title'] ) )
            <h2 class="contact-title">
              {!! $contact['title'] !!}
            </h2>
          @endunless
        </div>

        <div class="col-span-1 lg:col-span-3 ">
          @unless ( empty( $contact['form'] ) )
            <div class="contact-form">
              {!! $contact['form'] !!}

              <div class="submit-button-wrapper">
                <button class="submit-button btn cursor-link">
                  <div class="btn-label">
                    {{ __( 'Submit', 'sage' ) }}
                  </div>
                  <div class="btn-icon">
                    <img alt="Submit" src="@asset( 'images/icons/submit-arrow.png' )">
                  </div>
                </button>
              </div>
            </div>
          @endunless
        </div>
      </div>
    </div>

    <div class="contact-thank-you" style="display: none;">
      @unless ( empty( $contact['thank_you_message'] ) )
        <h2 class="contact-thank-you-message">
          {!! $contact['thank_you_message'] !!}
        </h2>
      @endunless

      <div class="home-button-wrapper">
        <a href="{{ home_url() }}" class="home-button btn cursor-link">
          <div class="btn-label">
            {{ __( 'Back to home', 'sage' ) }}
          </div>
          <div class="btn-icon">
            <img alt="Back to home" src="@asset( 'images/icons/submit-arrow.png' )">
          </div>
        </a>
      </div>
    </div>
  </div>
</div>
