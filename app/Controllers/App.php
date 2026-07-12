<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller {
  public function site_name() {
    return get_bloginfo( 'name' );
  }

  public function title() {
    if ( is_home() ) {
      if ( $home = get_option( 'page_for_posts', true ) ) {
        return html_entity_decode( get_the_title( $home ) );
      }

      return __( 'Latest Posts', 'sage' );
    }
    if ( is_archive() ) {
      return html_entity_decode( get_the_archive_title() );
    }
    if ( is_search() ) {
      return sprintf( __( 'Search Results for %s', 'sage' ), get_search_query() );
    }
    if ( is_404() ) {
      return __( 'Not Found', 'sage' );
    }

    return html_entity_decode( get_the_title() );
  }

  public function permalink() {
    return get_permalink();
  }

  public function content() {
    global $post;

    if ( $post ) {
      setup_postdata( $post );

      return get_the_content();
    }

    return '';
  }

  public function language() {
    return ICL_LANGUAGE_CODE;
  }

  public function languages() {
    $languages = icl_get_languages( 'skip_missing=1&orderby=code&order=desc' );

    if ( ! empty( $languages ) && is_array( $languages ) ) {
      return array_map(
        function ( $language ) {
          $label    = '';

          if ( ! empty( $language['language_code'] ) ) {
            switch ( $language['language_code'] ) {
              case 'en':
                $label = 'EN';
                break;
              case 'vi':
                $label = 'VI';
                break;
              case 'zh':
                $label = '中';
                break;
              default:
                break;
            }
          }

          return [
            'active' => $language['active'],
            'label'  => $label,
            'url'    => $language['url'],
          ];
        },
        $languages
      );
    }

    return [];
  }

  public function contact() {
    $form_html = '';

    if ( ! empty( $contact_form = get_field( 'contact_form', 'options' ) ) ) {
      $form_html = do_shortcode( '[contact-form-7 id="' . absint( $contact_form->ID ) . '"]' );
    }

    return [
      'title'             => get_field( 'contact_title', 'options' ),
      'form'              => $form_html,
      'thank_you_message' => get_field( 'contact_thank_you_message', 'options' ),
    ];
  }

  public function custom_form() {
    $form_html = '';

    if ( ! empty( $custom_form = get_field( 'custom_form', 'options' ) ) ) {
      $form_html = do_shortcode( '[contact-form-7 id="' . absint( $custom_form->ID ) . '"]' );
    }

    return [
      'heading'           => get_field( 'custom_form_heading', 'options' ),
      'subheading'        => get_field( 'custom_form_subheading', 'options' ),
      'form'              => $form_html,
      'thank_you_message' => get_field( 'custom_form_thank_you_message', 'options' ),
    ];
  }

  public function newsletter() {
    $form_html = '';

    if ( ! empty( $newsletter_form = get_field( 'newsletter_form', 'options' ) ) ) {
      $form_html = do_shortcode( '[contact-form-7 id="' . absint( $newsletter_form->ID ) . '"]' );
    }

    return [
      'title'           => get_field( 'newsletter_title', 'options' ),
      'form'            => $form_html,
      'cta_small_title' => html_entity_decode( get_field( 'newsletter_cta_small_title', 'options' ) ),
      'cta_title'       => html_entity_decode( get_field( 'newsletter_cta_title', 'options' ) ),
    ];
  }

  public function social() {
    return [
      'linkedin_url' => get_field( 'social_linkedin_url', 'options' ),
      'wechat_url' => get_field('social_wechat_url', 'options'),
      'facebook_url' => get_field('social_facebook_url', 'options'),
    ];
  }

  public function page_contact() {
    return [
      '404_email' => get_field( '404_contact_email', 'options' ),
    ];
  }

}
