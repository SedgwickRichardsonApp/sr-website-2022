<section class="tpl-contact-intro">
  <div class="container-fluid">
    <div class="content-wrapper">
      <div class="grid grid-cols-1 lg:grid-cols-8 gap-11 lg:gap-0">
        <div class="col-span-1 lg:col-span-3">
          <div class="left">
            @unless ( empty( $intro['title'] ) )
              <h5>{!! $intro['title'] !!}</h5>
            @endunless
          </div>
        </div>
        <div class="col-span-1 lg:col-span-4">
          <div class="right">
            @unless ( empty( $intro['description'] ) )
              {!! $intro['description'] !!}
            @endunless
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
