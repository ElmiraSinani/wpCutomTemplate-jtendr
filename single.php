<?php
if (!isset($_GET['ajax'])) {
    wp_redirect(get_redirect_url());
}

if(isset($_GET['sidebar'])) {
    $use_sidebar = $_GET['sidebar'];
}

$post_id = get_the_ID();
$current_post = get_post($post_id);
$post_type = $current_post->post_type;
//$meta = get_metadata($post_type, $post_id);
$post_list = get_posts(array(
    'category' => '',
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => $post_type,
    'post_status' => 'publish',
        ));
?>
<a class="btn-page-exit"></a>
<?php if($use_sidebar) { ?>
    <div class="single-post-list blog_list">
        <div id="scroll-pan"><span id="scroll-item"></span></div>
        <ul class="post-list">
            <?php foreach ($post_list as $post) { ?>
                <li class="<?php echo $post->ID == $post_id ? 'selected' : ''; ?>">
                    <!--<div class="dark-bg"></div>-->       
					<div class="active_arrow"></div>
                    <div class="show-post" href="" data-href="<?php echo get_permalink($post->ID) ?>">
                        <?php $tumbnail = get_the_post_thumbnail( $post->ID, 'list-post-tumb'); ?>
                        <?php if($tumbnail) { ?>
                        <div class="single-post-tumbnail">
                            <?php echo $tumbnail ?> 
                        </div>
                        <?php } ?>
                        <div class="blog_list_title">
                            <?php echo $post->post_title; ?>
                            <span class="blog_list_subtitlle">
                            <?php echo $post->post_excerpt; ?>
                            </span>
                        </div>
                        
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<div class="single-post-current <?php echo isset($_GET['full-width']) ? 'full-width' : ''; ?>">
    <h1 class="single-post-title"><?php echo $current_post->post_title ?></h1>
    <p class="single-post-content"><?php echo $current_post->post_content ?></p>
</div>
<?php wp_reset_postdata(); ?>
<script type="text/javascript"> initScrollBar();</script>
