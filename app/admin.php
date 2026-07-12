<?php

namespace App;

/**
 * Theme customizer
 */
add_action( 'customize_register',
  function ( \WP_Customize_Manager $wp_customize ) {
    // Add postMessage support
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial( 'blogname',
      [
        'selector'        => '.brand',
        'render_callback' => function () {
          bloginfo( 'name' );
        },
      ]
    );
  }
);

/**
 * Customizer JS
 */
add_action( 'customize_preview_init',
  function () {
    wp_enqueue_script( 'sage/customizer.js', asset_path( 'scripts/customizer.js' ), [ 'customize-preview' ], null, true );
  }
);

/**
 * Admin assets
 */
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\load_custom_wp_admin_assets' );
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\load_custom_wp_admin_assets' );
add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\\load_custom_wp_admin_assets' );
function load_custom_wp_admin_assets() {
  if ( ( isset( $GLOBALS['pagenow'] ) && 'wp-login.php' == $GLOBALS['pagenow'] ) || is_user_logged_in() ) {
    wp_enqueue_style( 'sage/admin.css', asset_path( 'styles/admin.css' ), false, ADMIN_ASSETS_VERSION );
    wp_enqueue_script( 'sage/admin.js', asset_path( 'scripts/admin.js' ), array(), ADMIN_ASSETS_VERSION, true );
  }
}

/**
 * Inline CSS for logged-in users
 */
add_action( 'admin_head', __NAMESPACE__ . '\\admin_head_css' );
add_action( 'wp_head', __NAMESPACE__ . '\\admin_head_css' );
function admin_head_css() {
  if ( ! is_user_logged_in() ) {
    return;
  }
  ?>
  <style type="text/css">
  </style>
  <?
}

/**
 * Admin inline js
 */
add_action( 'admin_footer',
  function () { ?>
    <script type="text/javascript">
      jQuery(document).ready(function($) {$('.admin-bar .acf-readonly input, .admin-bar .acf-readonly textarea').attr('readonly', 'true');});
    </script>
  <? }
);

/**
 * Remove posts menu
 */
add_action( 'admin_menu',
  function () {
    remove_menu_page( 'edit.php' ); /*Posts menu*/
    remove_menu_page( 'edit-comments.php' ); /*Comments menu*/
  }
);

/**
 * Custom subheadings for admin menu
 */
add_action( 'init',
  function () {
    /****************************************/
    add_action( 'admin_menu',
      function () {
        add_menu_page( 'Menu label', 'General', 'manage_options', 'menu-custom-label-1', '', '', 5 );
      }
    );
  }
);
/** Featured Work */
add_action('restrict_manage_posts', function () {
  global $typenow;

  if ($typenow !== 'cpt-work') {
    return;
  }

  $value = $_GET['acf_featured'] ?? '';

  echo '<select name="acf_featured">';
  echo '<option value="">' . __('All Featured Status', 'sage') . '</option>';
  echo '<option value="1"' . selected($value, '1', false) . '>' . __('Featured Only', 'sage') . '</option>';
  echo '<option value="0"' . selected($value, '0', false) . '>' . __('Non-Featured Only', 'sage') . '</option>';
  echo '</select>';
});

add_filter('pre_get_posts', function ($query) {
  if (!is_admin() || !$query->is_main_query()) {
    return;
  }

  global $pagenow, $typenow;

  if ($pagenow === 'edit.php' && $typenow === 'cpt-work' && isset($_GET['acf_featured']) && $_GET['acf_featured'] !== '') {
    $query->set('meta_query', [
      [
        'key'     => 'featured_post',
        'value'   => $_GET['acf_featured'],
        'compare' => '='
      ]
    ]);
  }
});


/**
 * Remove new post menu
 */
add_action( 'wp_before_admin_bar_render',
  function () {
    global $wp_admin_bar;

    /** @var \WP_Admin_Bar $wp_admin_bar */
    $wp_admin_bar->remove_menu( 'new-content' );
  }
);

add_filter( 'wp_check_filetype_and_ext',
  function ( $info, $file, $filename, $mimes ) {
    $wp_filetype = wp_check_filetype( $filename, $mimes );
    $ext = $wp_filetype['ext'];
    $type = $wp_filetype['type'];

    if ( $ext !== 'json' ) {
      return $info;
    }

    if ( function_exists( 'finfo_file' ) ) {
        // Use finfo_file if available to validate non-image files.
      $finfo = finfo_open( FILEINFO_MIME_TYPE );
      $real_mime = finfo_file( $finfo, $file );
      finfo_close( $finfo );

      // If the extension matches an alternate mime type, let's use it
      if ( in_array( $real_mime, array( 'application/json', 'text/plain' ) ) ) {
        $info['ext'] = $ext;
        $info['type'] = $type;
      }
    }

    return $info;
  },
  10,
  4
);

/*
 * Allow upload of identified file types
 */
add_filter( 'upload_mimes',
  function ( $existing_mimes ) {
    if ( current_user_can( 'manage_options' ) ) {
      $existing_mimes['json'] = 'text/plain';
      $existing_mimes['svg']  = 'image/svg+xml';
    }

    return $existing_mimes;
  },
  10,
  1
);

add_action( 'init',
  function () {
    if ( function_exists( 'acf_add_options_page' ) ) {
      acf_add_options_page(
        [
          'page_title'    => 'Theme Options',
          'menu_title'    => 'Theme Options',
          'menu_slug'     => 'theme-options',
          'capability'    => 'edit_posts',
          'icon_url'      => 'dashicons-art',
          'update_button' => 'Save Options',
          'redirect'      => false,
        ]
      );
    }
  }
);

add_action( 'admin_init',
  function () {
    $auto_load_choices_fields = [];

    foreach ( $auto_load_choices_fields as $load_choices_field ) {
      add_filter( "acf/prepare_field/name=$load_choices_field",
        function ( $field ) {
          $choices    = [];
          $field_name = isset( $field['_name'] ) ? $field['_name'] : $field['name'];

          switch ( $field_name ) {
          }

          if ( ! empty( $choices ) ) {
            $field['choices'] = [];
            foreach ( array_map( 'trim', $choices ) as $key => $choice ) {
              $field['choices'][ $key ] = $choice;
            }
          }

          return $field;
        }
      );
    }
  }
);

/**
 * Hide / show Custom fields menu
 */
add_filter( 'acf/settings/show_admin',
  function ( $show ) {
    if ( is_production_environment() || is_staging_environment() ) {
      return false;
    }

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
      return false;
    }

    if ( ! current_user_can( 'manage_options' ) ) {
      return false;
    }

    return $show;
  }
);

/**
 * Add excerpt field to pages
 */
add_post_type_support( 'page', 'excerpt' );
