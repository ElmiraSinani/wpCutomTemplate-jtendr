<?php
/**
 * Template Name: Homepage
 */
?>
<?php get_header(); ?>
<div id="main-content">
    <div id="blocker">
        <div id="post-show-hide"></div>
    </div>
    <div id="blocker-black"></div>
    <?php include_once 'social-connect.php'; ?>
    <?php include_once 'voice.php' ?>
	<?php //include_once 'woocommerce.php' ?>
    <div class="col left">
        <div class="row col-full mrb-b-1">
            <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/face/left_top.jpg'; ?>">
        </div>
        <div class="row col-full mrb-b-1">
            <section class="flip-wrapper">
                <?php $checkout_past_clients = get_checkout_past_clients() ?>
                <?php foreach ($checkout_past_clients as $checkout_past_client) { ?>
                    <div class="col-2 checkout ajax-link-wrapper flip" data-page-name="checkout_past_clients<?php echo $checkout_past_client->ID ?>" data-ajax="<?php echo get_permalink($checkout_past_client->ID) ?>?sidebar=1">
                        <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/clients_past.jpg'; ?>" />

                        <div class="checkout_content">
                            <div class="uppercase">
                                <h1 class="title_level1"><?php echo $checkout_past_client->post_title ?></h1>
                            </div>
                        </div><!--Past Clients End-->

                    </div>
                <?php } ?>
            </section>
            <section class="flip-wrapper">
                <?php $speaking_events = get_speaking_events() ?>
                <?php foreach ($speaking_events as $speaking_event) { ?>
                    <div class="col-2 events ajax-link-wrapper flip" data-page-name="speaking_events<?php echo $speaking_event->ID ?>" data-ajax="<?php echo get_permalink($speaking_event->ID) ?>?sidebar=1" >
                        <div class="events_bg"></div>
                        <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/face/left_bottom.jpg'; ?>" />

                        <div class="events_content">
                            <div class="uppercase">
                                <h1 class="title_level1"><?php echo $speaking_event->post_title; ?></h1>
                            </div>
                        </div><!--Next Speaking End-->
                    </div>
                <?php } ?>
            </section>
            <div class="clear"></div>
        </div>
        <div class="row col-full">
            <div class="survey-monkey">
                <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/survay_bg.jpg'; ?>" />
                <div class="survay_content">
                    <?php dynamic_sidebar('poll'); ?>
                </div>
            </div><!--End Survey monkey -->
        </div>
    </div><!--End First col -->

    <div class="col left">

        <div class="row col-full mrb-b-1">
            <!-- ABOUT Block Start -->
            <section class="flip-wrapper">
                <div class="col-2 about_jt flip">
                    <div class="events_bg"></div>
                    <?php $about = get_about_jeetendr_post(); ?>
                    <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/face/right_top.jpg'; ?>" />
                    <div class="about_content">              
                        <h1 class="title_level1 ajax-link-wrapper" data-ajax="<?php echo get_permalink($about->ID) ?>?sidebar=0" data-page-name="about_jeetendr">
                            <?php echo $about->post_title ?>
                        </h1>
                        <h2 class="title_level2" onClick="play()">/ja-ten-dra/</h2>
                        <audio id="audio1" src="http://www.html5rocks.com/en/tutorials/audio/quick/test.mp3"></audio>					
                    </div>
                    <script>
                        function play() {
                            var audio = document.getElementById('audio1');
                            if (audio.paused) {
                                audio.play();
                            } else {
                                audio.currentTime = 0
                            }
                        }
                    </script>
                </div>
            </section>
            <!-- ABOUT Block END -->

            <!-- TWITTER Block Start -->
            <!--<section class="flip-wrapper">
                <div class="col-2 flip twitter_main">     -->           
            <?php dynamic_sidebar('twitter-sidebar'); ?> 
            <!-- </div>
         </section> -->
            <!-- TWITTER Block END -->
        </div>

        <div class="row col-full mrb-b-1">
            <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/face/right_middle.jpg'; ?>" />
        </div>
        <div class="row col-full">
            <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/face/right_bottom.jpg'; ?>" />
        </div>
    </div><!--End Second col -->
    <div class="col-last left">
        <div class="row col-full mrb-b-1 connect">
            <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/connect_bg.jpg'; ?>" />
            <div class="connect_content">
                <?php dynamic_sidebar('connect'); ?>
            </div>
        </div>
        <section class="flip-wrapper">
            <?php $posts = get_tumblr_posts(5); ?>
            <?php foreach ($posts as $post) { ?>
                <div class="row col-full mrb-b-1 blog flip">
                    <?php $tumbnail = get_the_post_thumbnail($post->ID, 'blog-post-tumb', array('class' => 'faceImg')); ?>
                    <?php if ($tumbnail) echo $tumbnail; ?>
                    <!--<img class="faceImg" src="<?php //echo get_first_image($post->post_content);  ?>" /> -->
                    <div class="blog_content">
                        <h3 class="level3">Blog</h3>
                        <div class="level3_txt">
                            <?php echo $post->post_title ?>
                        </div>
                        <a data-page-name="blog<?php echo $post->ID ?>" data-ajax="<?php echo get_permalink($post->id) ?>?sidebar=1&full-width=1"  href="#" class="ajax-link-wrapper read_more">Read MORE</a>
                    </div>
                </div>
            <?php } ?>
            <?php wp_reset_postdata(); ?>
        </section>
        <div class="row col-full trending">
		    <div style="position:absolute;">
				<h3 class="level3" style="position:absolute; top: 15px; left:15px;">Trending </h3>
				<img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/trending_bg.jpg'; ?>" />
            </div>
			<ul class="trending_content">
                <?php $trendings = get_trendings(10); ?>
                <?php foreach ($trendings as $trending) { ?>
                    <li style="height:165px;">
                        <!--<img style="width: 100%; margin-left: -15px;" class="faceImg" src="<?php //echo get_bloginfo('template_directory') . '/images/trending_bg.jpg'; ?>" />-->
                        <div style="position:absolute; top: 25px; left:0 ;">
                            <div class="level3_txt">
                                <?php echo $trending->post_title ?>
                            </div>
                            <a data-page-name="trending<?php echo $trending->ID ?>" data-ajax="<?php echo get_permalink($trending->ID); ?>?sidebar=1" class="ajax-link-wrapper read_more">Read MORE</a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div><!--End Third col -->
    <div class="clear"></div>
</div>
<?php get_footer(); ?>
