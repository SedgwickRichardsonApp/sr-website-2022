<footer class="js-header-black black-section "
        data-background-color="#0a0a10"
        data-background="linear-gradient(to bottom, #0a0a10 80%, rgba(10,10,16,0.8))"
        data-text-color="#fff"
>
  <div class="container-fluid">
    <div class="content-wrapper">
      <div class="social-links">
        @unless ( empty( $social['linkedin_url'] ) )
          <a href="{{ $social['linkedin_url'] }}"
             class="social-link-item social-linkedin cursor-link"
             target="_blank"
          >
            <img src="@asset( 'images/socials/linkedin-white.svg' )"
                 loading="lazy"
                 decoding="async"
                 alt="LinkedIn"
            />
          </a>
        @endunless

        @if($language == 'zh' && !empty( $social['wechat_url'] ))
          <a href="{{ $social['wechat_url'] }}"
            class="social-link-item social-wechat cursor-link"
            target="_blank"
          >
            <img src="@asset( 'images/socials/wechat.svg' )"
                loading="lazy"
                decoding="async"
                alt="WeChat"
            />
          </a>
        @endif

        @if($language == 'vi' && !empty( $social['facebook_url'] ) )
          <a href="{{ $social['facebook_url'] }}"
            class="social-link-item social-fb cursor-link"
            target="_blank"
          >
            <img src="@asset( 'images/socials/fb.svg' )"
                loading="lazy"
                decoding="async"
                alt="Facebook"
            />
          </a>
        @endif
      </div>

      <div class="logos">
        <img src="@asset( 'images/footer/compact-program.png' )"
             class="logo-item"
             loading="lazy"
             decoding="async"
             alt="UN Global Compact Program"
        />
      </div>
    </div>
  </div>
  <div class="footer-copyright">
    <div class="container-fluid">
      <div class="copyright-wrapper">
        <div class="tagline">
          {{-- {{ __( 'Build belief in the future', 'sage' ) }} ™ --}}
        </div>
        <div class="copyright">
          © 1985-{{ date( 'Y' ) }} {{ __( 'Sedgwick Richardson', 'sage' ) }}
        </div>

        <div class="menu-wrapper">
          @if ( has_nav_menu( 'footer_navigation' ) )
            {!!
              wp_nav_menu( [
                'theme_location' => 'footer_navigation',
                'container'      => false,
                'menu_class'     => 'menu',
              ] )
            !!}
          @endif
        </div>
      </div>
    </div>
  </div>
</footer>
<?php wp_enqueue_style( 'custom-design' ); ?>