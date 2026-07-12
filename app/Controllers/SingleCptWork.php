<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use function App\get_all_posts;
use function App\get_primary_term;

class SingleCptWork extends Controller {
  private function work_id() {
    return get_the_ID();
  }

  public function expertise_and_service_terms() {
    $work_id       = $this->work_id();
    $service_terms = get_the_terms( $work_id, 'cpt_work_service' );
    $expertise_terms = get_the_terms( $work_id, 'cpt_work_expertise' );
    $terms_arr     = [];

    // if ( ! empty( $primary_expertise_term = get_primary_term( $work_id, 'cpt_work_expertise' ) ) ) {
    //   $terms_arr[] = html_entity_decode( $primary_expertise_term->name );
    // }
    if ( ! is_wp_error( $expertise_terms ) && ! empty( $expertise_terms ) ) {
      $expertise_terms = array_slice( $expertise_terms, 0, 3 );

      foreach ( $expertise_terms as $term ) {
        $terms_arr[] = html_entity_decode( $term->name );
      }
    }

    if ( ! is_wp_error( $service_terms ) && ! empty( $service_terms ) ) {
      $service_terms = array_slice( $service_terms, 0, 3 );

      foreach ( $service_terms as $term ) {
        $terms_arr[] = html_entity_decode( $term->name );
      }
    }

    return array_values( $terms_arr );
  }

  public function hero() {
    $work_id          = $this->work_id();
    $image_url        = '';
    $mobile_image_url = '';
    $image_size       = 'thumbnails-2800x1600';

    $use_video = false;
    $video_format = '';
    $video_url     = '';
    $video_iframe = '';

    $use_video_mobile = false;
    $video_format_mobile = '';
    $video_url_mobile = '';
    $video_iframe_mobile = '';

    if ( !empty( get_field('use_video_thumbnail_hero', $work_id) ) ) {
      $use_video = true;
      $video_format = get_field('featured_video_format_hero', $work_id);
      switch ( $video_format ) {
        case 'local_file':
          $video_url = get_field('featured_video_file_hero', $work_id)['url'];
          break;
        case 'url':
          $video_url = get_field('featured_video_url_hero', $work_id);
          break;
        case 'iframe':
          $video_iframe = get_field('featured_video_iframe_hero', $work_id);
          break;
      }
    }

    if ( get_field('use_video_thumbnail_hero_mobile', $work_id) ) {
      $use_video_mobile = true;
      $video_format_mobile = get_field('featured_video_format_hero_mobile', $work_id);
      switch ( $video_format_mobile ) {
        case 'local_file':
          $video_url_mobile = get_field('featured_video_file_hero_mobile', $work_id)['url'];
          break;
        case 'url':
          $video_url_mobile = get_field('featured_video_url_hero_mobile', $work_id);
          break;
        case 'iframe':
          $video_iframe_mobile = get_field('featured_video_iframe_hero_mobile', $work_id);
          break;
      }
    }

    if(!$use_video){
      if (
        ( $hero_use_featured_image = get_field( 'hero_use_featured_image' ) ) ||
        ! is_bool( $hero_use_featured_image )
      ) {

        if ( has_post_thumbnail( $work_id ) ) {
          $image_url = get_the_post_thumbnail_url( $work_id, 'full' );
          if(pathinfo($image_url, PATHINFO_EXTENSION) == 'gif'){
            $image_url = get_the_post_thumbnail_url( $work_id, 'full' );
          }
        }
      } elseif ( ! empty( $hero_image = get_field( 'hero_image' ) ) && is_array( $hero_image ) ) {
        $image_url = $hero_image['url'];
        if(pathinfo($image_url, PATHINFO_EXTENSION) == 'gif'){
          $image_url = $hero_image['url'];
        }
      }
    }

    if(!$use_video_mobile){
      if ( ! empty( $hero_mobile_image = get_field( 'hero_mobile_image' ) ) && is_array( $hero_mobile_image ) ) {
        $mobile_image_url = $hero_mobile_image['sizes'][ $image_size ];
        if(pathinfo($mobile_image_url, PATHINFO_EXTENSION) == 'gif'){
          $mobile_image_url = $hero_mobile_image['url'];
        }
      }
    }

    return [
      'client_name'  => html_entity_decode( get_field( 'client_name' ) ),
      'image'        => $image_url,
      'mobile_image' => $mobile_image_url,
      'use_video'    => $use_video,
      'video_format' => $video_format,
      'video_iframe' => $video_iframe,
      'video_url'    => $video_url,
      'use_video_mobile' => $use_video_mobile,
      'video_format_mobile' => $video_format_mobile,
      'video_iframe_mobile' => $video_iframe_mobile,
      'video_url_mobile' => $video_url_mobile,
    ];
  }

