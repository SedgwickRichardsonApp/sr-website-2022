<?php

namespace App;

/**
 * Add custom block categories
 */
add_filter(
  'block_categories',
  function ( $categories, $post ) {
    return array_merge(
      [
        [
          'slug'  => 'sr-custom-blocks',
          'title' => __( 'SR Blocks', 'sr-custom-blocks' ),
        ],
      ],
      $categories
    );
  },
  10,
  2
);

/**
 * Register ACF blocks for Gutenberg
 */
add_action( 'acf/init',
  function () {
    if ( function_exists( 'acf_register_block' ) ) {
      // Register an Image Columns block
      acf_register_block( [
        'name'            => 'image-columns',
        'title'           => __( 'Image Columns' ),
        'description'     => __( 'A custom image columns block.' ),
        'render_callback' => __NAMESPACE__ . '\\sr_custom_blocks_render_callback',
        'category'        => 'sr-custom-blocks',
        'icon'            => 'format-image',
        'keywords'        => [ 'image', 'columns' ],
      ] );

      // Register an Image Slider block
      acf_register_block( [
        'name'            => 'image-slider',
        'title'           => __( 'Image Slider' ),
        'description'     => __( 'A custom image slider block.' ),
        'render_callback' => __NAMESPACE__ . '\\sr_custom_blocks_render_callback',
        'category'        => 'sr-custom-blocks',
        'icon'            => 'images-alt',
        'keywords'        => [ 'image', 'slider' ],
      ] );

      // Register a Read More block
      acf_register_block( [
        'name'            => 'read-more',
        'title'           => __( 'Read More' ),
        'description'     => __( 'A custom read more block.' ),
        'render_callback' => __NAMESPACE__ . '\\sr_custom_blocks_render_callback',
        'category'        => 'sr-custom-blocks',
        'icon'            => 'plus',
        'keywords'        => [ 'read more' ],
      ] );

      // Register an Title Left, Content Right block
      acf_register_block( [
        'name'            => 'title-left-content-right',
        'title'           => __( 'Title Left, Content Right' ),
        'description'     => __( 'A custom title left, content right block.' ),
        'render_callback' => __NAMESPACE__ . '\\sr_custom_blocks_render_callback',
        'category'        => 'sr-custom-blocks',
        'icon'            => 'editor-textcolor',
        'keywords'        => [ 'title', 'left', 'content', 'right' ],
      ] );

      // Register video block
      acf_register_block( [
        'name'            => 'video',
        'title'           => __( 'SR Video' ),
        'description'     => __( 'A custom video block.' ),
        'render_callback' => __NAMESPACE__ . '\\sr_custom_blocks_render_callback',
        'category'        => 'sr-custom-blocks',
        'icon'            => 'video-alt3',
        'keywords'        => [ 'video', 'video url', 'video link', 'video file', 'youtube' ],
      ] );
    }
  }
);

/**
 * ACF blocks for Gutenberg render callback
 */
function sr_custom_blocks_render_callback( $block, $content = '', $is_preview = false ) {
  // Convert name into path friendly slug
  $slug = str_replace( 'acf/', '', $block['name'] );

  // include a template part from within the "/views/acf-blocks" folder
  if ( file_exists( get_theme_file_path( "/views/acf-blocks/{$slug}.blade.php" ) ) ) {
    $margin_classes = [];

    if ( ! empty( $margin_mobile = get_field( 'margin_mobile' ) ) && is_array( $margin_mobile ) ) {
      $margin_mobile_top    = absint( $margin_mobile['top'] * 4 );
      $margin_mobile_bottom = absint( $margin_mobile['bottom'] * 4 );
      $margin_classes[]     = "mt-{$margin_mobile_top}";
      $margin_classes[]     = "mb-{$margin_mobile_bottom}";
    }

    if ( ! empty( $margin_desktop = get_field( 'margin_desktop' ) ) && is_array( $margin_desktop ) ) {
      $margin_desktop_top    = absint( $margin_desktop['top'] * 4 );
      $margin_desktop_bottom = absint( $margin_desktop['bottom'] * 4 );
      $margin_classes[]      = "md:mt-{$margin_desktop_top}";
      $margin_classes[]      = "md:mb-{$margin_desktop_bottom}";
    }

    $data = [
      'is_preview'   => $is_preview,
      'block_id'     => $block['id'],
      'margin_class' => implode( ' ', $margin_classes ),
    ];

    echo template( "acf-blocks/{$slug}", $data );
  }
}
