<section class="tpl-views-grid">
  <div class="container-fluid">
    <div class="tabs">
      <div class="categories-tab-wrapper">
        <ul id="tabs-wrapper" class="tab-header">
          <li class="tab-item cursor-link {{ empty( $selected_category ) ? 'active' : '' }} tab-all-item" data-target="">
            <div>{{ __( 'All', 'sage' ) }}</div>
          </li>
          @unless ( empty( $category_terms ) )
            @foreach ( $category_terms as $category )
              <li class="tab-item cursor-link {{ $selected_category === $category['slug'] ? 'active' : '' }}" data-target="{{ $category['slug'] }}">
                <div>{{ $category['name'] }}</div>
              </li>
            @endforeach
          @endunless
        </ul>
      </div>

      <div id="views-wrappers"></div>

      <div class="view-more-button-wrapper">
        <a class="view-more-button btn cursor-link" id="view-more-views-button">
          <div class="btn-label">
            {{ __( 'View More Insights', 'sage' ) }}
          </div>
          <div class="btn-icon">
            <img alt="View More Insights" src="@asset( 'images/icons/submit-arrow.png' )">
          </div>
        </a>
      </div>
  </div>
</section>