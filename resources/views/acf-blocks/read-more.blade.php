@if ( $is_preview )
  <div id="{{ $block_id }}" class="acf-block s-sequenced s-reveal read-more-block" style="background-color: #000; color: #fff; padding: 1rem 0;">
    <div class="container">
      <div style="display: flex; flex-direction: column; align-items: center;">
        <div style="text-transform: uppercase">{{ __( 'Read more', 'sage' ) }}</div>
        <div>{{ __( 'Everything under this block will be hidden until user signs up', 'sage' ) }}</div>
      </div>
    </div>
  </div>
@endif
