<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 *
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ( $message, $subtitle = '', $title = '' ) {
  $title   = $title ?: __( 'Sage &rsaquo; Error', 'sage' );
  $footer  = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
  $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
  wp_die( $message, $title );
};

/**
 * Ensure compatible version of PHP is used
 */
if ( version_compare( '7.1', phpversion(), '>=' ) ) {
  $sage_error( __( 'You must be using PHP 7.1 or greater.', 'sage' ), __( 'Invalid PHP version', 'sage' ) );
}

/**
 * Ensure compatible version of WordPress is used
 */
if ( version_compare( '4.7.0', get_bloginfo( 'version' ), '>=' ) ) {
  $sage_error( __( 'You must be using WordPress 4.7.0 or greater.', 'sage' ), __( 'Invalid WordPress version', 'sage' ) );
}

/**
 * Ensure dependencies are loaded
 */
if ( ! class_exists( 'Roots\\Sage\\Container' ) ) {
  if ( ! file_exists( $composer = __DIR__ . '/../vendor/autoload.php' ) ) {
    $sage_error(
      __( 'You must run <code>composer install</code> from the Sage directory.', 'sage' ),
      __( 'Autoloader not found.', 'sage' )
    );
  }
  require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(
  function ( $file ) use ( $sage_error ) {
    $file = "../app/{$file}.php";
    if ( ! locate_template( $file, true, true ) ) {
      $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
  },
  [
    'constants',
    'helpers',
    'setup',
    'filters',
    'post-types',
    'admin',
    'acf-blocks',
    'ajax-actions',
    'contact-form-7',
  ]
);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
  'add_filter',
  [ 'theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri' ],
  array_fill( 0, 4, 'dirname' )
);

add_filter('wpcf7_skip_spam_check', '__return_true'); //wpcf7 was sent as spam because of reCaptcha

Container::getInstance()->bindIf( 'config',
  function () {
    return new Config( [
      'assets' => require dirname( __DIR__ ) . '/config/assets.php',
      'theme'  => require dirname( __DIR__ ) . '/config/theme.php',
      'view'   => require dirname( __DIR__ ) . '/config/view.php',
    ] );
  },
  true
);

//Enqueue the ScrollReveal main script
function themeprefix_scroll_reveal() {
  wp_enqueue_script( 'js-scrollreveal', get_stylesheet_directory_uri() . '/' . 'lib/scrollreveal/scrollreveal.min.js', [], ASSETS_VERSION, false );
}

function get_i18n() {
  return [
    'all' => __( 'All', 'sage' ),
    'view_all' => __( 'View All', 'sage' ),
    'expertise' => __( 'Expertise', 'sage' ),
    'sector' => __( 'Sector', 'sage' ),
    'Market' => __( 'Market', 'sage' ),
    'Location' => __( 'Location', 'sage' ),
    'latest_posts' => __( 'Latest Posts', 'sage' ),
    'search_results_for' => __( 'Search Results for %s', 'sage' ),
    'not_found' => __( 'Not Found', 'sage' ),
    'thank_you' => __( 'Thank You!', 'sage' ),
    'read_more' => __( 'Read more', 'sage' ),
    'required_sign_up' => __( 'Everything under this block will be hidden until user signs up', 'sage' ),
    'close' => __( 'Close', 'sage' ),
    'profile' => __( 'Profile', 'sage' ),
    'please_wait' => __( 'Please wait...', 'sage' ),
    'share_details' => __( 'Share your details for access.', 'sage' ),
    'submit' => __( 'Submit', 'sage' ),
    'build_belief' => __( 'Build belief in the future', 'sage' ),
    'sedgwick_richardson' => __( 'Sedgwick Richardson', 'sage' ),
    'search' => __( 'Search', 'sage' ),
    'pub_date' => __( 'Publication date', 'sage'),
    'in' => __('in', 'sage'),
    'more_views' => __( 'More Views', 'sage' ),
    'awards' => __( 'Awards', 'sage' ),
    'view_next_case' => __( 'View next case study', 'sage' ),
    'case_studies' => __( 'Case Studies', 'sage' ),
    'our_partners' => __( 'Our Partners', 'sage' ),
    'back_home' => __( 'Back to home', 'sage' ),
    'problem_contact' => __( 'Still a problem? Please contact us at:', 'sage' ),
    'page_unavailable' => __( 'Sorry. The page you’re looking for isn’t available.', 'sage' ),
    'add_linkedin' => __( 'Add me on LinkedIn', 'sage' ),
    'copied_to_clipboard' => __('You have copied the link to clipboard!', 'sage'),
    'copied_address_to_clipboard' => __('Copied Address to clipboard', 'sage'),
    'open_positions' => __('Open Positions', 'sage'),
   
    //jobs.js
    'results_in' => __('Results in ', 'sage'),
    'other_search_results' => __('other search results', 'sage'),
    'view_all_in' => __('View all in ', 'sage'),
    'results' => __('results', 'sage'),
    'work' => __('Work', 'sage'),
    'views' => __('Views', 'sage'),
    'people' => __('People', 'sage'),
    'jobs' => __('Jobs', 'sage'),
    'pages' => __('Pages', 'sage'),
    'work_with_us' => __( 'Work with Us: ', 'sage'),
  ];
}

/* Register translate text on wpml */
__( 'All', 'sage' );
__( 'View All', 'sage' );
__( 'View all', 'sage' );
__( 'Latest Posts', 'sage' );
__( 'Search Results for %s', 'sage' );
__( 'Not Found', 'sage' );
__( 'Thank You!', 'sage' );
__( 'Read more', 'sage' );
__( 'Everything under this block will be hidden until user signs up', 'sage' );
__( 'Close', 'sage' );
__( 'Profile', 'sage' );
__( 'Please wait...', 'sage' );
__( 'Share your details for access.', 'sage' );
__( 'Submit', 'sage' );
__( 'Build belief in the future', 'sage' );
__( 'Sedgwick Richardson', 'sage' );
__( 'Search', 'sage' );
__( 'Publication date', 'sage');
__('in', 'sage');
__( 'More Insights', 'sage' );
__( 'Awards', 'sage' );
__( 'View next case study', 'sage' );
__( 'Case Studies', 'sage' );
__( 'Our Partners', 'sage' );
__( 'Back to home', 'sage' );
__( 'Still a problem? Please contact us at:', 'sage' );
__( 'Sorry. The page you’re looking for isn’t available.', 'sage' );
__( 'Add me on LinkedIn', 'sage' );
__('You have copied the link to clipboard!', 'sage');
__('Copied Address to clipboard', 'sage');
__('Results in ', 'sage');
__('other search results', 'sage');
__('View all in ', 'sage');
__('results', 'sage');
__('Work', 'sage');
__('Views', 'sage');
__('People', 'sage');
__('Jobs', 'sage'); 
__('Pages', 'sage');
__( 'Sector', 'sage' );
__( 'Market', 'sage' );
__( 'Location', 'sage' );
__( 'Expertise', 'sage' );
__( 'Work with Us: ', 'sage');
__( 'View More Work', 'sage');
__( 'Contact Us', 'sage');
__( 'What Our Clients Say About Us', 'sage' );
__( 'Insights', 'sage' );
__( 'View More Insights', 'sage' );
__( 'Featured', 'sage' );
__( 'Learn More', 'sage' );
__( 'Challenge', 'sage' );
__( 'Solution', 'sage' );
__( 'Outcomes', 'sage' );
__( 'Ready to show the world why your brand matters?', 'sage' );
__( 'Get In Touch', 'sage' );
__('Let\'s Talk', 'sage');