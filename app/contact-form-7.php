<?php

namespace App;

/**
 * Remove auto added p and br tags
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Add pdf file url shortcode
 */
add_shortcode( 'view_restriction_pdf_file',
  function () {
    if ( is_singular( 'cpt-views' ) ) {
      $post_id = get_the_ID();

      if (
        in_array( get_field( 'restriction_type', $post_id ), [ 'pdf_file_request', 'pdf_file_auto_response' ] ) &&
        ! empty( $restriction_pdf_file = get_field( 'restriction_pdf_file', $post_id ) ) &&
        is_array( $restriction_pdf_file )
      ) {
        return $restriction_pdf_file['url'];
      }
    }

    return '';
  }
);
