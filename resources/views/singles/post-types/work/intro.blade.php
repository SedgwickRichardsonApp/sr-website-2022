<section class="cpt-work-intro cursor-normal">
  <div class="container-fluid">
    {{-- <div class="cpt-intro-top flex gap-5 md:gap-10 s-sequenced "> --}}
      <div class="cpt-intro-top flex md:gap-10 section-custom-colors cursor-normal "
        style="background-color: {{ $intro['background_color'] }}; color: {{ $intro['text_color'] }}"
         data-background-color="{{ $intro['background_color'] }}"
         data-text-color="{{ $intro['text_color'] }}"
      >
      <div class="cpt-intro-left">
        <div class="cpt-intro-general grid grid-cols-2 gap-10 md:gap-8 md:block mb-5 md:mb-8">
          @unless ( empty( $intro['location'] ) )
            <div class="term-wrapper">
              <div class="term-label" style="color: {{ $intro['text_color'] }}">
                {{ __( 'Location', 'sage' ) }}
              </div>
              <div class="term-value">
                {{ $intro['location'] }}
              </div>
            </div>
          @endunless

          @unless ( empty( $intro['sectors'] ) )
            <div class=" ">
              <div class="term-wrapper md:mt-8">
                <div class="term-label" style="color: {{ $intro['text_color'] }}">
                  {{ __( 'Sector', 'sage' ) }}
                </div>

                @foreach ( $intro['sectors'] as $sector )
                  <div class="term-value">
                    {{ $sector }}
                  </div>
                @endforeach
              </div>
            </div>
          @endunless

          @unless ( empty( $expertise_and_service_terms ) )
            <div class="col-span-1 block md:mt-10">
              <div class="term-wrapper">
                @foreach ( $expertise_and_service_terms as $term )
                  <div class="term-value">
                    {{ $term }}
                  </div>
                @endforeach
              </div>
            </div> 
          @endunless
        </div>

        <div class="intro-share-links">
          <a href="{{ $intro['linkedin_url'] }}" target="_blank" class="social-media-icon icon-linkedin cursor-link">
            <img src="@asset( 'images/socials/linkedin-black.svg' )"
                 loading="lazy"
                 decoding="async"
                 alt="Share on LinkedIn"
            />
          </a>

          @if($language == 'zh' && !empty( $social['wechat_url'] ))
          <a href="{{ $social['wechat_url'] }}" target="_blank" class="social-media-icon icon-wechat cursor-link">
            <img src="@asset( 'images/socials/wechat-black.svg' )"
                 loading="lazy"
                 decoding="async"
                 alt="WeChat URL"
            />
          </a>
          @endif

          @if($language == 'vi')
          <a href="{{ $intro['facebook_url'] }}" target="_blank" class="social-media-icon icon-facebook cursor-link">
            <img src="@asset( 'images/socials/fb-black.svg' )"
                 loading="lazy"
                 decoding="async"
                 alt="Share on Facebook"
            />
          </a>
          @endif

          <a class="social-media-icon cursor-link cursor-dot-copy" data-text="{{ esc_url( $permalink ) }}">
            <img src="@asset( 'images/socials/link.svg' )"
                 loading="lazy"
                 decoding="async"
                 alt="URL"
            />
          </a>
        </div>
      </div>
      <div class="cpt-intro-right ">
        @unless ( empty( $intro['client_name'] ) )
          <div class="intro-client-name">{{ $intro['client_name'] }}</div>
        @endunless
        @unless ( empty( $intro['title'] ) )
          <h3 class="mb-0">{{ $intro['title'] }}</h3>
        @endunless

        @unless ( empty( $intro['description'] ) )
          <div class="intro-description mt-10">
            {!! apply_filters( 'the_content', $intro['description'] ) !!}
          </div>
        @endunless
      </div>
    </div>

    <div class="intro-item-container ">
      @unless ( empty( $intro['challenge'] ) )
        <div class="intro-item-wrapper flex gap-5 md:gap-10 ">
          <div class="intro-title intro-challenge">
            {{ __( 'Challenge', 'sage' ) }}
          </div>

          <div class="item-description intro-challenge">
            @unless ( empty( $intro['challenge'] ) )
              {!! $intro['challenge'] !!}
            @endunless
          </div>
        </div>
      @endunless

      @unless ( empty( $intro['solution'] ) )
        <div class="intro-item-wrapper flex gap-5 md:gap-10">
          <div class="intro-title intro-solution">
            {{ __( 'Solution', 'sage' ) }}
          </div>

          <div class="item-description intro-solution">
            @unless ( empty( $intro['solution'] ) )
              {!! $intro['solution'] !!}
            @endunless
          </div>
        </div>
      @endunless

      @unless ( empty( $intro['outcomes'] ) )
        <div class="intro-item-wrapper flex gap-5 md:gap-10">
          <div class="intro-title intro-outcomes">
            {{ __( 'Outcomes', 'sage' ) }}
          </div>

          <div class="item-description intro-outcomes">
            @unless ( empty( $intro['outcomes'] ) )
              {!! $intro['outcomes'] !!}
            @endunless
          </div>
        </div>
      @endunless

      @unless ( empty( $intro['awards'] ) )
        <div class="intro-awards-wrapper intro-item-wrapper flex gap-5 md:gap-10">
          <div class="intro-title">
            {{ __( 'Awards', 'sage' ) }}
          </div>

          <div class="awards-container item-description">
            @foreach ( $intro['awards'] as $award )
              <div class="award-item">
                <div class="award-item-name">
                  @unless ( empty( $award['award_name'] ) )
                    {!! $award['award_name'] !!}
                  @endunless
                </div>
                <div class="award-item-description">
                  @unless ( empty( $award['description'] ) )
                    {!! $award['description'] !!}
                  @endunless
                </div>

                <div class="award-item-location">
                  @unless ( empty( $award['location'] ) )
                    {{ $award['location'] }}
                  @endunless
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endunless
    </div>

  </div>
</section>
