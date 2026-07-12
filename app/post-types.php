<?php

namespace App;

/**
 * Register post type - Work
 */
add_action( 'init',
  function () {
    $slug   = 'work';
    $labels = array(
      'name'               => _x( 'Work', 'post type general name' ),
      'singular_name'      => _x( 'Work', 'post type singular name' ),
      'add_new'            => _x( 'Add Work', 'rep' ),
      'add_new_item'       => __( 'Add New Work' ),
      'edit_item'          => __( 'Edit Work' ),
      'new_item'           => __( 'New Work' ),
      'view_item'          => __( 'View Work' ),
      'search_items'       => __( 'Search Work' ),
      'not_found'          => __( 'Nothing found' ),
      'not_found_in_trash' => __( 'Nothing found in Trash' ),
      'parent_item_colon'  => '',
    );
    $args = array(
      'labels'             => $labels,
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array( 'slug' => $slug ),
      'capability_type'    => 'post',
      'hierarchical'       => true,
      'menu_position'      => null,
      'menu_icon'          => 'dashicons-building',
      'show_in_rest'       => true,
      'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
      'has_archive'        => false,
    );
    register_post_type( 'cpt-work', $args );

    register_taxonomy(
      'cpt_work_location',
      array( 'cpt-work' ),
      array(
        'query_var'         => true,
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'label'             => __( 'Location' ),
      )
    );

    register_taxonomy(
      'cpt_work_sector',
      array( 'cpt-work' ),
      array(
        'query_var'         => true,
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'label'             => __( 'Sector' ),
      )
    );

    register_taxonomy(
      'cpt_work_expertise',
      array( 'cpt-work' ),
      array(
        'query_var'         => true,
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'label'             => __( 'Expertise' ),
      )
    );

    register_taxonomy(
      'cpt_work_service',
      array( 'cpt-work' ),
      array(
        'query_var'         => true,
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'label'             => __( 'Service' ),
      )
    );
  }
);

/**
 * Register post type - Views
 */
add_action( 'init',
  function () {
    $slug   = 'views';
    $labels = array(
      'name'               => _x( 'Views', 'post type general name' ),
      'singular_name'      => _x( 'View', 'post type singular name' ),
      'add_new'            => _x( 'Add View', 'rep' ),
      'add_new_item'       => __( 'Add New View' ),
      'edit_item'          => __( 'Edit View' ),
      'new_item'           => __( 'New View' ),
      'view_item'          => __( 'View View' ),
      'search_items'       => __( 'Search View' ),
      'not_found'          => __( 'Nothing found' ),
      'not_found_in_trash' => __( 'Nothing found in Trash' ),
      'parent_item_colon'  => '',
    );
    $args = array(
      'labels'             => $labels,
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array( 'slug' => $slug ),
      'capability_type'    => 'post',
      'hierarchical'       => true,
      'menu_position'      => null,
      'menu_icon'          => 'dashicons-visibility',
      'show_in_rest'       => true,
      'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
      'has_archive'        => false,
    );
    register_post_type( 'cpt-views', $args );

    register_taxonomy(
      'cpt_views_category',
      array( 'cpt-views' ),
      array(
        'query_var'         => true,
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'label'             => __( 'Category' ),
      )
    );

    register_taxonomy(
      'cpt_views_author',
      array( 'cpt-views' ),
      array(
        'query_var'         => true,
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'label'             => __( 'Author' ),
      )
    );
  }
);

/**
 * Register post type - Testimonials
 */
add_action( 'init',
  function () {
    $slug   = 'testimonials';
    $labels = array(
      'name'               => _x( 'Testimonial', 'post type general name' ),
      'singular_name'      => _x( 'Testimonials', 'post type singular name' ),
      'add_new'            => _x( 'Add Testimonial', 'rep' ),
      'add_new_item'       => __( 'Add New Testimonial' ),
      'edit_item'          => __( 'Edit Testimonial' ),
      'new_item'           => __( 'New PeopTestimonialle' ),
      'view_item'          => __( 'View Testimonial' ),
      'search_items'       => __( 'Search Testimonial' ),
      'not_found'          => __( 'Nothing found' ),
      'not_found_in_trash' => __( 'Nothing found in Trash' ),
      'parent_item_colon'  => '',
    );
    $args = array(
      'labels'             => $labels,
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array( 'slug' => $slug ),
      'capability_type'    => 'post',
      'hierarchical'       => true,
      'menu_position'      => null,
      'menu_icon'          => 'dashicons-businessman',
      'show_in_rest'       => true,
      'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
      'has_archive'        => false,
    );
    register_post_type( 'cpt-testimonials', $args );
  }
);

