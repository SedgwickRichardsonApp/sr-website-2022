@unless ( empty( $works ) )
  @if ( array_key_exists( 0, $works ) )
    @include( 'templates.homepage.works.full-width', [ 'work' => $works[0] ] )
  @endif

  @if ( array_key_exists( 1, $works ) )
    @include( 'templates.homepage.works.one-column', [ 'works' => [ $works[1] ] ] )
  @endif

  @if ( array_key_exists( 2, $works ) )
    @include( 'templates.homepage.works.full-width', [ 'work' => $works[2] ] )
  @endif

  @if ( array_key_exists( 3, $works ) )
    @include( 'templates.homepage.works.one-column', [ 'works' => [ $works[3] ] ] )
  @endif

  @if ( array_key_exists( 4, $works ) )
    @include( 'templates.homepage.works.two-column', [ 'works' => array_slice( $works, 4, 2 ) ] )
  @endif
@endunless

@unless ( empty( $views ) )
  @include( 'templates.homepage.views.three-column' )
@endunless

@unless ( empty( $works ) )
  @if ( array_key_exists( 6, $works ) )
    @include( 'templates.homepage.works.two-column', [ 'works' => array_slice( $works, 6, 2 ) ] )
  @endif

  @if ( array_key_exists( 8, $works ) )
    @include( 'templates.homepage.works.full-width', [ 'work' => $works[8] ] )
  @endif
@endunless
