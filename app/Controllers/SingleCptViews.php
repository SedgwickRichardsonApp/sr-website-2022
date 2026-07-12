<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use function App\get_all_posts;
use function App\get_estimated_reading_time;
use function App\get_post_date;
use function App\get_primary_term;

class SingleCptViews extends Controller {
  public function view_id() {
    return get_the_ID();
  }

  public function restriction_type() {
    $type = 'public';
    $view_id  = $this->view_id();

    if(empty($_COOKIE['registered_restriction']) || $_COOKIE['registered_restriction'] != $view_id ) {
      if ( ! empty( $restriction_type = get_post_field( 'restriction_type' ) ) ) {
        $type = $restriction_type;
      }
    }

    return $type;
  }

  public function details() {
    global $post;

    $view_id  = $this->view_id();
    $category = '';
    $link = get_permalink($view_id);
    $linkedin_url = 'https://linkedin.com/shareArticle?url='.$link.'&title='.urlencode(get_the_title( $view_id ));
    $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u='.$link;

    if ( ! empty( $primary_category_term = get_primary_term( $view_id, 'cpt_views_category' ) ) ) {
      $category = $primary_category_term->name;
    }

    return [
      'category'     => $category,
      'date'         => get_post_date( $view_id ),
      'reading_time' => get_estimated_reading_time( $post->post_content ),
      'facebook_url'     => $facebook_url,
      'linkedin_url'     => $linkedin_url,
    ];
  }

  public function author() {
    $view_id   = $this->view_id();

    if ( $primary_author_term = get_primary_term( $view_id, 'cpt_views_author' ) ) {
      $name      = $primary_author_term->name;
      $image_url = '';
      $job_title = get_field( 'job_title', $primary_author_term );
      $linkedin_url = get_field( 'linkedin_url', $primary_author_term );
      $wechat_url = get_field( 'wechat_url', $primary_author_term );
      $facebook_url = get_field( 'facebook_url', $primary_author_term );

      if ( ! empty( $image = get_field( 'image', $primary_author_term ) ) && is_array( $image ) ) {
        $image_url = $image['sizes']['thumbnails-200x200'];
      }

      return [
        'name'      => html_entity_decode( $name ),
        'image'     => $image_url,
        'job_title' => html_entity_decode( $job_title ),
        'linkedin_url' => $linkedin_url,
        'wechat_url' => $wechat_url,
        'facebook_url' => $facebook_url,
      ];
    }

    return [];
  }

  public function content() {
    global $post;

    if ( $post ) {
      setup_postdata( $post );

      $content = get_the_content();

      if ( has_blocks( $content ) ) {
        $restriction_type = $this->restriction_type();
        $blocks           = parse_blocks( $content );

        if ( $restriction_type != 'public' ) {
          $read_more_block_index = array_search( 'acf/read-more', wp_list_pluck( $blocks, 'blockName' ) );

          if ( $read_more_block_index !== false ) {
            $content_arr           = array_slice( $blocks, 0, $read_more_block_index );
            $rendered_blocks       = '';

            foreach ( $content_arr as $block ) {
              $rendered_blocks .= render_block( $block );
            }

            return $rendered_blocks;
          }
        }
      }

      return $content;
    }

    return '';
  }

