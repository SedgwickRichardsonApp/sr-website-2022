<section class="tpl-about-intro">
  <div class="container-fluid">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 md:gap-8 s-sequence-group">
      <div class="col-span-1">
        @unless ( empty( $intro['title'] ) )
          <div class="intro-title s-sequenced">
            {!! $intro['title'] !!}
          </div>
        @endunless
      </div>
      <div class="col-span-1">
        @unless ( empty( $content ) )
          <div class="intro-content s-sequenced">
            {!! apply_filters( 'the_content', $content ) !!}
          </div>
        @endunless
      </div>
    </div>
  </div>
</section>
