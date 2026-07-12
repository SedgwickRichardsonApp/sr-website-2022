<section class="tpl-homepage-hero js-header-white">
  <div class="container-fluid">
    <div class="content-wrapper">
      @unless ( empty( $hero['heading'] ) )
        <div class="hero-title-wrapper">
          <h1 class="hero-title desktop">
            {{ $hero['heading'] }}
          </h1>
          @if($language == 'vi')
            <h1 class="hero-title mobile">
              {{ $hero['heading'] }}
            </h1>
          @endif

          <div class="hero-subheading desktop">
            {!! $hero['subheading'] !!}
          </div>
        </div>
      @endunless
    </div>
  </div>
</section>