  public function related_views() {
    $view_id        = $this->view_id();
    $display_type   = get_field( 'related_views_display_type' );
    $related_views  = [];

    if ( $display_type === 'automatic' ) {
      $views_category_taxonomy = 'cpt_views_category';
      $category_terms          = get_the_terms( $view_id, $views_category_taxonomy );
      $extra_args              = [
        'posts_per_page' => 3,
        'exclude'        => [
          $view_id,
        ],
      ];

      if ( ! is_wp_error( $category_terms ) && ! empty( $category_terms ) ) {
        $tax_query = [
          [
            'taxonomy' => $views_category_taxonomy,
            'field'    => 'slug',
            'terms'    => wp_list_pluck( $category_terms, 'slug' ),
          ]
        ];

        $related_views = get_all_posts( 'cpt-views', $tax_query, [], $extra_args );
      }

      if ( empty( $related_views ) ) {
        $views_author_taxonomy  = 'cpt_views_author';
        $author_terms           = get_the_terms( $view_id, $views_author_taxonomy );

        if ( ! is_wp_error( $author_terms ) && ! empty( $author_terms ) ) {
          $tax_query = [
            [
              'taxonomy' => $views_author_taxonomy,
              'field'    => 'slug',
              'terms'    => wp_list_pluck( $author_terms, 'slug' ),
            ]
          ];

          $related_views = get_all_posts( 'cpt-views', $tax_query, [], $extra_args );
        }
      }
    } elseif (
      $display_type === 'select_manually' &&
      ! empty( $related_views_field = get_field( 'related_views' ) ) &&
      is_array( $related_views_field )
    ) {
      foreach ( $related_views_field as $view ) {
        if ( ! empty( $view['view'] ) && get_post_status( $view['view']->ID ) === 'publish' ) {
          $related_views[] = $view['view'];
        }
      }
    }

    if ( ! empty( $related_views ) ) {
      $related_views_arr = [];

      foreach ( $related_views as $view ) {
        $view_id   = $view->ID;
        $image_url = '';

        if( !empty( $featured_image = get_field( 'featured_image_home', $view_id ) ) && is_array( $featured_image ) ) {
          $image_url = $featured_image['sizes']['thumbnails-900x600'];
          if(pathinfo($image_url, PATHINFO_EXTENSION) == 'gif'){
            $image_url = $featured_image['url'];
          }
        }else if ( empty(get_field( 'featured_image_home', $view_id )) && has_post_thumbnail( $view_id ) ) {
          $image_url = get_the_post_thumbnail_url( $view_id, 'thumbnails-900x600'  );
          if(pathinfo($image_url, PATHINFO_EXTENSION) == 'gif'){
            $image_url = get_the_post_thumbnail_url( $view_id, 'full' );
          }
        }

        $related_views_arr[] = [
          'title' => html_entity_decode( get_the_title( $view_id ) ),
          'image' => $image_url,
          'link'  => get_permalink( $view_id ),
        ];
      }

      return array_values( $related_views_arr );
    }

    return [];
  }

  public function restriction() {
    $view_id = $this->view_id();

    $restriction_type      = $this->restriction_type();
    $form_html             = '';
    $thank_you_title       = __( 'Thank You!', 'sage' );
    $thank_you_description = '';
    $page_title = get_the_title( $view_id );
    $pdf = '';

    if(empty($_COOKIE['registered_restriction']) || $_COOKIE['registered_restriction'] != $view_id ) {
     // User already registered for restricted content
      if ( $restriction_type === 'pdf_file_request' ) {
        if ( ! empty( $pdf_file_request_type_form = get_field( 'views_restriction_pdf_file_request_type_form', 'options' ) ) ) {
          $form_html = do_shortcode( '[contact-form-7 id="' . absint( $pdf_file_request_type_form->ID ) . '"]' );
        }

        if ( ! empty( $pdf_file_request_type_thank_you_title = get_field( 'views_restriction_pdf_file_request_type_thank_you_title', 'options' ) ) ) {
          $thank_you_title = $pdf_file_request_type_thank_you_title;
        }

        if ( ! empty( $pdf_file_request_type_thank_you_description = get_field( 'views_restriction_pdf_file_request_type_thank_you_description', 'options' ) ) ) {
          $thank_you_description = $pdf_file_request_type_thank_you_description;
        }
        
        if( !empty($pdf = get_field('restriction_pdf_file', $view_id)) ){
          $pdf = $pdf['url'];
        }

      } elseif ( $restriction_type === 'pdf_file_auto_response' ) {
        if ( ! empty( $pdf_file_auto_response_type_form = get_field( 'views_restriction_pdf_file_auto_response_type_form', 'options' ) ) ) {
          $form_html = do_shortcode( '[contact-form-7 id="' . absint( $pdf_file_auto_response_type_form->ID ) . '"]' );
        }

        if ( ! empty( $pdf_file_auto_response_type_thank_you_title = get_field( 'views_restriction_pdf_file_auto_response_type_thank_you_title', 'options' ) ) ) {
          $thank_you_title = $pdf_file_auto_response_type_thank_you_title;
        }

        if ( ! empty( $pdf_file_auto_response_type_thank_you_description = get_field( 'views_restriction_pdf_file_auto_response_type_thank_you_description', 'options' ) ) ) {
          $thank_you_description = $pdf_file_auto_response_type_thank_you_description;
        }

        if( !empty($pdf = get_field('restriction_pdf_file', $view_id)) ){
          $pdf = $pdf['url'];
        }
      } elseif ( $restriction_type === 'reveal' ) {
        if ( ! empty( $reveal_type_form = get_field( 'views_restriction_reveal_type_form', 'options' ) ) ) {
          $form_html = do_shortcode( '[contact-form-7 id="' . absint( $reveal_type_form->ID ) . '"]' );
        }
      }
    }

    return [
      'form'                  => $form_html,
      'thank_you_title'       => html_entity_decode( $thank_you_title ),
      'thank_you_description' => $thank_you_description,
      'page_title'            => $page_title,
      'pdf'                   => $pdf,
    ];
  }
}
