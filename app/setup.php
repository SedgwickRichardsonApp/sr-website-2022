<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action( 'wp_enqueue_scripts',
  function () {
    if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
    }

    /* Enqueue */
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'underscore' );

    /* Common assets */
    $assets_css = [];

    $assets_js = [
      'js-scrollreveal' => 'lib/scrollreveal/scrollreveal.min.js', //moved to header, resolved visiblility bug
      'js-tweenmax'     => 'lib/tween-max/tween-max.min.js',
    ];

    if (
      is_page_template( [
        'views/template-homepage.blade.php',
      ] )
    ) {
      $assets_js['js-anime-js'] = 'lib/anime.js/anime.min.js';
      $assets_css['css-swiper'] =  'lib/swiper/swiper.min.css';
      $assets_js['js-swiper']   = 'lib/swiper/swiper.min.js';
    }

    if (
      is_page_template( [
        'views/template-about.blade.php',
        'views/template-expertise.blade.php',
      ] )
    ) {
      $assets_js['js-lottie-player'] = 'lib/lottie-player/lottie-player.js';
    }

    if (
      is_gutenberg_block_used( [
        'acf/image-slider',
      ] ) ||
      is_page_template( [
        'views/template-careers.blade.php',
        'views/template-expertise.blade.php',
      ] )
    ) {
      $assets_css['css-swiper'] = 'lib/swiper/swiper.min.css';
      $assets_js['js-swiper']   = 'lib/swiper/swiper.min.js';
    }

    if (
      is_page_template( [
        'views/template-careers.blade.php',
      ] )
    ) {
      $assets_js['js-typed-js'] = 'lib/typed.js/typed.min.js';
    }

    foreach ( $assets_css as $handle => $path ) {
      wp_enqueue_style( $handle, get_stylesheet_directory_uri() . '/' . $path, [], ASSETS_VERSION );
    }

    foreach ( $assets_js as $handle => $path ) {
      wp_enqueue_script( $handle, get_stylesheet_directory_uri() . '/' . $path, [], ASSETS_VERSION, true );
    }

    $theme = wp_get_theme();
    define('THEME_VERSION', $theme->Version); //gets version written in your style.css

    wp_enqueue_style( 'sage/main.css', asset_path( 'styles/main.css' ), false, THEME_VERSION );
    wp_enqueue_script( 'sage/main.js', asset_path( 'scripts/main.js' ), ['jquery'], THEME_VERSION, true );

    /** Global Vars */
    wp_localize_script( 'sage/main.js',
      'SR',
      [
        'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
        'language'     => ICL_LANGUAGE_CODE,
        'translations' => [
          'viewAll' => __( 'View All', 'sage' ),
        ],
      ]
    );
  },
  100
);

/**
 * Theme setup
 */
add_action( 'after_setup_theme',
  function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */

    add_theme_support( 'soil-clean-up' );
    add_theme_support( 'soil-jquery-cdn' );
    add_theme_support( 'soil-nav-walker' );
    add_theme_support( 'soil-nice-search' );
    add_theme_support( 'soil-relative-urls' );

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support( 'title-tag' );

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus( [
      'primary_navigation' => __( 'Primary Navigation', 'sage' ),
      'footer_navigation'  => __( 'Footer Navigation', 'sage' ),
    ] );

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support( 'html5', [ 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ] );

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support( 'customize-selective-refresh-widgets' );

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    // add_editor_style( asset_path( 'styles/editor-style.css' ) );

    /**
     * Add image sizes
     * @link https://developer.wordpress.org/reference/functions/add_image_size/
     */
    add_image_size( 'thumbnails-2800x1600', 2800, 1600, true ); /*ratio: 1.75*/
    add_image_size( 'thumbnails-2200x1400', 2200, 1400, true ); /*ratio: 1.57*/
    add_image_size( 'thumbnails-1800x1000', 1800, 1000, true ); /*ratio: 1.8*/
    add_image_size( 'thumbnails-1400x1300', 1400, 1300, true ); /*ratio: 1.08*/
    add_image_size( 'thumbnails-1400x1000', 1400, 1000, true ); /*ratio: 1.4*/
    add_image_size( 'thumbnails-1300x1000', 1300, 1000, true ); /*ratio: 1.3*/
    add_image_size( 'thumbnails-1000x1700', 1000, 1700, true );
    add_image_size( 'thumbnails-1370x1520', 1370, 1520, true ); /* Views first post featured image */
    add_image_size( 'thumbnails-900x600', 900, 600, true );     /*ratio: 1.5*/
    add_image_size( 'thumbnails-500x500', 500, 500, true );     /*ratio: 1*/
    add_image_size( 'thumbnails-200x200', 200, 200, true );     /*ratio: 1*/
  },
  20
);

/**
 * Register sidebars
 */
add_action( 'widgets_init',
  function () {
    $config = [
      'before_widget' => '<section class="widget %1$s %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3>',
      'after_title'   => '</h3>',
    ];

    register_sidebar(
      [
        'name' => __( 'Primary', 'sage' ),
        'id'   => 'sidebar-primary',
      ] + $config
    );

    register_sidebar(
      [
        'name' => __( 'Footer', 'sage' ),
        'id'   => 'sidebar-footer',
      ] + $config
    );
  }
);

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action( 'the_post',
  function ( $post ) {
    sage( 'blade' )->share( 'post', $post );
  }
);

/**
 * Setup Sage options
 */
add_action( 'after_setup_theme',
  function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton( 'sage.assets',
      function () {
        return new JsonManifest( config( 'assets.manifest' ), config( 'assets.uri' ) );
      }
    );

    /**
     * Add Blade to Sage container
     */
    sage()->singleton( 'sage.blade',
      function ( Container $app ) {
        $cachePath = config( 'view.compiled' );
        if ( ! file_exists( $cachePath ) ) {
          wp_mkdir_p( $cachePath );
        }

        ( new BladeProvider( $app ) )->register();

        return new Blade( $app['view'] );
      }
    );

    /**
     * Create @asset() Blade directive
     */
    sage( 'blade' )->compiler()->directive( 'asset',
      function ( $asset ) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
      }
    );

    /**
     * Create @asset_svg() Blade directive
     */
    sage( 'blade' )->compiler()->directive( 'asset_svg',
      function ( $asset_svg ) {
        return "<?= " . __NAMESPACE__ . "\\asset_svg_content({$asset_svg}); ?>";
      }
    );
  }
);
