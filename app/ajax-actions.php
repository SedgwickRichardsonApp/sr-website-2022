<?php

namespace App;

add_action( 'wp_ajax_nopriv_get_search_autocomplete_data', __NAMESPACE__ . '\\myajax_get_search_autocomplete_data' );
add_action( 'wp_ajax_get_search_autocomplete_data', __NAMESPACE__ . '\\myajax_get_search_autocomplete_data' );
function myajax_get_search_autocomplete_data() {
  $language   = sanitize_text_field( $_POST['language'] );

  global $sitepress;

  if ( ! empty( $language ) ) {
    $sitepress->switch_lang( $language, true );
  }

  $data       = [];
  $text       = get_i18n();

  $posts_arr  = [
    [
      'post_type'    => 'cpt-work',
      'title'        => 'Work',
      'title_text'   => $text['work'],
      'is_highlight' => true,
      'is_other'     => false,
    ],
    [
      'post_type'    => 'cpt-testimonials',
      'title'        => 'Testimonials',
      'title_text'   => $text['testimonials'],
      'is_highlight' => true,
      'is_other'     => false,
    ],
    [
      'post_type'    => 'cpt-views',
      'title'        => 'Views',
      'title_text'   => $text['views'],
      'is_highlight' => true,
      'is_other'     => false,
    ],
    [
      'post_type'    => 'cpt-people',
      'title'        => 'People',
      'title_text'   => $text['people'],
      'is_highlight' => false,
      'is_other'     => true,
    ],
    [
      'post_type'    => 'cpt-jobs',
      'title'        => 'Jobs',
      'title_text'   => $text['jobs'],
      'is_highlight' => false,
      'is_other'     => true,
    ],
    [
      'post_type'    => 'page',
      'title'        => 'Pages',
      'title_text'   => $text['pages'],
      'is_highlight' => false,
      'is_other'     => true,
    ],
  ];

  if ( ! empty( $posts_arr ) ) {
    foreach ( $posts_arr as $post_item ) {
      $posts = get_all_posts( $post_item['post_type'] );
      $list  = [];

      if ( ! empty( $posts ) ) {
        $list = array_map(
          function ( $p ) use ( $post_item ) {
            $title       = $p->post_title;
            $subtitle    = '';
            $image_url   = '';
            $description = '';
            $expertise   = '';
            $expertise_arr = [];
            $service     = '';
            $service_arr = [];
            $sector     = '';
            $sector_arr = [];
            $location     = '';
            $location_arr = [];

            if ( $post_item['post_type'] === 'cpt-work' ) {
              $subtitle = get_field( 'client_name', $p->ID );
              $expertise = get_the_terms( $p->ID, 'cpt_work_expertise' );
              foreach ( $expertise as $term ) {
                $expertise_arr[] = html_entity_decode( $term->name );
              }
              
              $service = get_the_terms( $p->ID, 'cpt_work_service' );
              foreach ( $service as $term ) {
                $service_arr[] = html_entity_decode( $term->name );
              }

              $sector = get_the_terms( $p->ID, 'cpt_work_sector' );
              foreach ( $sector as $term ) {
                $sector_arr[] = html_entity_decode( $term->name );
              }

              $location = get_the_terms( $p->ID, 'cpt_work_location' );
              foreach ( $location as $term ) {
                $location_arr[] = html_entity_decode( $term->name );
              }
            }

            // else if ( $post_item['post_type'] === 'cpt-people' ) {
            //   $image_url = $image_url = get_the_post_thumbnail_url( get_post( sanitize_text_field( $p['people_id'] ) ) );
            // }

            if ( $post_item['is_highlight'] && has_post_thumbnail( $p->ID ) ) {
              $image_url = get_the_post_thumbnail_url( $p->ID, 'thumbnails-900x600');
            }

            if ( $post_item['is_other'] ) {
              if ( has_excerpt( $p->ID ) ) {
                $description = get_the_excerpt( $p->ID );
              } else {
                $description = wp_trim_words( $p->post_content, 25, '...' );
              }
            }

            return [
              'title'       => html_entity_decode( $title ),
              'expertise'   => $expertise_arr,
              'service'     => $service_arr,
              'sector'      => $sector_arr,
              'location'    => $location_arr,
              'subtitle'    => html_entity_decode( $subtitle ),
              'image'       => $image_url,
              'description' => $description,
              'link'        => get_permalink( $p->ID ),
              'cursor_icon' => get_field( 'cursor-icon', $p->ID  ),
            ];
          },
          $posts
        );
      }

      $data[] = [
        'title'        => html_entity_decode( $post_item['title'] ),
        'list'         => array_values( $list ),
        'is_highlight' => $post_item['is_highlight'],
        'is_other'     => $post_item['is_other'],
        'title_text'   => $post_item['title_text'],
      ];
    }
  }

  wp_send_json_success( [
      'data' => array_values( $data ),
      'text' => $text,
    ]
  );
}

