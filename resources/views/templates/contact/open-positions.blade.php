<section id="openPositions" class="tpl-contact-open-positions">
  <div class="container-fluid">
    <div class="content-wrapper">
      <h3 class="section-title">{{ __('Open Positions', 'sage') }}</h3>

      @unless ( empty( $open_positions['positions'] ) )
        <ul class="jobs-list">
        @foreach ($open_positions['positions'] as $position)
          <li class="job-item">
            <a href="" class="jobs-modal-trigger cursor-smile" 
              data-id="{{ $position['id'] }}"
              data-job-title="{{ $position['job'] }}"
              data-location="{{ $position['location'] }}"
              data-job-text="{{ __('in', 'sage') }}"
            >
              <div class="job-detail-wrapper">
                <div class="job-detail-left">
                  <span class="job">{{ $position['job'] }}</span>
                  <span class="work-type">{{ $position['work_type'] }}</span>
                </div>
                <div class="job-detail-right">
                  <span class="location">{{ $position['location'] }}</span>
                  <span class="work-type">{{ $position['work_type'] }}</span>
                </div>
              </div>
            </a>
          </li>
        @endforeach
        </ul>
      @endunless

      <div class="general-contact-wrapper">
        @unless ( empty( $open_positions['general_contact_text'] ) )
          <p class="general-contact-text">{{ $open_positions['general_contact_text'] }}</p>
        @endunless

        @unless ( empty( $open_positions['general_contact_email'] ) )
          <p class="general-contact-email element-desktop">
            <span class="email clipboard cursor-copy-email" data-text="{{ $open_positions['general_contact_email'] }}">{{ $open_positions['general_contact_email'] }}</span>
          </p>
          <p class="general-contact-email element-mobile">
            <a class="email" href="mailto:{{$open_positions['general_contact_email']}}">
              {{ $open_positions['general_contact_email'] }}
            </a>
          </p>
        @endunless

      </div>
    </div>
  </div>
</section>