/**
 * Register post type - People
 */
add_action( 'init',
  function () {
    $slug   = 'people';
    $labels = array(
      'name'               => _x( 'People', 'post type general name' ),
      'singular_name'      => _x( 'People', 'post type singular name' ),
      'add_new'            => _x( 'Add People', 'rep' ),
      'add_new_item'       => __( 'Add New People' ),
      'edit_item'          => __( 'Edit People' ),
      'new_item'           => __( 'New People' ),
      'view_item'          => __( 'View People' ),
      'search_items'       => __( 'Search People' ),
      'not_found'          => __( 'Nothing found' ),
      'not_found_in_trash' => __( 'Nothing found in Trash' ),
      'parent_item_colon'  => '',
    );
    $args = array(
      'labels'             => $labels,
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array( 'slug' => $slug ),
      'capability_type'    => 'post',
      'hierarchical'       => true,
      'menu_position'      => null,
      'menu_icon'          => 'dashicons-businessman',
      'show_in_rest'       => true,
      'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
      'has_archive'        => false,
    );
    register_post_type( 'cpt-people', $args );

      // 👇 在这里插入新分类法 Departments
      register_taxonomy(
          'cpt_people_department', // 数据库里的分类ID
          array( 'cpt-people' ),   // 绑定到 People 这个文章类型
          array(
              'query_var'         => true,
              'public'            => true,
              'hierarchical'      => true, // true = 像“分类目录”有层级；false = 像“标签”
              'show_in_rest'      => true, // 必须开启，否则古登堡编辑器里不显示
              'show_admin_column' => true, // 在文章列表页显示这一列
              'label'             => __( 'Departments' ),
              'labels'            => array(
                  'name'              => __( 'Departments' ),
                  'singular_name'     => __( 'Department' ),
                  'menu_name'         => __( 'Departments' ),
                  'all_items'         => __( 'All Departments' ),
                  'edit_item'         => __( 'Edit Department' ),
                  'view_item'         => __( 'View Department' ),
                  'update_item'       => __( 'Update Department' ),
                  'add_new_item'      => __( 'Add New Department' ),
                  'new_item_name'     => __( 'New Department Name' ),
                  'search_items'      => __( 'Search Departments' ),
              ),
              'rewrite'           => array( 'slug' => 'department' ), // 前端URL后缀
          )
      );
  }
);

/**
 * Register post type - Jobs
 */
add_action( 'init',
  function () {
    $slug   = 'jobs';
    $labels = array(
      'name'               => _x( 'Jobs', 'post type general name' ),
      'singular_name'      => _x( 'Job', 'post type singular name' ),
      'add_new'            => _x( 'Add Job', 'rep' ),
      'add_new_item'       => __( 'Add New Job' ),
      'edit_item'          => __( 'Edit Job' ),
      'new_item'           => __( 'New Job' ),
      'view_item'          => __( 'View Job' ),
      'search_items'       => __( 'Search Job' ),
      'not_found'          => __( 'Nothing found' ),
      'not_found_in_trash' => __( 'Nothing found in Trash' ),
      'parent_item_colon'  => '',
    );
    $args = array(
      'labels'             => $labels,
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array( 'slug' => $slug ),
      'capability_type'    => 'post',
      'hierarchical'       => true,
      'menu_position'      => null,
      'menu_icon'          => 'dashicons-id',
      'show_in_rest'       => true,
      'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
      'has_archive'        => false,
    );
    register_post_type( 'cpt-jobs', $args );

    register_taxonomy(
      'cpt_jobs_location',
      array( 'cpt-jobs' ),
      array(
        'query_var'    => true,
        'public'       => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'label'        => __( 'Location' ),
      )
    );

    register_taxonomy(
      'cpt_jobs_work_type',
      array( 'cpt-jobs' ),
      array(
        'query_var'    => true,
        'public'       => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'label'        => __( 'Work Type' ),
      )
    );
  }
);
