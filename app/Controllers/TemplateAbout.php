<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use function App\get_all_posts;

class TemplateAbout extends Controller {
  public function hero() {
    $title                          = html_entity_decode( get_the_title() );
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
      'title'                      => $title,
      'animation_json_file'        => $animation_json_file_url,
      'mobile_animation_json_file' => $mobile_animation_json_file_url,
    ];
  }

  public function intro() {
    return [
      'title' => get_field( 'intro_title' ),
    ];
  }

//  public function team() {
//    $people      = get_all_posts( 'cpt-people', [], [], [ 'orderby' => 'menu_order' ] );
//    $members_arr = [];
//
//    if ( ! empty( $people ) ) {
//      foreach( $people as $item ) {
//        $people_id = $item->ID;
//        $image_url = '';
//
//        if ( has_post_thumbnail( $people_id ) ) {
//          $image_url = get_the_post_thumbnail_url( $people_id, 'thumbnails' );
//        }
//        $content = strlen(get_post( $people_id )->post_content);
//
//        $members_arr[] = [
//          'id'        => $people_id,
//          'title'     => html_entity_decode( get_the_title( $people_id ) ),
//          'image'     => $image_url,
//          'position'  => get_field( 'position', $people_id ),
//          'team'      => get_field( 'team_member', $people_id ),
//          'content'   => $content,
//        ];
//      }
//    }
//    var_dump($members_arr);
//    return [
//      'title'       => html_entity_decode( get_field( 'team_title' ) ),
//      'description' => get_field( 'team_description' ),
//      'members'     => $members_arr,
//    ];
//  }

    public function team() {
        // 1. 获取所有有员工的部门 (Departments)
        // 注意：taxonomy 必须填你之前注册的那个 ID 'cpt_people_department'
        $departments = get_terms([
            'taxonomy'   => 'cpt_people_department',
            'hide_empty' => true, // 如果部门没人，就不显示
//            'meta_key'   => 'order_number',   // ACF 字段名
//            'orderby'    => 'meta_value_num', // 按数字大小排序
//            'order'      => 'DESC',            // 从小到大
        ]);

        // 2. 使用 PHP 手动排序
        if ( ! empty( $departments ) && ! is_wp_error( $departments ) ) {
            usort( $departments, function( $a, $b ) {
                // 获取 ACF 字段值，注意：Taxonomy 获取 ACF 需要拼接 'taxonomy_ID'
                // 如果没填， ?: 0 会给它一个默认值 0
                $ord_a = (int) get_field( 'order_number', $a ) ?: 0;
                $ord_b = (int) get_field( 'order_number', $b ) ?: 0;

                // 开始比较：DESC (从大到小)
                if ( $ord_a == $ord_b ) {
                    return 0;
                }
                return ( $ord_a < $ord_b ) ? 1 : -1;

                // 如果你想改成 ASC (从小到大)，把上面一行改成：
                // return ( $ord_a < $ord_b ) ? -1 : 1;
            });
        }

        $sections_arr = [];

        // 2. 循环每个部门
        if ( ! empty( $departments ) && ! is_wp_error( $departments ) ) {
            foreach ( $departments as $term ) {

                // 3. 查询属于当前部门的 People
                $args = [
                    'post_type'      => 'cpt-people',
                    'posts_per_page' => -1, // 取出所有
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                    'tax_query'      => [
                        [
                            'taxonomy' => 'cpt_people_department',
                            'field'    => 'slug',
                            'terms'    => $term->slug, // 根据当前部门 slug 筛选
                        ]
                    ]
                ];

                // 这里建议直接用原生 get_posts 以确保 tax_query 生效
                // 如果你的 get_all_posts 支持 tax_query 参数也可以用那个
                $people_in_dept = get_posts( $args );

                $members_arr = []; // 当前部门的员工列表

                if ( ! empty( $people_in_dept ) ) {
                    foreach( $people_in_dept as $item ) {
                        $people_id = $item->ID;
                        $image_url = '';

                        if ( has_post_thumbnail( $people_id ) ) {
                            $image_url = get_the_post_thumbnail_url( $people_id, 'full' ); // 建议改大一点，thumbnail可能太糊
                        }

                        // 注意：这里不用再取 'team_member' 这个旧字段了

                        $members_arr[] = [
                            'id'        => $people_id,
                            'title'     => html_entity_decode( get_the_title( $people_id ) ),
                            'image'     => $image_url,
                            'position'  => get_field( 'position', $people_id ),
                            'content'   => strlen( $item->post_content ),
                        ];
                    }
                }

                // 4. 将当前部门及其员工放入主数组
                if ( ! empty( $members_arr ) ) {
                    $sections_arr[] = [
                        'dept_name' => $term->name, // 部门名称 (如 "技术团队")
                        'dept_slug' => $term->slug, // 部门代码 (如 "tech-team")
                        'members'   => $members_arr // 该部门下的员工数组
                    ];
                }
            }
        }

//         var_dump($sections_arr); // 调试用，可以看到现在的结构变成了两层

        return [
            'title'       => html_entity_decode( get_field( 'team_title' ) ),
            'description' => get_field( 'team_description' ),
            'sections'    => $sections_arr, // 注意：我把 key 从 'members' 改成了 'sections' 以区分结构变化
        ];
    }
}
