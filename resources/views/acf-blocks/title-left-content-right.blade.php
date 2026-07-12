@php

$title   = html_entity_decode( get_field( 'title' ) );
$content = get_field( 'content' );

@endphp

<div id="{{ $block_id }}" class="acf-block s-reveal title-left-content-right-block {{ $margin_class }}">
  <div class="container">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-8">
      <div class="col-span-1 md:col-span-5 md:col-start-2">
        @unless ( empty( $title ) )
          <h6 class="title">
            {{ $title }}
          </h6>
        @endunless
      </div>
      <div class="col-span-1 md:col-span-5 md:col-start-7">
        @unless ( empty( $content ) )
          <div class="content">
            {!! apply_filters( 'the_content', $content ) !!}
          </div>
        @endunless
      </div>
    </div>
  </div>
</div>
