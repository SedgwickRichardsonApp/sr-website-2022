<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use function App\get_post_date;
use function App\get_primary_term;

class SingleCptJobs extends Controller {
  public function details() {
    $job_id    = get_the_ID();
    $location  = '';
    $work_type = '';

    if ( $primary_location_term = get_primary_term( $job_id, 'cpt_jobs_location' ) ) {
      $location = $primary_location_term->name;
    }

    if ( $primary_work_type_term = get_primary_term( $job_id, 'cpt_jobs_work_type' ) ) {
      $work_type = $primary_work_type_term->name;
    }

    return [
      'location'  => html_entity_decode( $location ),
      'work_type' => html_entity_decode( $work_type ),
      'date'      => get_post_date( $job_id ),
      'job_contact_email' => get_field( 'job_contact_email', $job_id ),
      'contact_description' => get_field( 'contact_description', $job_id ),
    ];
  }
}
