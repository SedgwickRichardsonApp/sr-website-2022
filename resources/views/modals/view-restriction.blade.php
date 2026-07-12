@if ( is_singular( 'cpt-views' ) && in_array( $restriction_type, [ 'pdf_file_request', 'pdf_file_auto_response', 'reveal' ] ) )
  <div class=" view-restriction-wrap expanded">
    <div class="content">
      <div class="modal-close view-restriction-close cursor-link" style="display: none;">
        <div class="label">
          {{ __( 'Close', 'sage' ) }}
        </div>
        <div class="icon">
          @asset_svg('images/icons/close.svg')
        </div>
      </div>

      <div class="container-fluid">
        <div class="view-restriction-container">
          <div class="view-restriction-form-wrapper" data-view-id="{{ $view_id }}">
            <div class="grid grid-cols-1 md:grid-cols-12 md:gap-10">
              <div class="col-span-1 md:col-span-6">
                <h2 class="view-restriction-title">
                  {{ __( 'Share your details for access.', 'sage' ) }}
                </h2>
              </div>
              <div class="col-span-1 md:col-span-5 md:col-start-7">
                @unless ( empty( $restriction['form'] ) )
                  <div class="view-restriction-form" id="viewRestrictionForm" data-page-title="{{ $restriction['page_title'] }}" data-pdf-url="{{ $restriction['pdf'] }}">
                    {!! $restriction['form'] !!}

                    <div class="submit-button-wrapper">
                      <button class="submit-button btn cursor-link">
                        <div class="btn-label">
                          {{ __( 'Submit', 'sage' ) }}
                        </div>
                        <div class="btn-icon">
                          <img alt="Submit" src="@asset( 'images/icons/submit-arrow.png' )">
                        </div>
                      </button>
                    </div>
                  </div>
                @endunless
              </div>
            </div>
          </div>

          @if ( in_array( $restriction_type, [ 'pdf_file_request', 'pdf_file_auto_response' ] ) )
            <div class="view-restriction-thank-you" style="display: none;">
              @unless ( empty( $restriction['thank_you_title'] ) )
                <div class="thank-you-title">
                  {{ $restriction['thank_you_title'] }}
                </div>
              @endunless

              @unless ( empty( $restriction['thank_you_description'] ) )
                <div class="thank-you-description">
                  {!! apply_filters( 'the_content', $restriction['thank_you_description'] ) !!}
                </div>
              @endunless
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endif
