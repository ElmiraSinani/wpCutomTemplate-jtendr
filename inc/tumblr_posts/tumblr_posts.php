<?php

add_action('admin_init', 'insert_tumblr_posts');

function insert_tumblr_posts() {

    $api_key = 'vakoHyOq5qXlkUAGeoheSYat4uEYeP6u70BgskxWILuzF0DqOj';
    $api_secret = '1EDYo0wL91XdjoSKOlM6eanNOQReiHy9vT30j803bg6rgP4bgJ';
    $blog_base_hostname = 'jeetendrsehdev.tumblr.com';
    $filter = "";

    // create curl resource 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://api.tumblr.com/v2/blog/jeetendrsehdev.tumblr.com/posts/text/?api_key=$api_key&filter=$filter");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($output);

    if ($output->meta->status == 200) {

        global $wpdb;
        $posts = $output->response->posts;
        $admin = get_user_by('email', get_option('admin_email'));
        $adminId = $admin->data->ID;

        $savedBlogPostIds = $wpdb->get_col("SELECT `wp_postmeta`.meta_value  FROM `wp_posts`
            LEFT JOIN `wp_postmeta` ON `wp_posts`.ID = `wp_postmeta`.post_id
            WHERE `wp_posts`.post_type = 'tumblr_blog_post' 
            AND `wp_posts`.post_status = 'publish'
            AND `wp_postmeta`.meta_key = 'tumblr_post_id'");

        foreach ($posts as $post) {

            if (!in_array($post->id, $savedBlogPostIds)) {

                $blog_post = array(
                    'post_content' => $post->body,
                    'post_title' => $post->title,
                    'post_status' => 'publish',
                    'post_type' => 'tumblr_blog_post',
                    'post_author' => $adminId,
                );

                $id = wp_insert_post($blog_post);

                if ($id) {
                    add_post_meta($id, 'tumblr_post_id', $post->id, true);
                    add_post_meta($id, 'tumblr_post_date', $post->date, true);
                    add_post_meta($id, 'tumblr_post_url', $post->post_url, true);
                    add_post_meta($id, 'tumblr_post_blog_name', $post->blog_name, true);
                }
            }
        }
    }
}

function get_tumblr_posts($limit = 5) {

    global $wpdb;
    $limit = (int) $limit;

    $posts = $wpdb->get_results("SELECT * FROM `wp_posts` WHERE post_type='tumblr_blog_post' AND post_status='publish'ORDER BY post_date DESC LIMIT $limit");

    foreach ($posts as $index => $post) {
        $posts[$index]->meta = get_post_meta($post->ID);
    }
    return $posts;
}

function get_images($html) {

    require_once(get_template_directory().'/inc/lib/simple_html.php');

    $post_dom = str_get_dom($html);

    $img_tags = $post_dom->find('img');

    $images = array();

    foreach ($img_tags as $image) {
        $images[] = $image->src;
    }

    return $images;
}

function get_first_image($html) {
    
    require_once(get_template_directory().'/inc/lib/simple_html.php');

    $post_html = str_get_html($html);

    $first_img = $post_html->find('img', 0);

    if ($first_img !== null) {
        return $first_img->src;
    }

    return get_bloginfo('template_directory') . '/images/blog_image.jpg';
}

?>