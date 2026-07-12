<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use function App\get_all_posts;
use function App\get_primary_term;

class TemplateHomepage extends Controller {
  public function hero() {
    return [
      'heading' => html_entity_decode( get_field( 'hero_heading' ) ),
      'subheading' => html_entity_decode( get_field( 'hero_subheading' ) ),
    ];
  }

  public function contact_us() {
    return [
      'title' => html_entity_decode( get_field( 'contact_us_title' ) ),
    ];
  }

  public function works() {
    $display_type = get_field( 'works_display_type' );
    $works        = [];

    if ( $display_type === 'latest_posts' ) {
      $extra_args = [
        'posts_per_page' => 7,
      ];

      $works = get_all_posts( 'cpt-work', [], [], $extra_args );
    } elseif (
      $display_type === 'select_manually' &&
      ! empty( $works_field = get_field( 'works' ) ) &&
      is_array( $works_field )
    ) {
      foreach ( $works_field as $work ) {
        if ( ! empty( $work['work'] ) && get_post_status( $work['work']->ID ) === 'publish' ) {
          $works[] = $work['work'];
        }
      }
    }

    if ( ! empty( $works ) ) {
      $works_arr = [];

      foreach ( $works as $key => $work ) {
        $work_id       = $work->ID;
        $image_url     = '';
        $image_size    = 'full';
        // $service_terms = get_the_terms( $work_id, 'cpt_work_service' );
        $expertise_terms = get_the_terms( $work_id, 'cpt_work_expertise' );
        $terms_arr     = [];
        $use_video = false;
        $video_format = '';
        $video_url     = '';
        $video_iframe = '';

        switch ( $key ) {
          case 0:
            $image_size = 'thumbnails-2200x1400';
            break;
          case 1:
            $image_size = 'thumbnails-1400x1000';
            break;
          default:
            $image_size = 'thumbnails-1400x1000';
            // $image_size = 'full';
            break;
        }

        if ( get_field('use_video_thumbnail', $work_id) ) {
          $use_video = true;
          $video_format = get_field('featured_video_format', $work_id);
          switch ( $video_format ) {
            case 'local_file':
              $video_url = get_field('featured_video_file', $work_id)['url'];
              break;
            case 'url':
              $video_url = get_field('featured_video_url', $work_id);
              break;
            case 'iframe':
              $video_iframe = get_field('featured_video_iframe', $work_id);
              break;
          }
        }

        if ( !$use_video && has_post_thumbnail( $work_id ) ) {
          if ( has_post_thumbnail( $work_id ) ) {
            $image_url = get_the_post_thumbnail_url( $work_id, $img_size );
            if(pathinfo($image_url, PATHINFO_EXTENSION) == 'gif'){
              $image_url = get_the_post_thumbnail_url( $work_id, 'full' );
            }
          }
        }

        if ( ! is_wp_error( $expertise_terms ) && ! empty( $expertise_terms ) ) {
          $expertise_terms = array_slice( $expertise_terms, 0, 3 );
          foreach ( $expertise_terms as $term ) {
            $terms_arr[] = html_entity_decode( $term->name );
          }
        }

        $works_arr[] = [
          'title'       => html_entity_decode( get_the_title( $work_id ) ),
          'client_name' => html_entity_decode( get_field( 'client_name', $work_id ) ),
          'image'       => $image_url,
          'use_video'   => $use_video,
          'video_format' => $video_format,
          'video_iframe' => $video_iframe,
          'video_url' => $video_url,
          'terms'       => array_values( $terms_arr ),
          'link'        => get_permalink( $work_id ),
          'cursor_icon' => get_field( 'cursor-icon', $work_id ),
        ];
      }

      return array_values( $works_arr );
    }

    return [];
  }

  public function views() {
    $display_type = get_field( 'views_display_type' );
    $views        = [];

    if ( $display_type === 'latest_posts' ) {
      $extra_args = [
        'posts_per_page' => 6,
      ];

      $views = get_all_posts( 'cpt-views', [], [], $extra_args );
    } elseif (
      $display_type === 'select_manually' &&
      ! empty( $views_field = get_field( 'views' ) ) &&
      is_array( $views_field )
    ) {
      foreach ( $views_field as $view ) {
        if ( ! empty( $view['view'] ) && get_post_status( $view['view']->ID ) === 'publish' ) {
          $views[] = $view['view'];
        }
      }
    }

    if ( ! empty( $views ) ) {
      $views_arr = [];

      foreach ( $views as $view ) {
        $view_id       = $view->ID;
        $image_url     = '';
        $image_size    = 'thumbnails-900x600';
        $terms_arr     = [];
        $use_video = false;
        $video_format = '';
        $video_url     = '';
        $video_iframe = '';

        if ( get_field('use_video_thumbnail_home', $view_id) ) {
          $use_video = true;
          $video_format = get_field('featured_video_format_home', $view_id);
          switch ( $video_format ) {
            case 'local_file':
              $video_url = get_field('featured_video_file_home', $view_id)['url'];
              break;
            case 'url':
              $video_url = get_field('featured_video_url_home', $view_id);
              break;
            case 'iframe':
              $video_iframe = get_field('featured_video_iframe_home', $view_id);
              break;
          }
        }

        if( !$use_video && !empty( $featured_image = get_field( 'featured_image_home', $view_id ) ) && is_array( $featured_image ) ) {
          $image_url = $featured_image['sizes'][ $image_size ];
          if(pathinfo($image_url, PATHINFO_EXTENSION) == 'gif'){
            $image_url = $featured_image['url'];
          }
        }else 
        if ( !$use_video && empty(get_field( 'featured_image_home', $view_id )) && has_post_thumbnail( $view_id ) ) {
          $image_url = get_the_post_thumbnail_url( $view_id, 'thumbnails-900x600'  );
          if(pathinfo($image_url, PATHINFO_EXTENSION) == 'gif'){
            $image_url = get_the_post_thumbnail_url( $view_id, 'full' );
          }
        }

        $views_arr[] = [
          'title' => html_entity_decode( get_the_title( $view_id ) ),
          'image' => $image_url,
          'use_video'   => $use_video,
          'video_format' => $video_format,
          'video_iframe' => $video_iframe,
          'video_url' => $video_url,
          'link'  => get_permalink( $view_id ),
        ];
      }

      return array_values( $views_arr );
    }

    return [];
  }

