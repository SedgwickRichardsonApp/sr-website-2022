<section class="tpl-contact-being-sr">
  <div class="container-fluid">
    <div class="content-wrapper">
      <div class="grid grid-cols-1 lg:grid-cols-10 gap-0 lg:gap-0 job-group-row">
        <div class="col-span-1 lg:col-span-6 col-left">
          @unless ( empty( $being_sr['title'] ) )
            <div class="being-sr-title">
              <h5>{!! $being_sr['title'] !!}</h5>
            </div>
          @endunless
          @unless ( empty( $being_sr['description'] ) )
            <div class="desc">
            {!! apply_filters('the_content', $being_sr['description'] ) !!}
            </div>
          @endunless
        </div>
        <div class="col-span-1 lg:col-span-4">
          @unless ( empty( $being_sr['our_values_title'] ) )
            <div class="being-sr-title">
              <h6>{!! $being_sr['our_values_title'] !!}</h6>
            </div>
          @endunless
          @unless ( empty( $being_sr['our_values_description'] ) )
            <div class="desc">
            {!! apply_filters('the_content', $being_sr['our_values_description'] ) !!}
            </div>
          @endunless
        </div>
      </div>
    </div>
  </div>
</section>
