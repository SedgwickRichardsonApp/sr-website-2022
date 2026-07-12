<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use function App\get_all_posts;
use function App\get_primary_term;

class TemplateCareers extends Controller {
    public function hero() {
        $hello_words_arr = ['']; // initiliaze with empty string value for the Typing animation
        $hero_images_arr = [];
        if ( ! empty( $hello_words = get_field( 'hello_words' ) ) && is_array( $hello_words ) ) {
            foreach ( $hello_words as $item ) {

                $hello_words_arr[] = $item['hello_word'];
            }
        }

        if ( ! empty( $hero_images = get_field( 'hero_images' ) ) && is_array( $hero_images ) ) {
            foreach ( $hero_images as $image ) {
                if ( ! empty( $image ) && is_array( $image ) ) {
                    $hero_images_arr[] = $image['sizes']['thumbnails-1300x1000'];
                }
            }
        }

        return [
            'hello_words'         => $hello_words_arr,
            'hero_images'         => $hero_images_arr,
        ];
    }

    public function being_sr() {
        return [
            'title'       => html_entity_decode( get_field('being_sr_title') ),
            'description' => get_field('being_sr_description'),
            'our_values_title' => html_entity_decode( get_field('our_values_title') ),
            'our_values_description' => get_field('our_values_description'),
        ];
    }

    public function open_positions() {
        $grouped_positions = [];
        $jobs = get_all_posts( 'cpt-jobs' ); // 假设这是你自定义的获取文章函数

        foreach( $jobs as $job ) {
            // --- 1. 获取分类数据 ---
            $location_term  = get_primary_term($job->ID, 'cpt_jobs_location');
            $work_type_term = get_primary_term($job->ID, 'cpt_jobs_work_type');

            // 容错处理：确保没有 Term 时显示默认值
            $location_name  = isset($location_term->name) ? $location_term->name : 'Other';
            // 移除多余空格，确保作为 Array Key 时不出错
            $location_key   = trim($location_name);

            // --- 2. 初始化分组 (如果该地点不存在) ---
            if ( ! isset( $grouped_positions[ $location_key ] ) ) {
                $grouped_positions[ $location_key ] = [
                    'location' => $location_name,  // 组的大标题 (例如: Hong Kong)
                    'list'     => [],              // 该组下的职位列表
                ];
            }

            // --- 3. 填充职位数据 ---
            $grouped_positions[ $location_key ]['list'][] = [
                'id'        => $job->ID,
                'job_title' => $job->post_title,   // 改名为 job_title 更清晰
                'work_type' => isset($work_type_term->name) ? $work_type_term->name : '',
                // 只需要存跟职位相关的，地点已经在父级了
            ];
        }

        // --- 4. 排序 ---
        // 按地点名称 A-Z 排序 (Hong Kong -> Manila -> Saigon -> Singapore)
        ksort($grouped_positions);

        return [
            // 使用 array_values 将关联数组转为索引数组 [ {location:..., list:[...]}, {...} ]
            // 这样前端 Blade 循环更简单，且保留了 ksort 的排序结果
            'position_groups'       => array_values( $grouped_positions ),

            'general_contact_text'  => html_entity_decode( get_field('open_positions_general_contact_text') ),
            'general_contact_email' => get_field('open_positions_general_contact_email'),
        ];
    }
}
