<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="entry-content" itemprop="mainContentOfPage">
    <section class='about-bio-section'>
        <div class="img-wrapper">
            <a href="https://www.teamhuman.org/" target="_blank"><img class="round-img" alt="" src="<?= wp_get_attachment_image_url(get_post_thumbnail_id(),'full')?>"></a>
            <p style="text-align:center;">Art by <a href="https://toyhou.se/fawnlynx" rel="external" target="_blank">fawnlynx</a></p>
        </div>
        <div class="info-viewport ">
            <ul class="about-quick-info">
            <?php $rows = get_field('info');
            if( $rows ):
                foreach($rows as $row):?>
                    <?php if($row['label'] == "Age"):?>
                        <li><strong><?= $row['label'];?></strong> <?= do_shortcode('[my_age]');?></li>
                        <li><strong>Birthday</strong> <?= do_shortcode('[birthday]');?></li>
                    <?php else:?>
                        <li><strong><?= $row['label'];?></strong> <?= $row['answer'];?></li>
                    <?php endif;?>
            <?php endforeach; endif;?>
            <?php if( have_rows('extra_info') ):
                while( have_rows('extra_info') ): the_row();?>
                    <li><strong><?= get_sub_field('label');?></strong> <?= get_sub_field('answer');?></li>
            <?php endwhile; endif;?>
             </ul>
        </div>
    </section>
    <section id="boxed-content">
        <div class="bio-content">
            <?php the_title("<h1>","</h1>");
            the_content();?>
            <a style="margin: 0 auto;" class="btn btn-primary" title="Contact Me" role="button" href="/contact/"><span class="whiskers-left"></span>Connect<span class="whiskers-right"></span></a>
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
    </section>
</div>
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>