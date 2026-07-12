<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class SingleCptTestimonials extends Controller {
  public function details() {
    global $post;

    $testimonial_id = $post->ID;

    return [
      'client_name' => get_field('client_name', $testimonial_id),
      'client_company' => get_field('client_company', $testimonial_id),
      'client_title' => get_field('company_name', $testimonial_id),
      'testimonial' => get_field('testimonial', $testimonial_id),
    ];
  }
}
