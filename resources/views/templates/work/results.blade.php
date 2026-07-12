<section class="tpl-work-results js-header-white">
  <div class="container-fluid">
    @unless ( empty( $title ) )
      <h1 class="title h2">
        {{ $title }}
      </h1>
    @endunless

    <div id="work-taxonomies-filter" class="work-taxonomies-filter-wrapper">
      <div class="work-taxonomies-filter">
        <div class="filter-item {{ $selected_taxonomy === '' ? 'active' : '' }} cursor-link" data-value="">
          <div class="item-name">{{ __( 'Featured', 'sage' ) }}</div>
        </div>

        @unless ( empty( $expertise_terms ) )
          <div class="filter-item expertise {{ $selected_taxonomy === 'expertise' ? 'active' : '' }} cursor-link" data-value="expertise" data-target="#work-expertise-filter">
            <div class="item-name">{{ __( 'Expertise', 'sage' ) }}</div>
          </div>
        @endunless

        @unless ( empty( $sector_terms ) )
          <div class="filter-item sector {{ $selected_taxonomy === 'sector' ? 'active' : '' }} cursor-link" data-value="sector" data-target="#work-sector-filter">
            <div class="item-name">{{ __( 'Sector', 'sage' ) }}</div>
          </div>
        @endunless

        @unless ( empty( $location_terms ) )
          <div class="filter-item location {{ $selected_taxonomy === 'location' ? 'active' : '' }} cursor-link" data-value="location" data-target="#work-location-filter">
            <div class="item-name">{{ __( 'Market', 'sage' ) }}</div>
          </div>
        @endunless
      </div>

      @unless ( empty( $expertise_terms ) )
        <div id="work-expertise-filter" class="filter-item-terms-wrapper expertise" data-value="expertise">
          <div class="filter-item-terms">
            @foreach ( $expertise_terms as $expertise )
              <div class="term-item-wrap">
                <div class="term-item cursor-link {{ $expertise['slug'] }}" data-value="{{ $expertise['slug'] }}" data-parent="expertise">
                  <div class="item-name {{ $selected_term === $expertise['slug'] ? 'active' : '' }}"> {{ $expertise['name'] }} </div>
                </div>
              </div>
              
            @endforeach
          </div>
        </div>
      @endunless

      @unless ( empty( $sector_terms ) )
        <div id="work-sector-filter" class="filter-item-terms-wrapper sector" data-value="sector">
          <div class="filter-item-terms">
            @foreach ( $sector_terms as $sector )
              <div class="term-item-wrap">
                <div class="term-item cursor-link {{ $sector['slug'] }}" data-value="{{ $sector['slug'] }}" data-parent="sector">
                  <div class="item-name {{ $selected_term === $sector['slug'] ? 'active' : '' }}"> {{ $sector['name'] }} </div>
                </div>
              </div>
              
            @endforeach
          </div>
        </div>
      @endunless

      @unless ( empty( $location_terms ) )
      <div id="work-location-filter" class="filter-item-terms-wrapper location" data-value="location">
        <div class="filter-item-terms">
          @foreach ( $location_terms as $location )
            <div class="term-item-wrap">
              <div class="term-item cursor-link {{ $location['slug'] }}" data-value="{{ $location['slug'] }}" data-parent="location">
                <div class="item-name {{ $selected_term === $location['slug'] ? 'active' : '' }}"> {{ $location['name'] }} </div>
              </div>
            </div>
            
          @endforeach
        </div>
      </div>
    @endunless
    </div>

    <div id="works-wrapper"></div>

    <div class="view-more-button-wrapper">
      <a class="view-more-button btn cursor-link" id="view-more-work-button">
        <div class="btn-label">
          {{ __( 'View More Work', 'sage' ) }}
        </div>
        <div class="btn-icon">
          <img alt="View More Work" src="@asset( 'images/icons/submit-arrow.png' )">
        </div>
      </a>
    </div>

  </div>
</section>
