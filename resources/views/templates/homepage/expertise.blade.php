<section class="tpl-homepage-expertise s-reveal " data-background-color="#E4EFF5">
  <div class="container-fluid">

    @unless ( empty( $expertise['title'] ) )
    <div class="expertise-title-container">
      <div class="expertise-title-wrapper">
        <h5 class="expertise-title"> {{ $expertise['title'] }}</h5>
        @unless ( empty( $expertise['title_desc'] ) )<div class='expertise-description'>{{ $expertise['title_desc'] }}</div>@endunless
      </div>

      <div class="expertise-button-wrapper desktop-button">
        <a class="home-contact-button btn cursor-link" href="{{ get_permalink(16)}}">
          <div class="btn-label">
            {{ __( 'Learn More', 'sage' ) }}
          </div>
          <div class="btn-icon">
            <img alt="Learn More" src="@asset( 'images/icons/submit-arrow.png' )">
          </div>
        </a>
      </div>
    </div>

    @endunless

    @unless ( empty( $expertise['items'] ) )
      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-[1.938rem]">
        @foreach ( $expertise['items'] as $key => $item )
          <div class="col-span-1">
            <a href="{{ $item['link'] }}" class="expertise-item cursor-view cursor-xl-{{$item['cursor_icon']}}">
              <div class="expertise-title-wrap">
                @unless ( empty( $item['menu_title'] ) )
                  <div class="expertise-item-icon mobile-icon {{$item['cursor_icon']}}" alt="{{ $item['menu_title'] }} icon"></div>
                  <h4 class="expertise-item-title">
                    {{ $item['menu_title'] }}
                  </h4>
                @endunless
              </div>
                @unless ( empty( $item['descriptions'] ) )
                  <div class="expertise-item-description">
                    @foreach ( $item['descriptions'] as $dkey => $desc )
                      <div>{!! $desc !!}</div>
                    @endforeach
                  </div>
                @endunless
              
            </a>
          </div>
        @endforeach
      </div>

      <div class="expertise-button-wrapper mobile-button">
        <a class="home-contact-button btn cursor-link" href="{{ get_permalink(16)}}">
          <div class="btn-label">
            {{ __( 'Learn More', 'sage' ) }}
          </div>
          <div class="btn-icon">
            <img alt="Learn More" src="@asset( 'images/icons/submit-arrow.png' )">
          </div>
        </a>
      </div>
    @endunless
    
  </div>
</section>
