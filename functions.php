<?php

require_once 'inc/tumblr_posts/tumblr_posts.php';

/**
 * Register Styles
 */
function registerStyles() {
    wp_register_style('jtStandart', get_template_directory_uri() . '/css/jtStandart.css', array(), '', 'all');
    wp_enqueue_style('jtStandart');
}

add_action('wp_enqueue_scripts', 'registerStyles');

/**
 * Register Scripts
 */
function registerScripts() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"), false);
    wp_enqueue_script('jquery');
    wp_register_script('global', get_stylesheet_directory_uri() . '/js/global.js', false);
    wp_enqueue_script('global');
    wp_register_script('bxslider', get_stylesheet_directory_uri() . '/js/bxslider/jquery.bxslider.min.js', false);
    wp_enqueue_script('bxslider');
}

add_action('wp_enqueue_scripts', 'registerScripts');

// Clean up the <head>
function removeHeadLinks() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
}

add_action('init', 'removeHeadLinks');
remove_action('wp_head', 'wp_generator');

// Declare sidebar widget zone
if (function_exists('register_sidebar')) {

    register_sidebar(array(
        'name' => 'Sidebar Widgets',
        'id' => 'sidebar-widgets',
        'description' => 'These are widgets for the sidebar.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ));

    register_sidebar(array(
        'name' => __('Twitter Sidebar'),
        'id' => 'twitter-sidebar',
        'description' => __('Sidebar for showing last tweet of the user.'),
        'before_widget' => ''
        /* . '<div class="title">                        
          Jeetendr Sehdev
          <a href="#">@JeetendrSehdev</a>
          </div>' */,
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
        'name' => __('Home page poll', 'responsive'),
        'description' => __('Home page poll system', 'responsive'),
        'id' => 'poll',
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>'
    ));
    register_sidebar(array(
        'name' => __('Home page Connect', 'responsive'),
        'description' => __('Home page Connect', 'responsive'),
        'id' => 'connect',
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>'
    ));
}

// post tumbnail sizes 

if (function_exists('add_image_size')) {
    add_image_size('list-post-tumb', 158); 
    add_image_size('blog-post-tumb', 417, 415); 
}

if (function_exists('add_image_size')) {
    
}

// Other functions

function get_redirect_url() {

    $request_scheme = $_SERVER['REQUEST_SCHEME'] ? $_SERVER['REQUEST_SCHEME'] : 'http';
    return str_replace(get_bloginfo('url'), get_bloginfo('url') . '/#', $request_scheme . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
}

function get_speaking_events() {
    global $wpdb;
    $result = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "posts WHERE post_status = 'publish' AND post_type = 'speaking_event' ORDER BY `post_date` DESC", "OBJECT");
    return $result;
}

function get_checkout_past_clients() {
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "posts WHERE post_status = 'publish' AND post_type = 'checkout_past_client' ORDER BY `post_date` DESC", "OBJECT");
}

function get_about_jeetendr_post() {
    global $wpdb;
    return $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "posts WHERE post_status = 'publish' AND post_type = 'jeetender_info' ORDER BY `post_date` DESC LIMIT 1", "OBJECT");
}

function get_trendings($limit) {
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "posts WHERE post_status = 'publish' AND post_type = 'trending' ORDER BY `post_date` DESC LIMIT $limit", "OBJECT");
}

//


add_filter('latest_tweets_render_before', function() {
    return '<section  class="flip-wrapper">';
}, 10, 0);

add_filter('latest_tweets_render_list', function( $tweets ) {

    foreach ($tweets as $tweet) {

        $result.= '<div class="col-2 flip twitter_main">';
        $result.= '<img class="faceImg" src="' . get_bloginfo('template_directory') . '/images/twitter_bg.jpg" />';
        $result .= '<div class="twitter_content">';
            $result.= '<div class="title">Jeetendr Sehdev<a href="#">@JeetendrSehdev</a></div>';
            $result.= $tweet;
        $result .= '</div>';
        $result.= '</div>';
    }
    return $result;
});

add_filter('latest_tweets_render_after', function() {
    return '</section>';
}, 10, 0);
