<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter( 'body_class',
  function ( array $classes ) {
    /** Add page slug if it doesn't exist */
    if ( is_single() || is_page() && ! is_front_page() ) {
      if ( ! in_array( basename( get_permalink() ), $classes ) ) {
        $classes[] = basename( get_permalink() );
      }
    }

    /** Add class if sidebar is active */
    if ( display_sidebar() ) {
      $classes[] = 'sidebar-primary';
    }

    if ( is_singular( 'cpt-views' ) && in_array( get_field( 'restriction_type' ), [ 'pdf_file_request', 'pdf_file_auto_response', 'reveal' ] ) ) {
      $classes[] = 'modal-open';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(
      function ( $class ) {
        return preg_replace( [ '/-blade(-php)?$/', '/^page-template-views/' ], '', $class );
      },
      $classes
    );

    return array_filter( $classes );
  }
);

/**
 * Add "… Continued" to the excerpt
 */
add_filter( 'excerpt_more',
  function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __( 'Continued', 'sage' ) . '</a>';
  }
);

/**
 * Template Hierarchy should search for .blade.php files
 */
collect( [
  'index',
  '404',
  'archive',
  'author',
  'category',
  'tag',
  'taxonomy',
  'date',
  'home',
  'frontpage',
  'page',
  'paged',
  'search',
  'single',
  'singular',
  'attachment',
  'embed',
] )->map( function ( $type ) {
  add_filter( "{$type}_template_hierarchy", __NAMESPACE__ . '\\filter_templates' );
} );

/**
 * Render page using Blade
 */
add_filter( 'template_include',
  function ( $template ) {
    collect( ['get_header', 'wp_head'] )->each( function ( $tag ) {
      ob_start();
      do_action( $tag );
      $output = ob_get_clean();
      remove_all_actions( $tag );
      add_action( $tag,
        function () use ( $output ) {
          echo $output;
        }
      );
      // add_action( 'wp_enqueue_scripts', 'themeprefix_scroll_reveal' );
    });

    $data = collect( get_body_class() )->reduce(
      function ( $data, $class ) use ( $template ) {
        return apply_filters( "sage/template/{$class}/data", $data, $template );
      },
      []
    );

    if ( $template ) {
      echo template( $template, $data );

      return get_stylesheet_directory() . '/index.php';
    }

    return $template;
  },
  PHP_INT_MAX
);

/**
 * Render comments.blade.php
 */
add_filter( 'comments_template',
  function ( $comments_template ) {
    $comments_template = str_replace(
      [ get_stylesheet_directory(), get_template_directory() ],
      '',
      $comments_template
    );

    $data = collect( get_body_class() )->reduce(
      function ( $data, $class ) use ( $comments_template ) {
        return apply_filters( "sage/template/{$class}/data", $data, $comments_template );
      },
      []
    );

    $theme_template = locate_template( [ "views/{$comments_template}", $comments_template ] );

    if ( $theme_template ) {
      echo template( $theme_template, $data );

      return get_stylesheet_directory() . '/index.php';
    }

    return $comments_template;
  },
  100
);

/**
 * Remove auto <p> and <br> tags on content
 */
remove_filter( 'the_content', 'wpautop' );

/**
 * Redirect expertise parent page to first child page
 */
add_action( 'template_redirect',
  function () {
    if ( is_page_template( 'views/template-expertise.blade.php' ) ) {
      $page_id = get_the_ID();

      if ( empty( wp_get_post_parent_id( $page_id ) ) ) {
        $extra_args = [
          'post_parent' => $page_id,
          'orderby'     => 'menu_order',
        ];

        $child_pages = get_all_posts( 'page', [], [], $extra_args );

        if ( ! empty( $child_pages ) ) {
          wp_redirect( get_permalink( $child_pages[0]->ID ) );
          exit;
        }
      }
    }
  }
);

/**
 * Add custom attribs on menu item
 */
add_filter( 'nav_menu_link_attributes',
  function( $atts ) {
    $atts['class'] = 'cursor-link';

    return $atts;
  },
  100,
  1
);

/**
 * Highlight Views menu item
 */
add_filter( 'nav_menu_css_class' ,
  function ( $classes, $item, $args, $depth ) {
    if ( $args->theme_location === 'primary_navigation' ) {
      if (
        ! empty( $parent_id = get_post()->post_parent ) &&
        get_permalink( $parent_id ) === $item->url
      ) {
        $classes[] = 'current-menu-item';
      }

      if ( is_singular( 'cpt-views' ) ) {
        $page_id = get_post_meta( $item->ID, '_menu_item_object_id', true );

        if (
          ! empty( $views_id = get_page_id_by_template( 'views/template-views.blade.php' ) ) &&
          $views_id == $page_id
        ) {
          $classes[] = 'current-menu-item';
        }
      }
    }

    return $classes;
  },
  10,
  4
);

/**
 * Render blocks with a wrapper
 * List of core blocks here: https://gist.github.com/DavidPeralvarez/37c8c148f890d946fadb2c25589baf00
 */
add_filter( 'render_block',
  function ( $block_content, $block ) {
    if (
      (
        is_singular( [
          'cpt-work',
        ] )
      ) &&
      ( strpos( $block['blockName'], 'core' ) === 0 )
    ) {
      $content  = '<div class="wp-block my-12 s-sequenced">';
      $content .= '<div class="container">';
      $content .= $block_content;
      $content .= '</div>';
      $content .= '</div>';

      return $content;
    }

    return $block_content;
  },
  10,
  2
);
