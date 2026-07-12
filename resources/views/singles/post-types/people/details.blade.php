<section class="cpt-people-details section-custom-colors">
  <div class="container">
    <div class="people-content-wrapper">
      <div class="people-meta-wrapper">
        <div class="meta-text-wrapper">
          <div class="profile-text">{!! __('Profile', 'sage') !!}</div>

          @unless ( empty( $details['location'] ) )
            <div class="people">{{ $details['location'] }}</div>
          @endunless
          @unless ( empty( $details['working_since'] ) )
            <div class="working-since">{{ $details['working_since'] }}</div>
          @endunless
        </div>
      </div>

      <div class="people-data-container">
        <div class="people-image-wrapper">
          @unless ( empty( $details['image'] ) )
          <img src="{{ $details['image'] }}"
            loading="lazy"
            decoding="async"
            alt="{{ $title }}">
            @endunless
        </div>
    
        <div class="people-description-wrapper">
          @unless ( empty( $title ) )
            <h1 class="page-title">{{ $title }}</h1>
          @endunless
  
          @unless ( empty( $details['position'] ) )
            <h6 class="people-position">{{ $details['position'] }}</h6>
          @endunless
  
          @unless ( empty( $content ) )
            <div class="content">
              {!! apply_filters('the_content', $content) !!}
            </div>
          @endunless
  
          <div class="social-media-link-wrapper">
            @unless ( empty( $details['linkedin_url'] ) )
              <a href="{{ $details['linkedin_url'] }}" class="linkedin cursor-link" target="_blank">
                <span class="linkedin-logo sm-logo">
                  <img src="@asset( 'images/socials/linkedin-black.svg' )" />
                </span>
                <span class="social-text">
                  {{ __( 'Add me on LinkedIn', 'sage' ) }}
                </span>
              </a>
            @endunless
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
