@php
$video_format = get_field('video_format');
$video_url = get_field( 'external_video_url' );
$youtube = get_field( 'youtube_video' );
$video_file = get_field( 'video_file' );
$iframe_video = get_field('iframe_video');

if( !empty($youtube) ){

  // Use preg_match to find iframe src.
  preg_match('/src="(.+?)"/', $youtube, $matches);
  $src = $matches[1];

  // Add extra parameters to src and replace HTML.
  $video_params = array(
      'controls'  => 0,
      'autoplay'  => 1,
      'mute'      => 1,
      'showinfo'  => 0,
      'rel'       => 0,
      'modestbranding' => 1,
      'loop'      => 1,
  );
  $new_src = add_query_arg($video_params, $src);
  $iframe = str_replace($src, $new_src, $youtube);
}


@endphp

<div id="{{ $block_id }}" class="acf-block image-columns-block s-reveal {{ $margin_class }}">
  <div class="acf-video-block">

    @switch($video_format)
      @case('iframe')
        <div class="acf-video-player iframe">
          {!! $iframe_video !!}
        </div>
      @break

      @case( 'local_file')
        <video 
          class="acf-video-player"
          autoplay
          loop
          muted
          playsinline
        >
          <source src="{{$video_file['url']}}"  type="video/mp4">
        </video>
      @break

      @case('url')
        <video 
          class="acf-video-player"
          src="{{$video_url}}" 
          autoplay
          loop
          muted
          playsinline
        >
        </video>
      @break

      @case('youtube')
        {!! apply_filters( 'the_content', $iframe ) !!}
      @break

      @default
        <video 
          class="acf-video-player"
          autoplay
          loop
          muted
          playsinline
        >
          <source src="{{$video_file['url']}}"  type="video/mp4">
        </video>
      @break
    @endswitch

  </div>
</div>