  public function intro() {
    $work_id      = $this->work_id();
    $awards_arr   = [];
    $location     = '';
    $sector_terms = get_the_terms( $work_id, 'cpt_work_sector' );
    $sectors_arr  = [];
    $link = get_permalink($work_id);
    $linkedin_url = 'https://linkedin.com/shareArticle?url='.$link.'&title='.urlencode(get_field('intro_title'));
    $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u='.$link;
    
    if ( ! empty( $intro_awards = get_field( 'intro_awards' ) ) && is_array( $intro_awards ) ) {
      foreach ( $intro_awards as $award ) {
        $awards_arr[] = [
          'award_name'  => $award['award_name'],
          'description' => $award['description'],
          'location'    => html_entity_decode( $award['location'] ),
        ];
      }
    }

    if ( ! empty( $primary_location_term = get_primary_term( $work_id, 'cpt_work_location' ) ) ) {
      $location = $primary_location_term->name;
    }

    if ( ! is_wp_error( $sector_terms ) && ! empty( $sector_terms ) ) {
      foreach ( $sector_terms as $term ) {
        $sectors_arr[] = html_entity_decode( $term->name );
      }
    }

    return [
      'background_color' => get_field( 'intro_background_color' ),
      'text_color'       => get_field( 'intro_text_color' ),
      'client_name'      => html_entity_decode( get_field( 'client_name' ) ),
      'title'            => html_entity_decode( get_field( 'intro_title' ) ),
      'description'      => get_field( 'intro_description' ),
      'facebook_url'     => $facebook_url,
      'linkedin_url'     => $linkedin_url,
      'challenge'        => get_field( 'intro_challenge' ),
      'solution'         => get_field( 'intro_solution' ),
      'outcomes'         => get_field( 'intro_outcomes' ),
      'awards'           => array_values( $awards_arr ),
      'location'         => html_entity_decode( $location ),
      'sectors'          => array_values( $sectors_arr ),
    ];
  }

  public function related_work() {
    $work_id      = $this->work_id();
    $display_type = get_field( 'related_work_display_type' );
    $related_work = [];

    if ( $display_type === 'automatic' ) {
      $work_service_taxonomy = 'cpt_work_service';
      $service_terms         = get_the_terms( $work_id, $work_service_taxonomy );
      $extra_args            = [
        'posts_per_page' => 1,
        'order'          => 'DESC',
        'exclude'        => [
          $work_id,
        ],
      ];

      if ( ! is_wp_error( $service_terms ) && ! empty( $service_terms ) ) {
        $tax_query = [
          [
            'taxonomy' => $work_service_taxonomy,
            'field'    => 'slug',
            'terms'    => wp_list_pluck( $service_terms, 'slug' ),
          ]
        ];

        $related_works = get_all_posts( 'cpt-work', $tax_query, [], $extra_args );

        if ( ! empty( $related_works ) ) {
          $related_work = array_pop( $related_works );
        }
      }

      if ( empty( $related_work ) ) {
        $work_sector_taxonomy = 'cpt_work_sector';
        $sector_terms         = get_the_terms( $work_id, $work_sector_taxonomy );

        if ( ! is_wp_error( $sector_terms ) && ! empty( $sector_terms ) ) {
          $tax_query = [
            [
              'taxonomy' => $work_sector_taxonomy,
              'field'    => 'slug',
              'terms'    => wp_list_pluck( $sector_terms, 'slug' ),
            ]
          ];

          $related_works = get_all_posts( 'cpt-work', $tax_query, [], $extra_args );

          if ( ! empty( $related_works ) ) {
            $related_work = array_pop( $related_works );
          }
        }
      }
    } elseif (
      $display_type === 'select_manually' &&
      ! empty( $related_work_field = get_field( 'related_work' ) ) &&
      get_post_status( $related_work_field->ID ) === 'publish'
    ) {
      $related_work = $related_work_field;
    }

    if ( ! empty( $related_work ) ) {
      $related_work_id = $related_work->ID;
      $image_url       = '';

      if ( has_post_thumbnail( $related_work_id ) ) {
        $image_url = get_the_post_thumbnail_url( $related_work_id, 'full' );
      }

      return [
        'title'       => html_entity_decode( get_the_title( $related_work_id ) ),
        'client_name' => html_entity_decode( get_field( 'client_name', $related_work_id ) ),
        'image'       => $image_url,
        'link'        => get_permalink( $related_work_id ),
      ];
    }

    return [];
  }

  public function related_testimonial() {
    $work_id      = $this->work_id();
    $related_testimonial = [];

    if( 
      !empty( $related_testimonial_field = get_field( 'related_testimonial' ) ) &&
      get_post_status( $related_testimonial_field->ID ) === 'publish'
    ) {
      $related_testimonial = $related_testimonial_field;
    }
    if ( ! empty( $related_testimonial ) ) {
      $testimonial_id = $related_testimonial->ID;

      return [
        'client_name' => get_field('client_name', $testimonial_id),
        'client_title' => get_field('company_name', $testimonial_id),
        'client_company' => get_field('client_company', $testimonial_id),
        'testimonial' => get_field('testimonial', $testimonial_id),
      ];
    }

    return [];
  }


  public function work_image_grid() {
    $work_id      = $this->work_id();
    // $work_image_grid = [];
// dd( get_field('image_grid', $work_id));
     $work_image_grid = get_field('image_grid', $work_id);
    //  dd($work_image_grid[0]['url']);
    return $work_image_grid;
  }
}
