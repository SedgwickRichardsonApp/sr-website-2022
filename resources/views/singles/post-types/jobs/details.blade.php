<section class="cpt-jobs-details">
  <div class="container">
    <div class="jobs-content-wrapper">
      <div class="jobs-meta-wrapper">
        @unless ( empty( $title ) && empty( $details['location'] ) )
          <div class="job-page-header">
            {{ $title.' '.__('in', 'sage').' '.$details['location'] }}
          </div>
        @endunless

        @unless ( empty( $details['location'] ) )
          <div class="location">{{ $details['location'] }}</div>
        @endunless
        
        @unless ( empty( $details['work_type'] ) )
          <div class="working-type">{{ $details['work_type'] }}</div>
        @endunless

        @unless ( empty( $details['date'] ) )
          <div class="pub-date">{{ __( 'Publication date', 'sage') }}: {{ $details['date'] }}</div>
        @endunless
      </div>

      <div class="jobs-description-wrapper">
        <h1 class="page-subtitle">{{ __( 'Work with Us: ', 'sage') }}</h1>  
        @unless ( empty( $title ) )
          <h1 class="page-title">{{ $title }}</h1>  
        @endunless

        @unless ( empty( $content ) )
          <div class="content">
            {!! apply_filters( 'the_content', $content) !!}
          </div>
        @endunless

        @unless ( empty($details['contact_description']) && empty($details['job_contact_email']) )
          <div class="contact-wrapper">
            <div class="contact-description">{{ $details['contact_description'] }}</div>
            <div class="email-container">
              <span class="email cursor-copy-email element-desktop" data-text="{{ $details['job_contact_email'] }}">
                {{$details['job_contact_email']}}
              </span>
              <a class="email cursor-copy-email element-mobile" href="mailto:{{ $details['job_contact_email'] }}">
                {{ $details['job_contact_email'] }}
              </a>
            </div>
          </div>
          @endunless
      </div>
    </div>
  </div>
</section>