add_action( 'wp_ajax_nopriv_get_people_content', __NAMESPACE__ . '\\myajax_get_people_content' );
add_action( 'wp_ajax_get_people_content', __NAMESPACE__ . '\\myajax_get_people_content' );
function myajax_get_people_content() {
  $people_id = sanitize_text_field( $_POST['people_id'] );
  $people = get_post( $people_id );
  $people_info = get_post_meta( $people_id);

  if ( has_post_thumbnail( $people ) ) {
    $image_url = get_the_post_thumbnail_url( $people );
  }

  wp_send_json_success( [
    'content'       => $people->post_content,
    'image'         => $image_url,
    'name'          => html_entity_decode( get_the_title( $people ) ),
    'position'      => get_post_meta( $people_id, 'position', true ),
    'linked_in'     => get_post_meta( $people_id, 'linkedin_url', true ),
    'working_since' => get_post_meta( $people_id, 'working_since', true ),
    'location'      => get_post_meta( $people_id, 'location', true ),
    'url'           => $people->post_name,
    'i18n'          => get_i18n(),
    // 'tmp'           => $people_info,
    // 'tmp2'          => $people,
  ] );
}

add_action( 'wp_ajax_nopriv_get_job_details', __NAMESPACE__ . '\\myajax_get_job_details' );
add_action( 'wp_ajax_get_job_details', __NAMESPACE__ . '\\myajax_get_job_details' );
function myajax_get_job_details() {
  $jobs_id = sanitize_text_field( $_POST['jobs_id'] );
  $location = '';
  $work_type = '';

  $job = get_post( $jobs_id );

  if ( ! empty( $location_term = get_primary_term( $jobs_id, 'cpt_jobs_location' ) ) ) {
    $location = $location_term->name;
  }

  if ( ! empty( $work_type_term = get_primary_term( $jobs_id, 'cpt_jobs_work_type' ) ) ) {
    $work_type = $work_type_term->name;
  }

  wp_send_json_success( [
    'content'       => $job->post_content,
    'jobTitle'      => html_entity_decode( get_the_title( $job ) ),
    'location'      => html_entity_decode( $location ),
    'workType'      => html_entity_decode( $work_type ),
    'date'          => get_the_date( 'd/m/Y', $job ),
    'contactDescription' => $job->contact_description,
    'jobContactEmail' => $job->job_contact_email,
    'url'           => $job->post_name,
    'i18n'          => get_i18n(),
  ] );
}

