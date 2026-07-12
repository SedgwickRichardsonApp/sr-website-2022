<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use function App\get_post_type_terms;

class TemplateWork extends Controller {

  public function selected_taxonomy() {
    if ( isset( $_GET['filter'] ) && ! empty( $_GET['filter'] ) ) {
      return sanitize_text_field( $_GET['filter'] );
    }

    return '';
  }

  public function selected_term() {
    if ( isset( $_GET['term'] ) && ! empty( $_GET['term'] ) ) {
      return sanitize_text_field( $_GET['term'] );
    }

    return '';
  }

  public function title() {
    if ( ! empty( $title = get_field( 'title' ) ) ) {
      return html_entity_decode( $title );
    }

    return html_entity_decode( get_the_title() );
  }

  public function sector_terms() {
    return get_post_type_terms( 'cpt_work_sector' );
  }

  public function expertise_terms() {
    return get_post_type_terms( 'cpt_work_expertise' );
  }

  public function location_terms() {
    return get_post_type_terms( 'cpt_work_location' );
  }
}
