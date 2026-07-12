<section class="tpl-homepage-clients">
  <div class="container-fluid">
    <div class="content-wrapper">
      <div class="clients-title-wrapper">
        @unless ( empty( $clients['title'] ) )
          <h6 class="clients-title">
            {{ $clients['title'] }}
          </h6>
        @endunless
      </div>
    </div>

    <div class="clients-swiper-wrapper cursor-slider">
      @unless ( empty( $clients['logos'] ) )
        <div class="clients-swiper-container ">
          <div class="swiper-wrapper">
            @foreach (array_chunk($clients['logos'], 10) as $logoChunk)
              <div class="swiper-slide">
                @foreach ($logoChunk as $logo)
                  <img src="{{ $logo }}"
                    class="logo-item"
                    loading="lazy"
                    decoding="async"
                    alt="Client's logo"
                  />
                @endforeach
              </div>
            @endforeach
          </div>
          <div class="swiper-scrollbar"></div>
        </div>
      @endunless
    </div>
  </div>
</section>
