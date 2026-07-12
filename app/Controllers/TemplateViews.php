<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use function App\get_all_posts;
use function App\get_primary_term;
use function App\get_post_type_terms;


class TemplateViews extends Controller {
  public function page_title() {
    if ( ! empty( $title = get_field( 'page_title' ) ) ) {
      return html_entity_decode( $title );
    }

    return html_entity_decode( get_the_title() );
  }

  public function category_terms() {
    return get_post_type_terms( 'cpt_views_category' );
  }

  public function selected_category() {
    if ( isset( $_GET['type'] ) && ! empty( $_GET['type'] ) ) {
      return sanitize_text_field( $_GET['type'] );
    }

    return '';
  }
}
