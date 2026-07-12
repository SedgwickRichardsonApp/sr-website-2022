<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class SingleCptPeople extends Controller {
  public function details() {
    global $post;

    $image_url = '';
    

    $people_id = $post->ID;

    if ( has_post_thumbnail( $people_id ) ) {
      $image_url = get_the_post_thumbnail_url( $people_id, 'thumbnails-1000x1700' );
    }

    return [
      'location'      => html_entity_decode( get_field( 'location' ) ),
      'working_since' => html_entity_decode( get_field( 'working_since' ) ),
      'position'      => html_entity_decode( get_field( 'position' ) ),
      'linkedin_url'  => get_field( 'linkedin_url' ),
      'image'         => $image_url,
    ];
  }
}