add_action( 'wp_ajax_nopriv_get_views', __NAMESPACE__ . '\\myajax_get_views' );
add_action( 'wp_ajax_get_views', __NAMESPACE__ . '\\myajax_get_views' );
function myajax_get_views() {
  $language   = sanitize_text_field( $_POST['language'] );
  $category   = sanitize_text_field( $_POST['category'] );
  $tax_query  = [];
  $views_arr  = [];
  $page = sanitize_text_field( $_POST['page'] );
  $posts_per_page = ($page + 1) * 9;
  $offset = 0; //p.1 return 9 records; p.2 return 18 records

  global $sitepress;

  if ( ! empty( $language ) ) {
    $sitepress->switch_lang( $language, true );
  }

  if ( ! empty( $category ) ) {
    $tax_query = [
      [
        'taxonomy' => 'cpt_views_category',
        'field'    => 'slug',
        'terms'    => $category,
      ]
    ];
  }

  if(empty($category)){
    $for_count_posts = get_all_posts( 'cpt-views', [], [], []);
    $all_views = get_all_posts( 'cpt-views', $tax_query, [], [], $posts_per_page, $offset );
  } else {
    $for_count_posts = get_all_posts( 'cpt-views', $tax_query, [], []);
    $all_views = get_all_posts( 'cpt-views', $tax_query, [], []);
  }

  if ( ! empty( $all_views ) ) {
    $pattern_a = 2;
    $pattern_b = 4;
    $next_circle_key = $pattern_a;
    $next_add = $pattern_b;

    foreach ( $all_views as $key => $view ) {
      $view_id                = $view->ID;
      $image_url              = '';
      $terms_arr              = [];
      $view_class             = '';
      $use_video = false;
      $video_format = '';
      $video_url     = '';
      $video_iframe = '';
      $author = '';

      if ( $primary_author_term = get_primary_term( $view_id, 'cpt_views_author' ) ) {
        $author = $primary_author_term->name;
      }
      if ( ! empty( $primary_category_term = get_primary_term( $view_id, 'cpt_views_category' ) ) ) {
        $view_class .= $primary_category_term->slug;
      }

      if (get_field('use_video_thumbnail', $view_id) ) {
        $use_video = true;
        $video_format = get_field('featured_video_format', $view_id);
        switch ( $video_format ) {
          case 'local_file':
            $video_url = get_field('featured_video_file', $view_id)['url'];
            break;
          case 'url':
            $video_url = get_field('featured_video_url', $view_id);
            break;
          case 'iframe':
            $video_iframe = get_field('featured_video_iframe', $view_id);
            break;
        }
      }

      if ( !$use_video && has_post_thumbnail( $view_id ) ) {
        $image_url = get_the_post_thumbnail_url( $view_id, 'thumbnails-1400x1000'  );
        if(pathinfo($image_url, PATHINFO_EXTENSION) == 'gif'){
          $image_url = get_the_post_thumbnail_url( $view_id, 'full' );
        }
      }

      if( $key === 0  || $key === 7) {
        $view_class .= ' featured';

        if ( has_post_thumbnail( $view_id ) ) {
          $image_url = get_the_post_thumbnail_url( $view_id, 'full' );
        }
      } elseif ( $key === $next_circle_key ) {
        $view_class .= ' circle';
        $next_circle_key += $next_add;
        $next_add = ($next_add === $pattern_a) ? $pattern_b : $pattern_a;
      } else {
        $view_class .= ' square';
      }

      $views_arr[] = [
        'title'     => html_entity_decode( get_the_title( $view_id ) ),
        'author'    => $author,
        'image'     => $image_url,
        'use_video'   => $use_video,
        'video_format' => $video_format,
        'video_iframe' => $video_iframe,
        'video_url' => $video_url,
        'link'      => get_permalink( $view_id ),
        'category'  => $primary_category,
        'class'     => $view_class,
      ];
    }
  }

  wp_send_json_success( [
    'views_count' => count( $all_views ),
    'views'       => array_values( $views_arr ),
    'total_posts' => count( $for_count_posts),
  ] );
}

add_action( 'wp_ajax_nopriv_get_view_restriction_reveal_type_content', __NAMESPACE__ . '\\myajax_get_view_restriction_reveal_type_content' );
add_action( 'wp_ajax_get_view_restriction_reveal_type_content', __NAMESPACE__ . '\\myajax_get_view_restriction_reveal_type_content' );
function myajax_get_view_restriction_reveal_type_content() {
  $language = sanitize_text_field( $_POST['language'] );
  $view_id  = absint( $_POST['view_id'] );
  $content  = '';

  global $sitepress;

  if ( ! empty( $language ) ) {
    $sitepress->switch_lang( $language, true );
  }

  if ( ! empty( $view_id ) ) {
    global $post;

    $post = get_post( $view_id );
    setup_postdata( $post );

    $view_content = get_the_content();

    if ( has_blocks( $view_content ) ) {
      $restriction_type = get_field( 'restriction_type', $view_id );
      $blocks           = parse_blocks( $view_content );

      if ( $restriction_type === 'reveal' ){ //|| $restriction_type === 'pdf_file_auto_response' || $restriction_type === 'pdf_file_request' ) {
        $read_more_block_index = array_search( 'acf/read-more', wp_list_pluck( $blocks, 'blockName' ) );

        if ( $read_more_block_index !== false ) {
          $view_content_arr      = array_slice( $blocks, $read_more_block_index + 1 );
          $rendered_blocks       = '';

          foreach ( $view_content_arr as $block ) {
            $rendered_blocks .= apply_filters( 'the_content', render_block( $block ) );
          }
          
          $content = $rendered_blocks;
        }
      }
    }

    wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly
  }

  wp_send_json_success( [
    'content' => $content,
  ] );
}