  public function expertise() {
    $expertise_items_arr = [];

    if ( ! empty( $expertise_items = get_field( 'expertise_items' ) ) && is_array( $expertise_items ) ) {
      foreach ( $expertise_items as $expertise ) {
        if ( ! empty( $expertise['expertise'] ) && get_post_status( $expertise['expertise']->ID ) === 'publish' ) {
          $page_id        = $expertise['expertise']->ID;
          $cursor_icon    = $expertise['home_expertise_id'];
          $image_url      = '';
          $image_position = [
            'top'  => 0,
            'left' => 0,
          ];

          if ( has_post_thumbnail( $page_id ) ) {
            $image_url = get_the_post_thumbnail_url( $page_id, 'thumbnails-500x500'  );
            if(pathinfo($image_url, PATHINFO_EXTENSION) == 'gif'){
              $image_url = get_the_post_thumbnail_url( $work_id, 'full' );
            }
          }

          if ( ! empty( $expertise['image_position'] ) && is_array( $expertise['image_position'] ) ) {
            if ( ! empty( $expertise['image_position']['top'] ) ) {
              $image_position['top'] = $expertise['image_position']['top'];
            }

            if ( ! empty( $expertise['image_position']['left'] ) ) {
              $image_position['left'] = $expertise['image_position']['left'];
            }
          }

          $desc_arr = [];
          if ( ! empty( $descriptions = $expertise['expertise_descriptions'] ) && is_array( $descriptions ) ) {
            
            foreach ( $descriptions as $desc ) {
              if ( ! empty( $desc ) && is_array( $desc ) ) {
                $desc_arr[] = $desc['description'];
              }
            }
          }

          $menu_title = get_field('menu_title', $page_id);
          // $cursor_icon = str_replace(" ", "-", $menu_title);
          // $cursor_icon = strtolower($cursor_icon);

          $expertise_items_arr[] = [
            'title'          => get_the_title( $page_id ),
            'menu_title'     => $menu_title,
            'cursor_icon'    => $cursor_icon,
            'image'          => $image_url,
            'image_position' => $image_position,
            'descriptions'   => $desc_arr,
            'link'           => get_permalink( $page_id ),
          ];
        }
      }
    }

    return [
      'title' => html_entity_decode( get_field( 'expertise_title' ) ),
      
      'title_desc' => get_field('expertise_title_description'),
      'items' => array_values( $expertise_items_arr ),
    ];
  }

  public function clients() {
    $logos_arr = [];

    if ( ! empty( $clients_logos = get_field( 'clients_logos' ) ) && is_array( $clients_logos ) ) {
      foreach ( $clients_logos as $logo ) {
        if ( ! empty( $logo ) && is_array( $logo ) ) {
          $logos_arr[] = $logo['url'];
        }
      }
    }

    return [
      'title'       => html_entity_decode( get_field( 'clients_title' ) ),
      'description' => get_field( 'clients_description' ),
      'logos'       => array_values( $logos_arr ),
    ];
  }

  public function testimonials() {
    $display_type = get_field( 'testimonials_display_type' );
    $testimonials = [];

    if ( empty($display_type) || $display_type === 'latest_posts' ) {
      $extra_args = [
        'posts_per_page' => 6,
      ];

      $testimonials = get_all_posts( 'cpt-testimonials', [], [], $extra_args );

    } elseif (
      $display_type === 'select_manually' &&
      ! empty( $testimonials_field = get_field( 'testimonial' ) ) &&
      is_array( $testimonials_field )
    ) {
      foreach ( $testimonials_field as $testimonial ) {
        if ( ! empty( $testimonial['testimonial'] ) && get_post_status( $testimonial['testimonial']->ID ) === 'publish' ) {
          $testimonials[] = $testimonial['testimonial'];
        }
      }
    }

    if ( ! empty( $testimonials ) ) {
      $testimonials_arr = [];

      foreach ( $testimonials as $testimonial ) {
        $testimonial_id = $testimonial->ID;

        $testimonials_arr[] = [
          'client_name' => get_field('client_name', $testimonial_id),
          'client_company' => get_field('client_company', $testimonial_id),
          'client_title' => get_field('company_name', $testimonial_id),
          'testimonial' => get_field('testimonial', $testimonial_id),
        ];
      }

      return array_values( $testimonials_arr );
    }

    return [];
  }

}
