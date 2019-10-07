<?php get_header(); ?>

<div id="content">
    <div id="blocker">
        <div id="post-show-hide"></div>
    </div>
    <div class="col left">
        <div class="row col-full mrb-b-1">
            <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/face/left_top.jpg'; ?>">
        </div>
        <div class="row col-full mrb-b-1">

            <div class="col-2 checkout">
                <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/clients_past.jpg'; ?>" />

                <div class="checkout_content">
                    <div class="uppercase">
                        <h1 class="title_level1">Checkout past clients</h1>
                    </div>
                </div><!--Past Clients End-->

            </div>
            <?php $speaking_event = get_last_speaking_event() ?>
            <div class="col-2 events ajax-link-wrapper" data-ajax="<?php echo get_permalink($speaking_event->ID) ?>" >
                <div class="events_bg"></div>
                <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/face/left_bottom.jpg'; ?>" />

                <div class="events_content">
                    <div class="uppercase">
                        <h1 class="title_level1"><?php echo $speaking_event->post_title; ?></h1>
                    </div>
                </div><!--Next Speaking End-->
            </div>
            <div class="clear"></div>
        </div>
        <div class="row col-full">
            <div class="survey-monkey">
                <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/survay_bg.jpg'; ?>" />
                <div class="survay_content">
                    <h3 class="level3">Survey question</h3>
                    <h4>Lorem ipsum dolor sit amet,  consectetur adipiscing elit ipsum dolor sit amet?</h4>
                    <div class="vote">
                        <div class="top">
                            <label>
                                <input type="radio" name="vote" value="choice0">
                                <span class="poll-text">Yes</span>
                            </label>
                            <label>
                                <input type="radio" name="vote" value="choice0">
                                <span class="poll-text">No</span>
                            </label>
                            <label>
                                <input type="radio" name="vote" value="choice0">
                                <span class="poll-text">Maybe</span>
                            </label>
                        </div>
                        <div class="bottom">
                            <button class="vote_btn" href="#">Vote Now</button>
                            <a class="vote_question" href="#">View more question</a>
                        </div>
                    </div>
                </div>
            </div><!--End Survey monkey -->
        </div>
    </div><!--End First col -->

    <div class="col left">

        <div class="row col-full mrb-b-1">
            <!-- ABOUT Block Start -->
            <div class="col-2 about_jt">
                <div class="events_bg"></div>
                <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/face/right_top.jpg'; ?>" />
                <div class="about_content">                    
                    <h1 class="title_level1">About jeetendr</h1>
                    <h2 class="title_level2" onClick="play()">/ja-ten-dra/</h2>
					<audio id="audio1" src="http://www.html5rocks.com/en/tutorials/audio/quick/test.mp3"></audio>
                </div>
				<script>
				function play() {
					var audio = document.getElementById('audio1');
					if (audio.paused) {
						audio.play();
					}else{
						audio.currentTime = 0
					}
				}
				</script>
				</div>
            <!-- ABOUT Block END -->

            <!-- TWITTER Block Start -->
            <div class="col-2 twitter_main">                
                <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/twitter_bg.jpg'; ?>"  />
                <div class="twitter_content"> 

                    <img src="<?php echo get_bloginfo('template_directory') . '/images/twiter_img.jpg'; ?>" border="" alt="" />

                    <div class="title">                        
                        Jeetendr Sehdev
                        <a href="#">@JeetendrSehdev</a>
                    </div>
                    <div class="tw_txt">
                        Strong brands are seldom developed by art alone 
                        but by a careful mix of art, science and craft. 
                        <a href="#">#ambidextrousbrains</a>
                    </div>  
                    <span class="tw_date">3:15 AM - 31 Jan 2014</span>
                </div>
            </div>
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
                <h3 class="level3">Connect</h3>
                <div class="connect_social">
                    <a class="icon_facebook" href="#">Facebook</a>
                    <a class="icon_twitter" href="#">Twitter</a>
                    <a class="icon_instagram" href="#">Instagram</a>
                    <a class="icon_pinterest" href="#">pinterest</a>
                    <a class="icon_googlePlus" href="#">GooglePlus</a>
                    <a class="icon_linkedIn" href="#">linkedIn</a>
                    <a class="icon_youTube" href="#">YouTube</a>
                    <a class="icon_rss" href="#">Rss</a>
                </div>
                <div class="connect_subscribe">
                    <input type="text" placeholder="sample@email.com" />
                    <input type="submit" value="Get Updates" />                    
                </div>
            </div>
        </div>
        <div class="row col-full mrb-b-1 blog">
            <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/blog_image.jpg'; ?>" />
            <div class="blog_content">
                <h3 class="level3">Blog</h3>
                <div class="level3_txt">
                    Bruno Mars Isn't a Superstar Like Other Super Bowl Alumni, and That's Why He's the Perfect Choice
                </div>
                <a  href="#" class="read_more">Read MORE �</a>
            </div>
        </div>
        <div class="row col-full trending">
            <img class="faceImg" src="<?php echo get_bloginfo('template_directory') . '/images/trending_bg.jpg'; ?>" />
            <div class="trending_content">
                <h3 class="level3">Trending </h3>
                <div class="level3_txt">
                    Colleges embrace pop cuture studies of stars like Miley Cyrus and Beyonce
                </div>
                <a  href="#" class="read_more">Read MORE �</a>

                <div class="sl_pager">
                    <span class="prev"></span>
                    <span class="active"></span>
                    <span class=""></span>
                    <span class=""></span>
                    <span class="next"></span>
                </div>
            </div>
        </div>
    </div><!--End Third col -->
    <div class="clear"></div>
</div>

<?php get_footer(); ?>
<script type="text/javascript">

    var $ = jQuery.noConflict();
    var html;
    var ajaxUrl = $($('.ajax-link-wrapper').get(0)).attr('data-ajax') + '?qcAC=1&ajax=1';

    $.get(ajaxUrl, function(responce) {
        if (responce) {
            html = responce;
        }
    });

    $('.ajax-link-wrapper').click(function(e) {
        $('#post-show-hide').html(html);
        $('#blocker').fadeIn(250, function() {
            $('#post-show-hide').animate({width: get_post_show_hide_width()}, 100);
        });

    });

    function get_post_show_hide_width() {
        var container = $('#post-show-hide');
        var width = 810;

        if ($('#nav').width() + width > $(window).width()) {
            var width = $(window).width() - $('#nav').width();
        }
        $($('.single-post-current').get(0)).width(width - $($('.single-post-list').get(0)).width() - 40);
        return width;
    }
</script>