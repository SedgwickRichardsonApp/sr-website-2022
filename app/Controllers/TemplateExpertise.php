<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use function App\get_all_posts;
use function App\get_page_id_by_template;

class TemplateExpertise extends Controller {
  public function hero() {
    $title                          = get_the_title();
    $animation_json_file_url        = '';
    $mobile_animation_json_file_url = '';

    if ( ! empty( $hero_title = get_field( 'hero_title' ) ) ) {
      $title = $hero_title;
    }

    if ( ! empty( $hero_animation_json_file = get_field( 'hero_animation_json_file' ) ) && is_array( $hero_animation_json_file ) ) {
      $animation_json_file_url = $hero_animation_json_file['url'];
    }

    if ( ! empty( $hero_mobile_animation_json_file = get_field( 'hero_mobile_animation_json_file' ) ) && is_array( $hero_mobile_animation_json_file ) ) {
      $mobile_animation_json_file_url = $hero_mobile_animation_json_file['url'];
    }

    return [
      'title'                      => html_entity_decode( $title ),
      'subtitle'                   => html_entity_decode( get_field( 'hero_subtitle' ) ),
      'animation_json_file'        => $animation_json_file_url,
      'mobile_animation_json_file' => $mobile_animation_json_file_url,
      'slug'                       => get_post_field( 'post_name', get_post() ),
    ];
  }

  public function navigation_items() {
    $extra_args = [
      'post_parent' => wp_get_post_parent_id(),
      'orderby'     => 'menu_order',
    ];

    $sibling_pages = get_all_posts( 'page', [], [], $extra_args );

    if ( ! empty( $sibling_pages ) ) {
      $navigation_items = [];

      foreach ( $sibling_pages as $page ) {
        $item_id = $page->post_name;
        $page_id = $page->ID;
        $menu_title = get_field( 'menu_title', $page_id);

        if( strtolower($item_id) != 'creating-value'){
          $navigation_items[] = [
            'menu_title' => $menu_title,
            'title'  => html_entity_decode( get_the_title( $page_id ) ),
            'active' => $page_id === get_the_ID(),
            'item_id'=> $page->post_name,
            'link'   => get_permalink( $page_id ),
          ];
        }
      }

      return array_values( $navigation_items );
    }

    return [];
  }

  public function related_works() {
    if ( ! empty( $related_works = get_field( 'related_works' ) ) && is_array( $related_works ) ) {
      $work_page_id      = get_page_id_by_template( 'views/template-work.blade.php' );
      $related_works_arr = [];

      foreach ( $related_works as $work ) {

        if ( !empty( $work['work'] ) && get_post_status( $work['work']->ID ) === 'publish' ) {
          $work_id   = $work['work']->ID;
          $image_url = '';

          if ( has_post_thumbnail( $work_id ) ) {
            $image_url = get_the_post_thumbnail_url( $work_id, 'thumbnails-1400x1000'  );
            if(pathinfo($image_url, PATHINFO_EXTENSION) == 'gif'){
              $image_url = get_the_post_thumbnail_url( $work_id, 'full' );
            }
          }

          $related_works_arr[] = [
            // 'view_all'    => true,
            'title'       => html_entity_decode( get_the_title( $work_id ) ),
            'client_name' => html_entity_decode( get_field( 'client_name', $work_id ) ),
            'image'       => $image_url,
            'link'        => get_permalink( $work_id ),
            'cursor_icon' => get_field('cursor-icon', $work_id),
            'status' => get_post_status( $work['work']->ID ),
          ];
        }
      }

      return array_values( $related_works_arr );
    }

    return [];
  }

  public function related_views() {
    if ( ! empty( $related_views = get_field( 'related_views' ) ) && is_array( $related_views ) ) {
      $view_page_id      = get_page_id_by_template( 'views/template-view.blade.php' );
      $related_views_arr = [];

      foreach ( $related_views as $view ) {
        if ( ! empty( $view['view'] ) && get_post_status( $view['view']->ID ) === 'publish' ) {
          $view_id   = $view['view']->ID;
          $image_url = '';

          if ( has_post_thumbnail( $view_id ) ) {
            $image_url = get_the_post_thumbnail_url( $view_id, 'thumbnails-1400x1000'  );
            if(pathinfo($image_url, PATHINFO_EXTENSION) == 'gif'){
              $image_url = get_the_post_thumbnail_url( $view_id, 'full' );
            }
          }

          $related_views_arr[] = [
            // 'view_all'    => true,
            'title'       => html_entity_decode( get_the_title( $view_id ) ),
            'image'       => $image_url,
            'link'        => get_permalink( $view_id ),
            'cursor_icon' => get_field('cursor-icon', $view_id),
          ];
        }
      }

      return array_values( $related_views_arr );
    }

    return [];
  }

  public function partners() {
    if ( ! empty( $partners = get_field( 'partners' ) ) && is_array( $partners ) ) {
      $partners_arr = [];

      foreach ( $partners as $partner ) {
        $image_url = '';

        if ( ! empty( $partner['image'] ) && is_array( $partner['image'] ) ) {
          $image_url = $partner['image']['url'];
        }

        $partners_arr[] = [
          'image' => $image_url,
          'link'  => $partner['link'],
        ];
      }

      return array_values( $partners_arr );
    }

    return [];
  }
}
