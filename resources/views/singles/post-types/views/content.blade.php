<section class="cpt-views-content">
  <div class="container-fluid">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 s-sequence-group">
      <div class="md:col-span-3 lg:col-span-3 mb-8 s-sequenced">
        <div class="content-details-wrapper">
          @unless ( empty( $author['image'] ) )
            <div class="author-image-wrapper">
              <img src="{{ $author['image'] }}"
                   class="author-image"
                   loading="lazy"
                   decoding="async"
                   alt="{{ $author['name'] }}"
              />
            </div>
          @endunless

          <div class="content-details">
            @unless ( empty( $author ) )
              <div class="author">
                @unless ( empty( $author['name'] ) )
                  <div class="author-name">
                    {{ $author['name'] }}
                  </div>
                @endunless

                @unless ( empty( $author['job_title'] ) )
                  <div class="author-job-title">
                    {{ $author['job_title'] }}
                  </div>
                @endunless
              </div>
            @endunless

            <div class="category-wrapper">
              <div class="category">
                @unless ( empty( $details['category'] ) )
                  <span>
                    {{ $details['category'] }}
                  </span>

                  <span>—</span>
                @endunless

                @unless ( empty( $details['reading_time'] ) )
                  <span>
                    {{ $details['reading_time'] }}
                  </span>
                @endunless
              </div>

              @unless ( empty( $details['date'] ) )
                <div class="date">
                  {{ $details['date'] }}
                </div>
              @endunless
            </div>
          </div>
        </div>

        <div class="content-share-links">
          <a href="{{ $details['linkedin_url'] }}" target="_blank" class="social-media-icon icon-linkedin cursor-link">
            <img src="@asset( 'images/socials/linkedin-black.svg' )"
                 loading="lazy"
                 decoding="async"
                 alt="Share on LinkedIn"
            />
          </a>

          @if($language == 'zh')
          <a href="{{ $author['wechat_url'] }}" target="_blank" class="social-media-icon icon-wechat cursor-link">
            <img src="@asset( 'images/socials/wechat-black.svg' )"
                 loading="lazy"
                 decoding="async"
                 alt="WeChat URL"
            />
          </a>
          @endif

          @if($language == 'vi')
          <a href="{{ $details['facebook_url'] }}" target="_blank" class="social-media-icon icon-facebook cursor-link">
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

      <div class="s-sequence-group col-span-1 md:col-span-7 lg:col-span-5 lg:col-start-4 md:col-start-5">
        @unless ( empty( $title ) )
          <h1 class="title s-sequenced">
            {{ $title }}
          </h1>
        @endunless

        <div class="content-wrapper s-sequenced">
          @unless ( empty( $content ) )
            {!! apply_filters( 'the_content', $content ) !!}
          @endunless

          @if ( $restriction_type === 'reveal' )
            {{-- <div class="ellipsis-shadow"></div> --}}
          @endif
        </div>
        <div class="restricted-content"></div>
      </div>
    </div>
  </div>
</section>
