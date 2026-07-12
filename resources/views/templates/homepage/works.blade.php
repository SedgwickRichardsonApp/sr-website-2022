<div class="work-group-title-wrapper">
  <div class="work-group-title">
    {{ __( 'Work', 'sage' ) }}
  </div>
</div>
@unless ( empty( $works ) )
  @if ( array_key_exists( 0, $works ) )
    @include( 'templates.homepage.works.one-column', [ 'works' => [ $works[0] ] ] )
  @endif

  @if ( array_key_exists( 1, $works ) )
    @include( 'templates.homepage.works.two-column', [ 'works' => array_slice( $works, 1, 2 ) ] )
  @endif

  @if ( array_key_exists( 3, $works ) )
    @include( 'templates.homepage.works.two-column', [ 'works' => array_slice( $works, 3, 2 ) ] )
  @endif

  @if ( array_key_exists( 5, $works ) )
    @include( 'templates.homepage.works.two-column', [ 'works' => array_slice( $works, 5, 2 ) ] )
  @endif
@endunless

<div class="view-work-button-wrapper">
  <a class="home-contact-button btn cursor-link" href="{{ get_permalink(12)}}">

    <div class="btn-label">
      {{ __( 'View More Work', 'sage' ) }}
    </div>
    <div class="btn-icon">
      <img alt="View More Work" src="@asset( 'images/icons/submit-arrow.png' )">
    </div>
  </a>
</div>