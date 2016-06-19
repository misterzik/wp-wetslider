<?php
/*
    Plugin Name: WetSlider Plugin
    Description: WordPress Quick WetSlider for your blog.
    Author: Insanen Team - http://insanen.com
    Version: 1.0
*/

function in_register_scripts()
{
    if (!is_admin()) {
        // Register
        wp_register_script('minerva-script', plugins_url('minervajs/minerva.min.js', __FILE__));
        wp_enqueue_script('jquery-3', plugins_url('minervajs/jquery-3.0.0.min.js', __FILE__));

        // Enqueue
        wp_enqueue_script('jquery-3');
        wp_enqueue_script('minerva-script');
    }
}

function in_register_styles()
{
    // Register
    wp_register_style('minerva-css', plugins_url('minervajs/minerva.min.css', __FILE__));
    wp_register_style('in_css', plugins_url('style.css', __FILE__));

    // Enqueue
    wp_enqueue_style('minerva-css');
    wp_enqueue_style('in_css');
}

function in_function($type='in_function')
{
    // Starts
    $args = array(
      'post_type' => 'wet-slider',
      'posts_per_page' => 5
    );

    $result .= '<div class="min-wrapper">';
    $result .= '<div class="min-container">';
    $result .= '<ul id="slider">';

    //the loop
    $loop = new WP_Query($args);
    while ($loop->have_posts()) : $loop->the_post();
        $the_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $type);

    $result .= '<li><img title="'.get_the_title().'" src="'.$the_url[0].'" data-thumb="'.$the_url[0].'" alt=""/></li>';

    endwhile;
    wp_reset_postdata();

    $result .= '<div class="" id="controllers">';
    $result .= '<button id="prev"><</button>';
    $result .= '<button id="next">></button>';
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
      'singular_name' => _x('WetSlider', 'wet_slider'),
      'add_new' => _x('Add New WetSlider', 'wet_slider'),
      'add_new_item' => _x('Add New WetSlider', 'wet_slider'),
      'edit_item' => _x('Edit WetSlider', 'wet_slider'),
      'new_item' => _x('New WetSlider', 'wet_slider'),
      'view_item' => _x('View WetSlider', 'wet_slider'),
      'search_items' => _x('Search WetSlider', 'wet_slider'),
      'not_found' => _x('No WetSliders found', 'wet_slider'),
      'not_found_in_trash' => _x('No WetSliders found in Trash', 'wet_slider'),
      'parent_item_colon' => _x('Parent WetSlider:', 'wet_slider'),
      'menu_name' => _x('WetSliders', 'wet_slider'),
  );

    add_shortcode('ws-shortcode', 'in_function');
    add_image_size('in_widget', 180, 100, true);
    add_image_size('in_function', 600, 200, true);

    $args = array('public' => true,
    //'label' => 'WetSlider Images',
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

function cat_taxonomy()
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

function cd_meta_box_add()
{
    add_meta_box('my-meta-box-id', 'Plugin Information :', 'cd_meta_box_cb', 'wet-slider', 'normal', 'high');
}

function cd_meta_box_cb()
{
echo <<<EOT
<a href="http://insanen.com" target="_blank"><img src="http://insanen.com/images/insanen-728x90-web.png"></a>
<br />
<h1>How to use: </h1>
<li>Add images to WetSlider.</li><li>Add Shortcode to page or post: [ws-shortcode].</li>
<li><a href="http://insanen.com/press/product/plugin-donation/" target="_blank">Make a Donation</a></li>
EOT;
}


function add_metaboxes()
{
    remove_meta_box('postimagediv', 'wet-slider', 'side');

    add_meta_box('postimagediv_new', __('Featured Image'), 'post_thumbnail_meta_box', 'wet-slider', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_metaboxes');


//hooks
add_action('add_meta_boxes', 'cd_meta_box_add');
add_action('init', 'cat_taxonomy');
add_theme_support('post-thumbnails');
add_action('init', 'in_init');
//add_action('widgets_init', 'in_widgets_init');
add_action('wp_print_scripts', 'in_register_scripts');
add_action('wp_print_styles', 'in_register_styles');

?>
