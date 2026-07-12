<div class="right-side-modal search-modal">
  <div class="modal-overlay"></div>
  <div class="modal-content">
    <div class="modal-close search-modal-close cursor-link">
      <div class="label">
        {{ __( 'Close', 'sage' ) }}
      </div>
      <div class="icon">
        @asset_svg('images/icons/close.svg')
      </div>
    </div>

    <div class="search-form-wrapper">
      <div class="search-form">
        <input type="text" class="search-input" placeholder="{{ __( 'Search', 'sage' ) }}" />
        <div class="search-icon">
          @asset_svg('images/icons/search.svg')
        </div>
      </div>
      {{-- <div class="close-icon">
        @asset_svg('images/icons/times.svg')
      </div> --}}
    </div>

    <div class="loading-wrapper">
      <div class="flex items-center cursor-hover">
        <span class="spinner-loader mr-2"></span>
        <span>{{ __( 'Please wait...', 'sage' ) }}</span>
      </div>
    </div>

    <div class="results-wrapper" id="views-result-wrapper"></div>
  </div>
</div>
