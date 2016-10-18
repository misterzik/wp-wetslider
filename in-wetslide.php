<?php
/*
    Plugin Name: Wet-Slider Wordpress Carousel Plugin
    Description: WordPress Quick WetSlider with class for your blog.
    Author: Insanen Team - http://insanen.com
    Version: 1.0.2
*/

/**
 *  @version	1.0.2
 */

if (!defined('WPINC')) {
    die('No script kiddies please!');
}

function in_register_scripts()
{
    if (!is_admin()) {
        wp_register_script('in_minerva', plugins_url('includes/lib/minervajs/minerva.min.js', __FILE__));
        wp_register_style('in_wetcss', plugins_url('includes/css/style.min.css', __FILE__));
        wp_enqueue_script('in_minerva');
        wp_enqueue_style('in_wetcss');
    } else {
        wp_register_style('in_wetcss', plugins_url('includes/css/style.min.css', __FILE__));
        wp_enqueue_style('in_wetcss');
    }
}

function in_register_styles()
{
    wp_register_style('in_minerva_css', plugins_url('includes/lib/minervajs/minerva.min.css', __FILE__));
    wp_register_style('in_wetcss', plugins_url('includes/css/style.min.css', __FILE__));
    wp_enqueue_style('in_minerva_css');
    wp_enqueue_style('in_wetcss');
}

function in_function($type = 'in_function')
{
    $args = array(
      'post_type' => 'wet-slider',
      'posts_per_page' => 5,
    );

    $result .= '<div class="wrapper-minerva">';
    $result .= '<div class="container-minerva">';
    $result .= '<ul id="slider-minerva">';

    $loop = new WP_Query($args);
    while ($loop->have_posts()) : $loop->the_post();
    $the_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $type);
    $result .= '<li><img title="'.get_the_title().'" src="'.$the_url[0].'" data-thumb="'.$the_url[0].'" alt=""/></li>';

    endwhile;
    wp_reset_postdata();

    $result .= '<div id="controllers-minerva">';
    $result .= '<button id="prev-minerva"><</button>';
    $result .= '<button id="next-minerva">></button>';

    $result .= '</div>';
    $result .= '</ul>';
    $result .= '</div>';
    $result .= '</div>';

    return $result;
}

function in_init()
{
      $labels = array(
      'name' => _x('WetSlider Lite', 'wet_slider'),
      'singular_name' => _x('Wet-Slider', 'wet_slider'),
      'add_new' => _x('Add New WetSlider', 'wet_slider'),
      'add_new_item' => _x('Add New WetSlider', 'wet_slider'),
      'edit_item' => _x('Edit WetSlider', 'wet_slider'),
      'new_item' => _x('New WetSlider', 'wet_slider'),
      'view_item' => _x('View WetSlider', 'wet_slider'),
      'search_items' => _x('Search WetSlider', 'wet_slider'),
      'not_found' => _x('No WetSliders found', 'wet_slider'),
      'not_found_in_trash' => _x('No WetSliders found in Trash', 'wet_slider'),
      'parent_item_colon' => _x('Parent WetSlider:', 'wet_slider'),
      'menu_name' => _x('Wet Sliders', 'wet_slider'),
  );

    add_shortcode('wetslider', 'in_function');
    add_image_size('in_widget', 180, 100, true);
    add_image_size('in_function', 600, 200, true);

    $args = array('public' => true,
    'labels' => $labels,
    'supports' => array('title', 'thumbnail'),
    'hierarchical' => true,
    'taxonomies' => array('categories'),
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'menu_icon' => 'dashicons-format-gallery',
    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => true,
    'query_var' => true,
    'can_export' => true,
    'rewrite' => true,
    'capability_type' => 'post',
);
    register_post_type('wet-slider', $args);
}

function in_cat_taxonomy()
{
    register_taxonomy(
        'categories',
        'wet_slider',
        array(
            'hierarchical' => true,
            'label' => 'Categories',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'categories',
                'with_front' => false,
            ),
        )
    );
}

function in_mb_add()
{
    add_meta_box('my-meta-box-id2', 'Insanen.com Classifieds:', 'in_mb2', 'wet-slider', 'normal', 'high');
    add_meta_box('my-meta-box-id', 'Plugin Information :', 'in_mb', 'wet-slider', 'normal', 'high');
}

function in_mb()
{
    echo '<a href="http://insanen.com/learn" target="_blank" title="Insanen Solutions - Media Agency"><img class="WSimg" src="http://insanen.com/images/insanen-728x90-web.png" style="width: 100%;"></a>';
    echo '<br />';
    echo '<h1>How to use: </h1>';
    echo '<li>Start by adding your new images by Clicking, "Add New WetSlider"';
    echo '<li>In this page, Your going to add a Title, and a Featured Image, <br />&nbsp;&nbsp;&nbsp;&nbsp;which later on will become the image used by WetSlider.</li>';
    echo '<li>After Adding the new title and Featured Image, Go ahead and Click Publish.</li>';
    echo '<li>This action has now created a regular post, that can be found on WetSliders -> WetSliders Section</li>';
    echo '<li>With the post already created with Featured images, your now ready to use your plugin, <br />&nbsp;&nbsp;&nbsp;&nbsp;in any page, post or custom post type.</li>';
    echo '<li>Add Shortcode to see the slider <code>[wetslider]</code>.</li>';
    echo '<br /><br />We are able to continue to produce FREE plugins, because of you guys, and all the donations made by the community, Thank you so much! <br /><a href="http://insanen.com/press/product/plugin-donation/" target="_blank">Buy us a coffee!</a>';
}

function in_mb2()
{
    echo '<div class="adsbyinsanen-admin">';
    echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-6091911878727341" data-ad-slot="6177899313" data-ad-format="auto"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
    echo '</div>';
}

add_action('init', 'in_cat_taxonomy');
add_theme_support('post-thumbnails');

add_action('init', 'in_init');
add_action('wp_print_scripts', 'in_register_scripts');
add_action('wp_print_styles', 'in_register_styles');
add_action('add_meta_boxes', 'in_mb_add');
