<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use function App\get_all_posts;
use function App\get_primary_term;

class TemplateContact extends Controller {

  public function contact() {
      $form_html = '';

      if ( ! empty( $contact_form = get_field( 'contact_form', 'options' ) ) ) {
          $form_html = do_shortcode( '[contact-form-7 id="' . absint( $contact_form->ID ) . '"]' );
      }

      return [
          'title'             => get_field( 'contact_title' ),
          'form'              => $form_html,
          'thank_you_message' => get_field( 'contact_thank_you_message', 'options' ),
      ];
  }

  public function hero() {
    $hello_words_arr = ['']; // initiliaze with empty string value for the Typing animation
    $hero_images_arr = [];

    if ( ! empty( $hello_words = get_field( 'hello_words' ) ) && is_array( $hello_words ) ) {
      foreach ( $hello_words as $item ) {
        $hello_words_arr[] = $item['hello_word'];
      }
    }

    if ( ! empty( $hero_images = get_field( 'hero_images' ) ) && is_array( $hero_images ) ) {
      foreach ( $hero_images as $image ) {
        if ( ! empty( $image ) && is_array( $image ) ) {
          $hero_images_arr[] = $image['sizes']['thumbnails-1300x1000'];
        }
      }
    }

    return [
      'hello_words'         => $hello_words_arr,
      'brief_us_title'      => html_entity_decode( get_field('hero_brief_us_title') ),
      'brief_us_link_text'  => html_entity_decode( get_field('hero_brief_us_link_text') ),
      'join_us_title'       => html_entity_decode( get_field('hero_join_us_title') ),
      'join_us_link_text'   => html_entity_decode( get_field('hero_join_us_link_text') ),
      'hero_images'         => $hero_images_arr,
    ];
  }

  public function intro() {
    return [
      'title'       => html_entity_decode( get_field('intro_title') ),
      'description' => get_field('intro_description'),
    ];
  }

  public function offices() {
    $offices_arr = [];

    if ( ! empty( $offices = get_field( 'offices' ) ) && is_array( $offices ) ) {
      foreach ( $offices as $office ) {
        $img_url = '';
        $country_offices = [];
        if ( ! empty( $office['image'] ) && is_array($office['image'] ) ) {
          $img_url = $office['image']['sizes']['thumbnails-1000x1700'];
        }

        if(! empty( $office['country_offices'] ) && is_array( $office['country_offices'] ) ){
          foreach ( $office['country_offices'] as $countries ) {
            $phone_group = [];
            $email_group = [];
            if( !empty( $countries['phone_group'] ) && is_array( $countries['phone_group'] ) ){
              foreach ( $countries['phone_group'] as $phone ) {
                if(!empty( $phone) ){
                  $phone_group[] = html_entity_decode($phone['phone']);

                }
              }
            }

            if(!empty( $countries['email_group'] ) && is_array( $countries['email_group'] ) ){
              foreach ( $countries['email_group'] as $email ) {
                if(!empty( $email) ){
                  $email_group[] = html_entity_decode($email['email']);
                }
              }
            }

            $country_offices[] = [
              'city' => $countries['city'],
              'phone_group' => $phone_group,
              'address' => html_entity_decode($countries['address']),
              'email_group' => $email_group,
            ];

          }
        }

        $offices_arr[] = [
          'country' => html_entity_decode( $office['country_name'] ),
          'image'     => $img_url,
          'info'  => $country_offices,
        ];
      }
    }

    return $offices_arr;
  }

  public function being_sr() {
    return [
      'title'       => html_entity_decode( get_field('being_sr_title') ),
      'description' => get_field('being_sr_description'),
    ];
  }

  public function open_positions() {
    $positions_arr = [];
    $jobs = [];

    $jobs = get_all_posts( 'cpt-jobs' );

    foreach( $jobs as $job ) {
      $location = '';
      $work_type = '';

      $location = get_primary_term($job->ID, 'cpt_jobs_location');
      $work_type = get_primary_term($job->ID, 'cpt_jobs_work_type');

      $positions_arr[] = [
        'id'        => $job->ID,
        'job'       => $job->post_title,
        'location'  => $location->name,
        'work_type' => $work_type->name,
      ];
    }

    return [
      'positions'             => array_values( $positions_arr ),
      'general_contact_text'  => html_entity_decode( get_field('open_positions_general_contact_text') ),
      'general_contact_email' => get_field('open_positions_general_contact_email'),
    ];
  }
}