add_action( 'wp_ajax_nopriv_get_works', __NAMESPACE__ . '\\myajax_get_works' );
add_action( 'wp_ajax_get_works', __NAMESPACE__ . '\\myajax_get_works' );
function myajax_get_works() {
  $language       = sanitize_text_field( $_POST['language'] );
  $taxonomy       = sanitize_text_field( $_POST['taxonomy'] );
  $term           = sanitize_text_field( $_POST['term'] );
  $page = sanitize_text_field( $_POST['page'] );
  $posts_per_page = ($page + 1) * 12;
  $offset = 0; //p.1 return 12 records; p.2 return 24 records
  $tax_query      = [];
  $works_by_group = [];

  global $sitepress;

  if ( ! empty( $language ) ) {
    $sitepress->switch_lang( $language, true );
  }

  if ( ! empty( $taxonomy ) && ! empty( $term ) ) {
    if ( $taxonomy === 'expertise' ) {
      $tax_query = [
        [
          'taxonomy' => 'cpt_work_expertise',
          'field'    => 'slug',
          'terms'    => $term,
        ]
      ];
    } elseif ( $taxonomy === 'sector' ) {
      $tax_query = [
        [
          'taxonomy' => 'cpt_work_sector',
          'field'    => 'slug',
          'terms'    => $term,
        ]
      ];
    } elseif ( $taxonomy === 'location' ) {
      $tax_query = [
        [
          'taxonomy' => 'cpt_work_location',
          'field'    => 'slug',
          'terms'    => $term,
        ]
      ];
    }
  }

  $get_work_data = function( $work_id ) {
    $image_url = '';
    $second_featured_img = '';
    $use_video = false;
    $video_format = '';
    $video_url     = '';
    $video_iframe = '';

    if ( !empty( get_field('use_video_thumbnail_work', $work_id) ) ) {
      $use_video = true;
      $video_format = get_field('featured_video_format_work', $work_id);
      switch ( $video_format ) {
        case 'local_file':
          $video_url = get_field('featured_video_file_work', $work_id)['url'];
          break;
        case 'url':
          $video_url = get_field('featured_video_url_work', $work_id);
          break;
        case 'iframe':
          $video_iframe = get_field('featured_video_iframe_work', $work_id);
          break;
      }
    }

    if ( !$use_video && has_post_thumbnail( $work_id ) ) {
      $image_url = get_the_post_thumbnail_url( $work_id, 'thumbnails-1400x1000'  );
      if(pathinfo($image_url, PATHINFO_EXTENSION) == 'gif'){
        $image_url = get_the_post_thumbnail_url( $work_id, 'full' );
      }
    }

    if ( !$use_video && !empty( $image = get_field( 'second_featured_image', $work_id )) ) {
      $second_featured_img = $image['sizes']['thumbnails-1400x1000'];
      if(pathinfo($second_featured_img, PATHINFO_EXTENSION) == 'gif'){
        $second_featured_img = $image['url'];
      }
    } else {
      $second_featured_img = $image_url;
    }

    return [
      'title'       => html_entity_decode( get_the_title( $work_id ) ),
      'image'       => $image_url,
      'use_video'   => $use_video,
      'video_format' => $video_format,
      'video_iframe' => $video_iframe,
      'video_url'    => $video_url,
      'second_featured_img' => $second_featured_img,
      'client_name' => html_entity_decode( get_field( 'client_name', $work_id ) ),
      'link'        => get_permalink( $work_id ),
      'cursor_icon' => get_field( 'cursor-icon', $work_id ),
      'featured'    => get_field('featured_post', $work_id)
    ];
  };
// dd(empty( $taxonomy ));
  if(empty( $taxonomy )){ // ==='featured'
    $all_works = get_featured_works( $posts_per_page, $offset);
    $for_count_posts = get_featured_works();
  }else{
    $all_works = get_all_posts( 'cpt-work', $tax_query, [], [], $posts_per_page, $offset );
    $for_count_posts = get_all_posts( 'cpt-work', $tax_query, [], []);
  }

  if ( ! empty( $all_works ) ) {
    if ( ! empty( $term ) ) {
      $term_slug = '';
      $term_name = '';
      $term_data = [];
      $works_arr = [];

      if ( $taxonomy === 'expertise' ) {
        $term_data = get_term_by( 'slug', $term, 'cpt_work_expertise' );
      } elseif ( $taxonomy === 'sector' ) {
        $term_data = get_term_by( 'slug', $term, 'cpt_work_sector' );
      } elseif ( $taxonomy === 'location' ) {
        $term_data = get_term_by( 'slug', $term, 'cpt_work_location' );
      }

      if ( ! is_wp_error( $term_data ) && ! empty( $term_data ) ) {
        $term_slug = $term_data->slug;
        $term_name = $term_data->name;
      }

      foreach ( $all_works as $work ) {
        $works_arr[] = $get_work_data( $work->ID );
      }

      $works_by_group[] = [
        'id'                 => $term_slug,
        'title'              => html_entity_decode( $term_name ),
        'show_view_all_link' => false,
        'works'              => array_values( $works_arr ),
      ];
    } elseif ( ! empty( $taxonomy ) ) {
      $terms = [];

      if ( $taxonomy === 'expertise' ) {
        $terms = get_post_type_terms( 'cpt_work_expertise' );
      } elseif ( $taxonomy === 'sector' ) {
        $terms = get_post_type_terms( 'cpt_work_sector' );
      } elseif ( $taxonomy === 'location' ) {
        $terms = get_post_type_terms( 'cpt_work_location' );
      }

      if ( ! empty( $terms ) ) {
        foreach ( $terms as $term ) {
          $tax_query = [];
          $works_arr = [];

          if ( $taxonomy === 'expertise' ) {
            $tax_query = [
              [
                'taxonomy' => 'cpt_work_expertise',
                'field'    => 'slug',
                'terms'    => $term['slug'],
              ]
            ];
          } elseif ( $taxonomy === 'sector' ) {
            $tax_query = [
              [
                'taxonomy' => 'cpt_work_sector',
                'field'    => 'slug',
                'terms'    => $term['slug'],
              ]
            ];
          } elseif ( $taxonomy === 'location' ) {
            $tax_query = [
              [
                'taxonomy' => 'cpt_work_location',
                'field'    => 'slug',
                'terms'    => $term['slug'],
              ]
            ];
          }

          $works = get_all_posts( 'cpt-work', $tax_query, [], [], $posts_per_page, $offset );

          if ( ! empty( $works ) ) {
            foreach ( $works as $key => $work ) {
              if ( $key < 3 ) {
                $works_arr[] = $get_work_data( $work->ID );
              } else {
                break;
              }
            }

            $works_by_group[] = [
              'id'                 => $term['slug'],
              'title'              => html_entity_decode( $term['name'] ),
              'show_view_all_link' => count( $works ) > 2,
              'works'              => array_values( $works_arr ),
            ];
          }
        }
      }
    } else {
      $works_arr = [];

      foreach ( $all_works as $work ) {
        $works_arr[] = $get_work_data( $work->ID );
      }

      $works_by_group[] = [
        'id'                 => '',
        'title'              => '',
        'show_view_all_link' => false,
        'works'              => array_values( $works_arr ),
      ];
    }
  }

  wp_send_json_success( [
    'works_count' => count( $all_works ),
    'works'       => array_values( $works_by_group ),
    'total_posts' => count( $for_count_posts),
  ] );

}
