<section id="openPositions" class="tpl-contact-open-positions">
  <div class="container-fluid">
    <div class="content-wrapper">
      {{--<h3 class="section-title">{{ __('Open Positions', 'sage') }}</h3> --}}

      @if ( !empty($open_positions['position_groups']) )

        <div class="jobs-container">

          {{-- 2. 外层循环：遍历每一个地点分组 --}}
          @foreach ($open_positions['position_groups'] as $group)

            <div class="grid grid-cols-1 lg:grid-cols-10 gap-0 lg:gap-0 job-group-row">

              <div class="col-span-1 lg:col-span-6 group-left">
                {{-- 对应 dump 中的 ["location"] => "Hong Kong" --}}
                <h2 class="location-title">
                  {{ $group['location'] }}
                </h2>
              </div>

              <div class="col-span-1 lg:col-span-4 group-right">

                  {{-- 3. 内层循环：对应 dump 中的 ["list"] --}}
                  @foreach ($group['list'] as $item)
                    <div class="job-item">

                      {{-- 对应 dump 中的 ["id"] 和 ["job_title"] --}}
                      <a href="#" class="jobs-modal-trigger cursor-smile"
                         data-id="{{ $item['id'] }}"
                         data-location="{{ $group['location'] }}"
                         data-job-text="{{ __('in', 'sage') }}"
                         data-job-title="{{ $item['job_title'] }}">
                          <img src="@asset('images/icons/arrow-active-nav2.svg')"
                            class="navigation-item-icon custom-sticky-menu"
                            loading="lazy"
                            decoding="async"
                            alt="{{ $item['job_title'] }}" />
                           <span class="job-name">
                               {{ $item['job_title'] }}
                           </span>

                        {{-- 对应 dump 中的 ["work_type"]
                        <span class="work-type" style="color: #666;">
                               {{ $item['work_type'] }}
                           </span> --}}
                      </a>

                    </div>
                  @endforeach

              </div>

            </div>
          @endforeach

        </div>
      @endif

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
