<? $siteURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>
<section class="mobile-menu">
  <div class="mobile-menu-wrapper">
    <div class="menu-header">
      <div class="logo-wrapper">
        <a class="logo-link" href="{{ home_url() }}">
          <img src="@asset( 'images/logo-black.svg' )"
                class="logo logo-black cursor-link"
                loading="lazy"
                decoding="async"
                alt="Sedgwick Richardson"
          />
          <img src="@asset( 'images/logo-white-red.svg' )"
                class="logo logo-white cursor-link"
                loading="lazy"
                decoding="async"
                alt="Sedgwick Richardson"
          />
        </a>
      </div>
      <div class="mobile-hamburger hamburger ">
        <div></div>
        <div></div>
      </div>
    </div>

    <div class="menu-wrapper">
      <div class="nav-menu">
        @if ( has_nav_menu( 'primary_navigation' ) )
          {!!
            wp_nav_menu( [
              'theme_location' => 'primary_navigation',
              'menu'           => 'main-menu',
              'container'      => false,
              'menu_class'     => 'menu-list',
            ] )
          !!}
        @endif

        <div class="menu-item menu-item-search">
          <a href="#" class="search-modal-trigger">{{ __( 'Search', 'sage' ) }}</a>
        </div>

        @unless ( empty( $languages ) )
          <div class="languages">
            @foreach ( $languages as $language )
              <a href="{{ $language['url'] }}">
                {{ $language['label'] }}
              </a>
            @endforeach
          </div>
        @endunless
      </div>

      <div class="menu-inquiries">
        @unless ( empty( $newsletter['cta_small_title'] ) )
          <h6 class="text-xs mb-2">
            {{ $newsletter['cta_small_title'] }}
          </h6>
        @endunless

        @unless ( empty( $newsletter['cta_title'] ) )
          <h4 class="mb-0">
            <a href="#" class="contact-modal-trigger cursor-link">
              {{ $newsletter['cta_title'] }}
            </a>
          </h4>
        @endunless
      </div>
    </div>
  </div>
</section>

<header class="header">
  <div class="container-fluid">
    <div class="content-wrapper">
      <div class="logo-wrapper">
        <a class="logo-link" href="{{ home_url() }}">
          <img src="@asset( 'images/logo-black-3.gif' )"
               class="logo logo-black cursor-link"
               loading="lazy"
               decoding="async"
               alt="Sedgwick Richardson"
          />
          <img src="@asset( 'images/logo-white-3.gif' )"
               class="logo logo-white cursor-link"
               loading="lazy"
               decoding="async"
               alt="Sedgwick Richardson"
          />
        </a>
      </div>

      <div class="menu-wrapper">
        <div class="menu">
          @if ( has_nav_menu( 'primary_navigation' ) )
            {!!
              wp_nav_menu( [
                'theme_location' => 'primary_navigation',
                'menu'           => 'main-menu',
                'container'      => false,
                'menu_class'     => 'menu-list',
              ] )
            !!}
          @endif

          <a href="#" class="menu-item-search">
            {{ __( 'Search', 'sage' ) }}
          </a>

          <div class="menu-inquiries">
            @unless ( empty( $newsletter['cta_small_title'] ) )
              <h6 class="text-xs mb-2">
                {{ $newsletter['cta_small_title'] }}
              </h6>
            @endunless

            @unless ( empty( $newsletter['cta_title'] ) )
              <h4 class="mb-0">
                <a href="#" class="contact-modal-trigger cursor-link">
                  {{ $newsletter['cta_title'] }}
                </a>
              </h4>
            @endunless
          </div>
        </div>

        <div class="search-icon cursor-link search-modal-trigger">
          @asset_svg( 'images/icons/search.svg' )
        </div>

        @unless ( empty( $languages ) )
          <div class="language-selector cursor-link">
            @foreach ( $languages as $language )
              @if ( $language['active'] )
                <div class="active">
                  <span>{{ $language['label'] }}</span>
                </div>
              @endif
            @endforeach

            <ul class="dropdown">
              @foreach ( $languages as $language )
                @if ( ! $language['active'] )
                  <li class="language-item">
                    <a href="{{ $language['url'] }}">
                      {{ $language['label'] }}
                    </a>
                  </li>
                @endif
              @endforeach
            </ul>
          </div>
        @endunless

        <div class="hamburger">
          <div></div>
          <div></div>
        </div>
      </div>
    </div>
  </div>
  {{-- <div class="subnav-container container-fluid"></div> --}}
</header>
