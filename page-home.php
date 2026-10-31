<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="entry-content" itemprop="mainContentOfPage">
    <?php if( have_rows('hero_section') ):

      while( have_rows('hero_section') ): the_row();?>
        <section class='info-viewport hero-section'>
            <div class='hero-content'>
                <h1 class="animate__animated animate__fadeInUp"><?= get_sub_field('title'); ?></h1>
                <div class="animate__animated animate__fadeInUp" style="--animate-delay: 0.2s;"><?= get_sub_field('content'); ?></div>
                <?php if(have_rows('cta')):?>
                <div class='cta-buttons animate__animated animate__fadeIn' style="--animate-delay: 0.4s;">
                    <?php while( have_rows('cta') ) : the_row();?>
                    <a class='btn btn-primary' <?php if (get_sub_field('target')) echo "target='_blank'"; ?> role='button' href='<?= get_sub_field('url'); ?>'><span class="whiskers-left"></span><?= get_sub_field('label'); ?><span class="whiskers-right"></span></a>
                    <?php endwhile;?>
                </div>
                <?php endif;?>
            </div>
            <div class='spacer'></div>
            <img class='hero-img animate__animated animate__fadeIn' alt="An animated gif of my fursona Koko drawing on my digital tablet." src='<?= get_sub_field('img'); ?>'>
        </section>
    <?php endwhile; endif;?>
    <?php if( have_rows('about_section') ):

      while( have_rows('about_section') ): the_row();?>
        <section class='about-section'>
            <div class='mini-box'>
                <h2 class="animate__animated animate__fadeInUp"><?= get_sub_field('title'); ?></h2>
                <div class="animate__animated animate__fadeInUp" style="--animate-delay: 0.2s;"><?= get_sub_field('content'); ?></div>
                <?php if(have_rows('cta')):?>
                <div class='cta-buttons animate__animated animate__fadeIn' style="--animate-delay: 0.4s;">
                    <?php while( have_rows('cta') ) : the_row();?>
                    <a class='btn btn-primary' <?php if (get_sub_field('target')) echo "target='_blank'"; ?> role='button' href='<?= get_sub_field('url'); ?>'><span class="whiskers-left"></span><?= get_sub_field('label'); ?><span class="whiskers-right"></span></a>
                    <?php endwhile;?>
                </div>
                <?php endif;?>
            </div>
            <div class='info-viewport '>
                <h2 class='info-viewport-title animate__animated animate__fadeInUp'>I am...</h2>
                <ul class='viewport-content-img'>
                    <?= do_shortcode(get_sub_field('shortcode')); ?>
                </ul>
            </div>
        </section>
    <?php endwhile; endif;?>
    <?php if( have_rows('commissions_section') ):

      while( have_rows('commissions_section') ): the_row();?>
        <section class='commissions-section'>
            <div class='info-viewport img-only'>
                <div class='viewport-overlay'></div>
                <ul class='viewport-content'>
                <?php
                if (have_rows('art_samples')) :
                    $art_samples = array();
                    while(have_rows('art_samples')): the_row();
                        $art_samples[] = get_sub_field('art_sample');
                    endwhile;
                endif;
                if($art_samples):
                    shuffle($art_samples);
                    foreach($art_samples as $id):
                        $src = wp_get_attachment_image_url($id, 'full');
                        $caption = wp_get_attachment_caption($id);?>
                        <div class='img-group'>
                            <img class='art-img' src='<?= $src;?>' alt='<?=$caption;?> art example' />
                            <span class='img-caption'><?=$caption;?></span>
                        </div>
                    <?php endforeach;
                endif;
                ?>
                </ul>
            </div>
            <div class='mini-box'>
                <h2 class="animate__animated animate__fadeInUp"><?= get_sub_field('title'); ?></h2>
                <div class="animate__animated animate__fadeInUp" style="--animate-delay: 0.2s;"><?= get_sub_field('content'); ?></div>
                <?php if(have_rows('cta')):?>
                <div class='cta-buttons animate__animated animate__fadeIn' style="--animate-delay: 0.4s;">
                    <?php while( have_rows('cta') ) : the_row();?>
                    <a class='btn btn-primary <?php if (get_sub_field('target')) echo "target='_blank'"; ?> role='button' href='<?= get_sub_field('url'); ?>'><span class="whiskers-left"></span><?= get_sub_field('label'); ?><span class="whiskers-right"></span></a>
                    <?php endwhile;?>
                </div>
                <?php endif;?>
            </div>
        </section>
    <?php endwhile; endif;?>
    <?php if( have_rows('portfolio_section') ):

      while( have_rows('portfolio_section') ): the_row();?>
        <section class='portfolio-section'>
            <div class='mini-box'>
                <h2 class="animate__animated animate__fadeInUp"><?= get_sub_field('title'); ?></h2>
                <div class="animate__animated animate__fadeInUp" style="--animate-delay: 0.2s;"><?= get_sub_field('content'); ?></div>
                <?php if(have_rows('cta')):?>
                <div class='cta-buttons animate__animated animate__fadeIn' style="--animate-delay: 0.4s;">
                    <?php while( have_rows('cta') ) : the_row();?>
                    <a class='btn btn-primary' <?php if (get_sub_field('target')) echo "target='_blank'"; ?> role='button' href='<?= get_sub_field('url'); ?>'><span class="whiskers-left"></span><?= get_sub_field('label'); ?><span class="whiskers-right"></span></a>
                    <?php endwhile;?>
                </div>
                <?php endif;?>
            </div>
            <!--<div class='info-viewport '>-->
            <!--    <ul class='viewport-content-img'>-->
            <!--        <?= do_shortcode(get_sub_field('shortcode')); ?>-->
            <!--    </ul>-->
            <!--</div>-->
        </section>
    <?php endwhile; endif;?>
    <?php if( have_rows('contact_section') ):

      while( have_rows('contact_section') ): the_row();?>
        <section class='contact-section'>
            <div class='mini-box'>
                <h2 class="animate__animated animate__fadeInUp"><?= get_sub_field('title'); ?></h2>
                <div class="animate__animated animate__fadeInUp" style="--animate-delay: 0.2s;"><?= get_sub_field('content'); ?></div>
                <?php if(have_rows('social_icons')):?>
                <div class="icon-group animate__animated animate__fadeIn" style="--animate-delay: 0.4s;">
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
                <?php endif;?>
                <?php if(have_rows('cta')):?>
                <div class='cta-buttons animate__animated animate__fadeIn' style="--animate-delay: 0.6s;">
                    <?php while( have_rows('cta') ) : the_row();?>
                    <a class='btn btn-primary' <?php if (get_sub_field('target')) echo "target='_blank' rel='external' "; ?>role='button' href='<?= get_sub_field('url'); ?>'><span class="whiskers-left"></span><?= get_sub_field('label'); ?><span class="whiskers-right"></span></a>
                    <?php endwhile;?>
                </div>
                <?php endif;?>
            </div>
        </section>
    <?php endwhile; endif;?>
</div>
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>