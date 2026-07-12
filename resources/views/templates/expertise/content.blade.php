<section class="tpl-expertise-content">
  <div class="container-fluid">
    <div class="content-container">
      @unless ( empty( $navigation_items ) )
        <div class="navigation-wrapper desktop-navigation">
          <ul class="navigation-items-wrapper">
            @foreach ( $navigation_items as $item )
              <li class="navigation-item h4">
                <a href="{{ $item['link'] }}" class="navigation-link {{ $item['active'] ? 'active' : '' }} cursor-{{ $item['item_id'] }}">
                  <img src="@asset('images/icons/arrow-active-nav2.svg')"
                       class="navigation-item-icon custom-sticky-menu"
                       loading="lazy"
                       decoding="async"
                       alt="{{ $item['menu_title'] }}"
                  />
                  {{ $item['menu_title'] }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>

        <div class="navigation-wrapper mobile-navigation">
          <ul class="navigation-items-wrapper">
            @foreach ( $navigation_items as $item )
              <li class="navigation-item h4">
                <a href="{{ $item['link'] }}" class="navigation-link {{ $item['active'] ? 'active' : '' }} cursor-{{ $item['item_id'] }}">
                  <img src="@asset('images/icons/arrow-active-nav2.svg')"
                       class="navigation-item-icon custom-sticky-menu"
                       loading="lazy"
                       decoding="async"
                       alt="{{ $item['menu_title'] }}"
                  />
                  {{ $item['menu_title'] }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      @endunless

      <div class="content-wrapper">
        @unless ( empty( $content ) )
          <div class="content">
            {!! apply_filters( 'the_content', $content ) !!}
          </div>
        @endunless

        <div class="expertise-contact-section">
          <h2 class="contact-text">{{ __( 'Ready to show the world why your brand matters?', 'sage' ) }}</h2>
          <div class="expertise-contact-button-wrapper">
            <button class="expertise-contact-button btn cursor-link contact-modal-trigger">
              <div class="btn-label">
                {{ __( 'Get In Touch', 'sage' ) }}
              </div>
              <div class="btn-icon">
                <img alt="Contact Us" src="@asset( 'images/icons/submit-arrow.png' )">
              </div>
            </button>
          </div>
        </div>

        @unless ( empty( $related_works ) )
          <div class="related-works-wrapper">
            <h6 class="related-works-title">
              {{ __( 'Case Studies', 'sage' ) }}
            </h6>
            <div class="swiper-container">
              <div class="swiper-wrapper">
                @foreach ( $related_works as $key => $work)
                  <div class="swiper-slide">
                    <div class="work-item">
                      <a href="{{ $work['link'] }}" class="work-item-image-wrapper cursor-slider ">
                        <img src="{{ $work['image'] }}"
                            class="work-item-image"
                            loading="lazy"
                            decoding="async"
                            alt="{{ $work['title'] }}"
                        />
                      </a>
                      <a href="{{ $work['link'] }}" class="work-item-title-wrapper">
                        @unless ( empty( $work['title'] ) )
                          <div class="work-item-title">
                            {{ $work['title'] }}
                          </div>
                        @endunless

                        {{-- @unless ( empty( $work['client_name'] ) )
                          <div class="work-item-client-name">
                            {{ $work['client_name'] }}
                          </div>
                        @endunless --}}
                      </a>
                    </div>
                  </div>
                @endforeach
                
                <div class="swiper-slide">
                  <div class="work-item">
                    @php  
                      $lang = '/'.$language;
                      if( $lang == '/en' ){ $lang = ''; }
                    @endphp
                    <a href="{{ $lang }}/work/?filter=expertise&term={{$hero['slug']}}" 
                      class="work-item-image-wrapper is-view-all cursor-invert cursor-{{$hero['slug']}}"
                    >
                      <div class="work-item-view-all">
                        <span>{{ __( 'View All', 'sage' ) }}</span>
                        <img src="@asset('images/icons/arrow-right-white.svg')"
                              class="arrow-icon"
                              loading="lazy"
                              decoding="async"
                              alt="View All"
                        />
                      </div>
                    </a>
                  </div>
                </div>

              </div>
              <div class="swiper-button-wrapper">
                <div class="swiper-button-next cursor-slider"></div>
                <div class="swiper-button-prev cursor-slider"></div>
              </div>
            </div>
          </div>
        @endunless


        @unless ( empty( $related_views ) )
          <div class="related-views-wrapper">
            <h6 class="related-works-title">
              {{ __( 'Insights', 'sage' ) }}
            </h6>
            <div class="swiper-container">
              <div class="swiper-wrapper">
                @foreach ( $related_views as $key => $view)
                  <div class="swiper-slide">
                    <div class="work-item">
                      <a href="{{ $view['link'] }}" class="view-item-image-wrapper cursor-slider ">
                        <img src="{{ $view['image'] }}"
                            class="work-item-image"
                            loading="lazy"
                            decoding="async"
                            alt="{{ $view['title'] }}"
                        />
                      </a>
                      <a href="{{ $view['link'] }}" class="work-item-title-wrapper">
                        @unless ( empty( $view['title'] ) )
                          <div class="work-item-title">
                            {{ $view['title'] }}
                          </div>
                        @endunless
                      </a>
                    </div>
                  </div>
                @endforeach

                <div class="swiper-slide">
                  <div class="work-item">
                    <a href="{{ get_permalink(18) }}" 
                      class="view-item-image-wrapper is-view-all cursor-invert cursor-{{$hero['slug']}}"
                    >
                      <div class="work-item-view-all">
                        <span>{{ __( 'View All', 'sage' ) }}</span>
                        <img src="@asset('images/icons/arrow-right-white.svg')"
                            class="arrow-icon"
                            loading="lazy"
                            decoding="async"
                            alt="View All"
                        />
                      </div>
                    </a>
                  </div>
                </div>

              </div>
              <div class="swiper-button-wrapper">
                <div class="swiper-button-next cursor-slider"></div>
                <div class="swiper-button-prev cursor-slider"></div>
              </div>
            </div>
          </div>
        @endunless

        {{-- FAQ Section - Specific position for Expertise pages --}}
        @if(function_exists('sr_faq_display') && function_exists('get_field') && get_field('sr_faq_items'))
          {!! sr_faq_display() !!}
        @endif

        @unless ( empty( $partners ) )
          <div class="partners-wrapper">
            <hr />
            <h6 class="partners-title">
              {{ __( 'Our Partners', 'sage' ) }}
            </h6>
            <div class="partners-grid grid grid-cols-1 sm:grid-cols-2 ">
              @foreach ( $partners as $partner )
                <div class="col-span-1">
                  <div class="partner-item">
                    @if ($partner['link'])
                    <a href="{{ $partner['link'] }}" class="partner-item-image-wrapper cursor-link">
                    @else
                    <a class="partner-item-image-wrapper ">
                    @endif
                      @unless ( empty( $partner['image'] ) )
                        <img src="{{ $partner['image'] }}"
                             class="partner-item-image"
                             loading="lazy"
                             decoding="async"
                             alt="Partner"
                        />
                      @endunless
                    </a>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endunless
      </div>
    </div>
  </div>
</section>
