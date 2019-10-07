<?php
if (!isset($_GET['ajax'])) {
    wp_redirect(get_redirect_url());
}

if(isset($_GET['sidebar'])) {
    $use_sidebar = $_GET['sidebar'];
}

$post_id = get_the_ID();
$current_post = get_post($post_id);
$currImg = get_the_post_thumbnail( $current_post->ID, 'full' );
$post_type = $current_post->post_type;
$defaultImg = "<img src='".get_bloginfo('template_directory')."/images/default_blog.png' />";

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
                        <div class="blog_list_img">
                            <?php                              
                             //$post_img = get_the_post_thumbnail( $post->ID, 'list-post-tumb'); 
                             //$postImg = (isset($post_img)&&$post_img!="")? $post_img : $defaultImg;
                                // echo $postImg;
                             ?>   
                            <img src="<?php bloginfo("template_directory"); ?>/images/blog_thumb_1.png" />
                        </div>
                        <div class="blog_list_title">
                            <?php echo $post->post_title; ?>
                            <span class="blog_list_subtitlle">
                            <?php
                                $subtitle =  get_post_meta( $post->ID, 'tumblr_subtitle', true ); 
                                if( isset($subtitle)) { echo $subtitle; }
                            ?>
                            </span>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<div class="single-post-current single_blog_current <?php echo isset($_GET['full-width']) ? 'full-width' : ''; ?>">
    <h1 class="single_blog_title">
        <?php echo $current_post->post_title; ?>    
        <span class="single_blog_subtitlle">
            <?php
                $subtitle =  get_post_meta( $current_post->ID, 'tumblr_subtitle', true ); 
                if( isset($subtitle)) { echo $subtitle; }
            ?>
        </span>
    </h1>
    <div class="single_blog_img">
        <?php 
            $currPic = ( isset($currImg)&&$currImg!="" )? $currImg : $defaultImg;
            echo $currPic; 
        ?> 
        
    </div>
    <div class="blog_meta_block">
        <div class="blog_meta">
            <span class="author">
                BY: <?php echo get_userdata($current_post->post_author)->display_name; ?>
            </span>
            <span class="date">
                <?php 
                    $date = $current_post->post_date; 
                    echo date('F d, Y  H:i a',strtotime($date));
                ?>
            </span> 
        </div>
        <div class="blog_social">
            <span>Share on:  </span>       
            <a href="#" class="icon_facebook">Facebook</a>
            <a href="#" class="icon_twitter">Twitter</a>
            <a href="#" class="icon_googlePlus">GooglePlus</a>
            <a href="#" class="icon_linkedIn">linkedIn</a>                
        </div>
    </div>
    
    
    <p class="single_blog_content"><?php echo $current_post->post_content ?></p>
</div>
<?php wp_reset_postdata(); ?>
<script type="text/javascript">initScrollBar();</script>
