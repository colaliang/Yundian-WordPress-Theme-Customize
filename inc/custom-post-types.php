<?php
/**
 * Custom Post Types
 *
 * NOTE: Products are managed via WooCommerce (product / product_cat).
 * No custom product CPT is needed.
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) exit;

/**
 * Register Case Study post type
 */
add_action('init', 'erdu_register_case_post_type');
function erdu_register_case_post_type()
{
    $labels = array(
        'name'                  => _x('Case Studies', 'Post type general name', 'erdu-wp'),
        'singular_name'         => _x('Case Study', 'Post type singular name', 'erdu-wp'),
        'menu_name'             => _x('Case Studies', 'Admin Menu text', 'erdu-wp'),
        'add_new'               => __('Add New', 'erdu-wp'),
        'add_new_item'          => __('Add New Case Study', 'erdu-wp'),
        'edit_item'             => __('Edit Case Study', 'erdu-wp'),
        'new_item'              => __('New Case Study', 'erdu-wp'),
        'view_item'             => __('View Case Study', 'erdu-wp'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-portfolio',
        'menu_position'      => 6,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'case-study'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('erdu_case', $args);

    // Case Study Industry
    register_taxonomy('erdu_case_industry', 'erdu_case', array(
        'labels'            => array(
            'name'          => __('Industries', 'erdu-wp'),
            'singular_name' => __('Industry', 'erdu-wp'),
        ),
        'hierarchical'      => true,
        'public'            => true,
        'rewrite'           => array('slug' => 'case-industry'),
    ));
}

/**
 * Register News post type
 */
add_action('init', 'erdu_register_news_post_type');
function erdu_register_news_post_type()
{
    $labels = array(
        'name'                  => _x('News', 'Post type general name', 'erdu-wp'),
        'singular_name'         => _x('News', 'Post type singular name', 'erdu-wp'),
        'menu_name'             => _x('News', 'Admin Menu text', 'erdu-wp'),
        'add_new'               => __('Add New', 'erdu-wp'),
        'add_new_item'          => __('Add New Article', 'erdu-wp'),
        'edit_item'             => __('Edit Article', 'erdu-wp'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-format-aside',
        'menu_position'      => 7,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'news'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('erdu_news', $args);

    // News Category
    register_taxonomy('erdu_news_cat', 'erdu_news', array(
        'labels'            => array(
            'name'          => __('News Categories', 'erdu-wp'),
            'singular_name' => __('News Category', 'erdu-wp'),
        ),
        'hierarchical'      => true,
        'public'            => true,
        'rewrite'           => array('slug' => 'news-category'),
    ));
}

/**
 * Register Exhibition post type
 */
add_action('init', 'erdu_register_exhibition_post_type');
function erdu_register_exhibition_post_type()
{
    $labels = array(
        'name'                  => _x('Exhibitions', 'Post type general name', 'erdu-wp'),
        'singular_name'         => _x('Exhibition', 'Post type singular name', 'erdu-wp'),
        'menu_name'             => _x('Exhibitions', 'Admin Menu text', 'erdu-wp'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-calendar-alt',
        'menu_position'      => 8,
        'rewrite'            => array('slug' => 'exhibition'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'supports'           => array('title', 'editor', 'thumbnail'),
    );

    register_post_type('erdu_exhibition', $args);
}

/**
 * Register Downloads post type (Documents, Files)
 * Supports: docx, xlsx, pdf, txt, ies, 3d and other non-media file formats
 */
add_action('init', 'erdu_register_download_post_type');
function erdu_register_download_post_type()
{
    $labels = array(
        'name'                  => _x('Downloads', 'Post type general name', 'erdu-wp'),
        'singular_name'         => _x('Download', 'Post type singular name', 'erdu-wp'),
        'menu_name'             => _x('Downloads', 'Admin Menu text', 'erdu-wp'),
        'add_new'               => __('Add New', 'erdu-wp'),
        'add_new_item'          => __('Add New Download', 'erdu-wp'),
        'edit_item'             => __('Edit Download', 'erdu-wp'),
        'new_item'              => __('New Download', 'erdu-wp'),
        'view_item'             => __('View Download', 'erdu-wp'),
        'search_items'          => __('Search Downloads', 'erdu-wp'),
        'not_found'             => __('No downloads found', 'erdu-wp'),
        'all_items'             => __('All Downloads', 'erdu-wp'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,          // No public archive, accessed via About page
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-download',
        'menu_position'      => 10,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'supports'           => array('title'),
    );

    register_post_type('erdu_download', $args);

    // Download Category
    register_taxonomy('erdu_download_cat', 'erdu_download', array(
        'labels'            => array(
            'name'          => __('Download Categories', 'erdu-wp'),
            'singular_name' => __('Download Category', 'erdu-wp'),
        ),
        'hierarchical'      => true,
        'public'            => false,
        'show_ui'           => true,
    ));
}

/**
 * Allow additional file types to be uploaded in WordPress
 */
add_filter('upload_mimes', 'erdu_allow_custom_upload_mimes');
function erdu_allow_custom_upload_mimes($mimes)
{
    $mimes['docx']  = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    $mimes['doc']   = 'application/msword';
    $mimes['xlsx']  = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    $mimes['xls']   = 'application/vnd.ms-excel';
    $mimes['pdf']   = 'application/pdf';
    $mimes['txt']   = 'text/plain';
    $mimes['ies']   = 'application/octet-stream';
    $mimes['3d']    = 'application/octet-stream';
    $mimes['dwg']   = 'application/octet-stream';
    $mimes['dxf']   = 'application/octet-stream';
    $mimes['stp']   = 'application/step';
    $mimes['step']  = 'application/step';
    $mimes['zip']   = 'application/zip';
    $mimes['rar']   = 'application/octet-stream';
    return $mimes;
}

