@php

$width           = get_field( 'width' );
$columns         = get_field( 'columns' );
$video_url       = get_field( 'video_url' );
$container_class = '';
$grid_class      = '';
$column_class    = '';
$image_size      = '';
$images_arr      = [];

if ( $width === 'max' ) {
  $container_class = 'max-block';
  $grid_class   = '';
  $column_class = '';
}

if ( $width === 'full' ) {
  $container_class = 'container-fluid';

  if ( $columns === '1' ) {
    $grid_class   = 'grid-cols-1 gap-y-8';
    $column_class = 'col-span-1';
  } elseif ( $columns === '2' ) {
    $grid_class   = 'grid-cols-1 md:grid-cols-2 gap-5 md:gap-8';
    $column_class = 'col-span-1';
    $image_size   = 'thumbnails-1400x1300';
  }
} elseif ( $width === 'container' ) {
  $container_class = 'container';

  if ( $columns === '1' ) {
    $grid_class   = 'grid-cols-1 md:grid-cols-12 gap-y-8';
    $column_class = 'col-span-1 md:col-span-10 md:col-start-2';
  } elseif ( $columns === '2' ) {
    $grid_class   = 'grid-cols-1 md:grid-cols-2 gap-5 md:gap-8';
    $column_class = 'col-span-1';
    $image_size   = 'thumbnails-1400x1300';
  }
}

if ( ! empty( $gallery = get_field( 'gallery' ) ) && is_array( $gallery ) ) {
  foreach ( $gallery as $image ) {
    if ( ! empty( $image ) && is_array( $image ) ) {
      $ext = pathinfo($image['filename'], PATHINFO_EXTENSION);
      if ( ! empty( $image_size ) && ( $ext !== 'mp4' && $ext !== 'gif' ) ) {
        $images_arr[] = $image['sizes'][ $image_size ];
      } else {
        $images_arr[] = $image['url'];
      }
    }
  }
}

if( !empty($video_url) ){
  // Add extra parameters to src and replace HTML.
  $video_params = array(
      'hd'        => 1,
      'autohide'  => 1,
      'autoplay'  => 1,
  );
}
@endphp

<div id="{{ $block_id }}" class="acf-block image-columns-block s-reveal {{ $margin_class }}">
  <div class="{{ $container_class }}">
    @unless ( empty( $images_arr ) )
      <div class="grid {{ $grid_class }}">
        @foreach ( $images_arr as $image )
          <div class="{{ $column_class }}">
            @if (pathinfo($image, PATHINFO_EXTENSION) == 'mp4')
              <div class="acf-video-block">
                <video 
                  class="acf-video-player"
                  src="{{$image}}" 
                  autoplay
                  loop
                  muted
                  playsinline
                >
                </video>
              </div>
            @else
              <div class="image-wrapper">
                <img src="{{ $image }}"
                    class="image"
                    loading="lazy"
                    decoding="async"
                    alt="image"
                />  
              </div>
            @endif
          </div>
        @endforeach
      </div>
    @endunless

    @unless ( empty( $video_url ) )
    <div class="grid {{ $grid_class }}">
      <div class="{{ $column_class }}">
        <div class="acf-video-block">
          <video 
            class="acf-video-player"
            src="{{$video_url}}" 
            autoplay
            loop
            muted
            playsinline
          >
          </video>
        </div>
      </div>
    </div>
    @endunless

  </div>
</div>
