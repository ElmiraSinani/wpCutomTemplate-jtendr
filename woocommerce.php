<?php get_header(); ?>


<?php

if (isset($_GET['prodId']))
{
    die('here');
}
/**
 * Template Name: Shop
 */
?>
<div id="main-content">
    <!--<a class="btn-page-exit"></a>-->
    <div class="single-post-list blog_list shop">
        <div id="scroll-pan"><span id="scroll-item"></span></div>
        <?php woocommerce_content(); ?>  
    </div>

    <div class="single-post-current single_blog_current" style="background:#fff">
    <h1 class="single_blog_title">
        <?php echo "title here"; ?>
    </h1>    
    <p class="single_blog_content">
       <?php echo do_shortcode('[product_page id="72"]'); ?>
    </p>
</div>

<script type="text/javascript">initScrollBar();</script>
    
  
</div> <!-- End main-content-->

<?php get_footer(); ?>



