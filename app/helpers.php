<?php

namespace App;

use Roots\Sage\Container;
use WPSEO_Primary_Term;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array $parameters
 * @param Container $container
 *
 * @return Container|mixed
 */
function sage( $abstract = null, $parameters = [], Container $container = null ) {
  $container = $container ?: Container::getInstance();
  if ( ! $abstract ) {
    return $container;
  }

  return $container->bound( $abstract )
    ? $container->makeWith( $abstract, $parameters )
    : $container->makeWith( "sage.{$abstract}", $parameters );
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param null $key
 * @param null $default
 *
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 * @throws \Illuminate\Container\EntryNotFoundException
 */
function config( $key = null, $default = null ) {
  if ( is_null( $key ) ) {
    return sage( 'config' );
  }
  if ( is_array( $key ) ) {
    return sage( 'config' )->set( $key );
  }

  return sage( 'config' )->get( $key, $default );
}

/**
 * @param string $file
 * @param array $data
 *
 * @return string
 */
function template( $file, $data = [] ) {
  return sage( 'blade' )->render( $file, $data );
}

/**
 * Retrieve path to a compiled blade view
 *
 * @param $file
 * @param array $data
 *
 * @return string
 */
function template_path( $file, $data = [] ) {
  return sage( 'blade' )->compiledPath( $file, $data );
}

/**
 * @param $asset
 *
 * @return string
 */
function asset_path( $asset ) {
  return sage( 'assets' )->getUri( $asset );
}

/**
 * @param string $filename
 * @param string $file_version
 *
 * @return string
 */
function asset_svg_content( $filename, $file_version = '' ) {
  if ( false === strpos( $filename, '.svg' ) ) {
    return '';
  }

  $file_path = get_stylesheet_directory() . '/assets/' . ltrim( $filename, '/' );

  if ( $file_version ) {
    $file_path_with_suffix = str_replace( '.svg', $file_version . '.svg', $file_path );
    if ( file_exists( $file_path_with_suffix ) ) {
      $file_path = $file_path_with_suffix;
    }
  }

  return file_get_contents( $file_path );
}

/**
 * @param string|string[] $templates Possible template files
 *
 * @return array
 */
function filter_templates( $templates ) {
  $paths = apply_filters( 'sage/filter_templates/paths',
    [
      'views',
      'resources/views',
    ]
  );

  $paths_pattern = "#^(" . implode( '|', $paths ) . ")/#";

  return collect( $templates )
    ->map( function ( $template ) use ( $paths_pattern ) {
      /** Remove .blade.php/.blade/.php from template names */
      $template = preg_replace( '#\.(blade\.?)?(php)?$#', '', ltrim( $template ) );

      /** Remove partial $paths from the beginning of template names */
      if ( strpos( $template, '/' ) ) {
        $template = preg_replace( $paths_pattern, '', $template );
      }

      return $template;
    } )
    ->flatMap( function ( $template ) use ( $paths ) {
      return collect( $paths )
        ->flatMap( function ( $path ) use ( $template ) {
          return [
            "{$path}/{$template}.blade.php",
            "{$path}/{$template}.php",
          ];
        } )
        ->concat( [
          "{$template}.blade.php",
          "{$template}.php",
        ] );
    } )
    ->filter()
    ->unique()
    ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 *
 * @return string Location of the template
 */
function locate_template( $templates ) {
  return \locate_template( filter_templates( $templates ) );
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar() {
  static $display;
  isset( $display ) || $display = apply_filters( 'sage/display_sidebar', false );

  return $display;
}

/**
 * Check if production
 * @return bool
 */
function is_production_environment() {
  return 'production' == WP_ENV;
}

/**
 * Check if staging
 * @return bool
 */
function is_staging_environment() {
  return 'staging' == WP_ENV;
}

/**
 * Get all posts of a post type
 *
 * @param string $post_type
 * @param array $tax_query
 * @param array $meta_query
 * @param array $extra_args
 *
 * @return array
 */
function get_all_posts( $post_type, $tax_query = [], $meta_query = [], $extra_args = [], $post_per_page = 500, $offset = 0 ) {
  if ( ! $post_type ) {
    return [];
  }

  $default_args = array(
    'post_type'        => $post_type,
    'posts_per_page'   => $post_per_page,
    'offset'           => $offset,
    'exclude'          => array(),
    'tax_query'        => $tax_query,
    'meta_query'       => $meta_query,
    'post_status'      => 'publish',
    'orderby'          => 'date',
    'order'            => 'DESC',
    'suppress_filters' => false,
  );

  return get_posts( array_merge( $default_args, $extra_args ) );

  // If first page, get featured posts first
  // if ( $offset === 0 ) {
  //   // Get featured posts
  //   $featured_args = array(
  //     'post_type'        => $post_type,
  //     'posts_per_page'   => $post_per_page,
  //     'meta_query'       => array_merge( $meta_query, array(
  //       array(
  //         'key'     => 'featured_post',
  //         'value'   => true,
  //         'compare' => '=',
  //       ),
  //     ) ),
  //     'tax_query'        => $tax_query,
  //     'post_status'      => 'publish',
  //     'orderby'          => 'date',
  //     'order'            => 'DESC',
  //     'suppress_filters' => false,
  //   );
  //   $featured_posts = get_posts( array_merge( $featured_args, $extra_args ) );
  //   $featured_ids = wp_list_pluck( $featured_posts, 'ID' );

  //   // Remaining number of posts to fetch
  //   $remaining = $post_per_page - count( $featured_posts );

  //   // Get non-featured posts excluding featured
  //   $non_featured_args = array(
  //     'post_type'        => $post_type,
  //     'posts_per_page'   => $remaining,
  //     'offset'           => 0,
  //     'post__not_in'     => $featured_ids,
  //     'meta_query'       => array_merge( $meta_query, array(
  //       array(
  //         'key'     => 'featured_post',
  //         'compare' => 'NOT EXISTS',
  //       ),
  //     ) ),
  //     'tax_query'        => $tax_query,
  //     'post_status'      => 'publish',
  //     'orderby'          => 'date',
  //     'order'            => 'DESC',
  //     'suppress_filters' => false,
  //   );
  //   $non_featured_posts = get_posts( array_merge( $non_featured_args, $extra_args ) );

  //   return array_merge( $featured_posts, $non_featured_posts );
  // }

  // For subsequent pages
  // $default_args = array(
  //   'post_type'        => $post_type,
  //   'posts_per_page'   => $post_per_page,
  //   'offset'           => $offset,
  //   'meta_query'       => $meta_query,
  //   'tax_query'        => $tax_query,
  //   'post_status'      => 'publish',
  //   'orderby'          => 'date',
  //   'order'            => 'DESC',
  //   'suppress_filters' => false,
  // );

  // return get_posts( array_merge( $default_args, $extra_args ) );
}

function get_featured_works( $post_per_page = 500, $offset = 0 ) {
  $default_args = array(
    'post_type'        => 'cpt-work',
    'posts_per_page'   => $post_per_page,
    'offset'           => $offset,
    'exclude'          => array(),
    'meta_key'        => 'featured_post',
    'meta_value'      => true,
    'post_status'      => 'publish',
    'orderby'          => 'date',
    'order'            => 'DESC',
    'suppress_filters' => false,
  );

  return get_posts($default_args);
}

/**
 * Get ID of first page found which is set with provided template
 *
 * @param $template_file_name
 *
 * @return bool
 */
function get_page_id_by_template( $template_file_name ) {
  $pages = get_posts( array(
    'post_type'        => 'page',
    'posts_per_page'   => - 1,
    'offset'           => 0,
    'orderby'          => 'date',
    'order'            => 'DESC',
    'post_status'      => 'publish',
    'meta_key'         => '_wp_page_template',
    'meta_value'       => $template_file_name,
    'suppress_filters' => false,
  ) );
  if ( isset( $pages[0] ) ) {
    return $pages[0]->ID;
  }

  return false;
}

/**
 * Get url of first page found which is set with provided template
 *
 * @param $template_file_name
 *
 * @return string
 */
function get_page_url_by_template( $template_file_name ) {
  $page_id   = get_page_id_by_template( $template_file_name );
  $page_link = get_page_link( $page_id );
  if ( $page_id > 0 ) {
    return $page_link;
  }

  return '#';
}

/**
 * Get primary term of a post
 *
 * @param $post_id
 * @param $taxonomy
 *
 * @return array|bool|mixed|WP_Error|WP_Term|null
 */
function get_primary_term( $post_id, $taxonomy ) {
  if ( ! $post = get_post( $post_id ) ) {
    return false;
  }

  if ( class_exists( 'WPSEO_Primary_Term' ) ) {
    $term    = new WPSEO_Primary_Term( $taxonomy, $post->ID );
    $term_id = $term->get_primary_term();

    if ( $term_id ) {
      return get_term( $term_id, $taxonomy );
    }
  }

  $terms = get_the_terms( $post->ID, $taxonomy );
  if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
    return array_pop( $terms );
  }

  return null;
}

/**
 * Get string with no spaces
 *
 * @param string $string
 *
 * @return string
 */
function get_no_space_str( $string = '' ) {
  return preg_replace( '/\s+/', '', trim( $string ) );
}

/**
 * Check if gutenberg block is used on page content
 *
 * @param $block_name
 *
 * @return bool
 */
function is_gutenberg_block_used( $block_name ) {
  global $post;
  setup_postdata( $post );

  $content = get_the_content();

  if ( has_blocks( $content ) ) {
    $blocks = parse_blocks( $content );

    if ( is_array( $block_name ) ) {
      if ( ! empty( $block_name ) && ( count( array_intersect( $block_name, wp_list_pluck( $blocks, 'blockName' ) ) ) > 0 ) ) {
        return true;
      }
    } elseif ( in_array( $block_name, wp_list_pluck( $blocks, 'blockName' ) ) ) {
      return true;
    }
  }

  return false;
}

/**
 * Get post date formatted based on language
 *
 * @return string
 */
function get_post_date( $post_id = null, $language = ICL_LANGUAGE_CODE ) {
  if ( empty( $post_id ) ) {
    global $post;

    $post_id = $post->ID;
  }

  $date = '';

  switch ( $language ) {
    case 'zh':
      $date = get_the_date( 'Y年n月j日', $post_id );
      break;
    case 'vi':
      $date = get_the_date( 'j/m/Y', $post_id );
      break;
    default:
      $date = get_the_date( 'd M Y', $post_id );
      break;
  }

  return $date;
}

/**
 * Get post type terms
 *
 * @param string $taxonomy
 *
 * @return array
 */
function get_post_type_terms( $taxonomy = '' ) {
  if ( ! empty( $taxonomy ) ) {
    $parent_terms = get_terms( [
      'taxonomy'   => $taxonomy,
      'hide_empty' => true,
      'parent'     => 0,
    ] );

    if ( ! is_wp_error( $parent_terms ) && ! empty( $parent_terms ) ) {
      $terms_arr = [];

      foreach ( $parent_terms as $parent_term ) {
        $terms_arr[] = [
          'name'      => html_entity_decode( $parent_term->name ),
          'slug'      => $parent_term->slug,
          'is_parent' => true,
        ];

        $child_terms = get_terms( [
          'taxonomy'   => $taxonomy,
          'hide_empty' => true,
          'parent'     => $parent_term->term_id,
        ] );

        if ( ! is_wp_error( $child_terms ) && ! empty( $child_terms ) ) {
          foreach ( $child_terms as $child_term ) {
            $terms_arr[] = [
              'name'      => html_entity_decode( $child_term->name ),
              'slug'      => $child_term->slug,
              'is_parent' => false,
            ];
          }
        }
      }

      return array_values( $terms_arr );
    }
  }

  return [];
}

/**
 * Get estimated reading time for a post
 *
 * @return string
 */
function get_estimated_reading_time( $content = '', $language = ICL_LANGUAGE_CODE ) {
  if ( empty( $content ) ) {
    return false;
  }

  $words = str_word_count( $content );
  $min   = ceil( $words / 200 );
  $label = '';

  switch ( $language ) {
    case 'zh':
      $label = "阅读时长约{$min}分钟";
      break;
    case 'vi':
      $label = "{$min} phút đọc";
      break;
    default:
      $label = "{$min} min read";
      break;
  }

  return $label;
}
