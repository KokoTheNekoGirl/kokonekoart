<?php get_header(); 
$shortcode = get_field('shortcode');?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="entry-content" itemprop="mainContentOfPage">
    <div class="entry-title animate__animated animate__fadeInUp"><?php the_title("<h1>","</h1>"); ?></div>
    <section class='contact-section'>
        <div class="info-viewport ">
            <h2><?= get_field('form_title'); ?></h2>
            <?= get_field('form_desc'); ?>
            <?= do_shortcode("{$shortcode}"); ?>
        </div>
        <div class="sticky">
            <div class="info-viewport ">
                <h2><?= get_field('external_title'); ?></h2>
                <img style="max-height:400px;object-fit:contain;" alt="Digital Art of my Fursona, Koko by dragon.wishes" src="/wp-content/uploads/2025/08/59669871_QhEt1ai9vJ2sMRf.png">
                <p style="text-align:center;">Art by <a href="https://www.instagram.com/dragon.wishes/" rel="external" target="_blank">dragon.wishes</a></p>
                <?= get_field('external_desc');?>
                <?php if(have_rows('social_icons')):?>
                <div class="icon-group center">
                    <?php while( have_rows('social_icons') ) : the_row();?>
                    <div class="paw-icon">
                        <a class="icon icon-primary" rel="external" target="_blank" href="<?= get_sub_field('url')?>">
                        <?php if(get_sub_field('fa_icon')):?>
                            <?= get_sub_field('icon_class')?>
                        <?php else:?>
                            <?= wp_get_attachment_image(get_sub_field('icon_src'),'full');?>
                        <?php endif;?>
                        </a>
                        <span class="toe-beans" id="toe-bean-1"></span>
                        <span class="toe-beans" id="toe-bean-2"></span>
                        <span class="toe-beans" id="toe-bean-3"></span>
                        <span class="toe-beans" id="toe-bean-4"></span>
                    </div>
                    <?php endwhile;?>
                </div>
                <?php endif;
                if(have_rows('more_social_icons')):?>
                <div class="icon-group center">
                    <?php while( have_rows('more_social_icons') ) : the_row();?>
                        <a class="icon icon-mini" rel="external" target="_blank" href="<?= get_sub_field('url')?>">
                        <?php if(get_sub_field('fa_icon')):?>
                            <?= get_sub_field('icon_class')?>
                        <?php else:?>
                            <?= wp_get_attachment_image(get_sub_field('icon_src'),'full');?>
                        <?php endif;?>
                        </a>
                    <?php endwhile;?>
                </div>
                <?php endif;?>
            </div>
        </div>
    </section>
</div>
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>