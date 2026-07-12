<section class="tpl-contact-being-sr">
  <div class="container-fluid">
    <div class="content-wrapper">
      <div class="left">
        @unless ( empty( $being_sr['title'] ) )
          <h5>{!! $being_sr['title'] !!}</h5>
        @endunless
      </div>
      <div class="right">
        @unless ( empty( $being_sr['description'] ) )
          {!! apply_filters('the_content', $being_sr['description'] ) !!}
        @endunless
      </div>
    </div>
  </div>
</section>