<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use function App\get_all_posts;

class TemplatePrivacy extends Controller {
  public function content() {
    $tnc_content_arr = [];

    if ( ! empty( $tnc_contents = get_field( 'tnc_contents' ) ) && is_array( $tnc_contents ) ) {
      foreach ( $tnc_contents as $item ) {
        $tnc_content_arr[] = [
          'id' => 'tnc-'.str_replace(' ', '_', strtolower($item['terms_title'])),
          'show_on_menu' => $item['show_on_menu'],
          'title' => $item['terms_title'],
          'content' => $item['terms_content'],
        ];
      }
    }

    $policy_content_arr = [];

    if ( ! empty( $policy_contents = get_field( 'policy_contents' ) ) && is_array( $policy_contents ) ) {
      foreach ( $policy_contents as $item ) {
        $policy_content_arr[] = [
          'id' => 'policy-'.str_replace(' ', '_', strtolower($item['terms_title'])),
          'show_on_menu' => $item['show_on_menu'],
          'title' => $item['terms_title'],
          'content' => $item['terms_content'],
        ];
      }
    }

    return [
      'page_title'           => get_the_title(),
      'tnc_content_arr'      => $tnc_content_arr,
      'tnc_title'            => get_field( 'tnc_title' ),
      'tnc_contents'         => get_field( 'tnc_contents' ),
      'policy_content_arr'   => $policy_content_arr,
      'policy_title'         => get_field( 'policy_title' ),
      'policy_contents'      => get_field( 'policy_contents' ),
    ];
  }
}
