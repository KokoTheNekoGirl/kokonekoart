<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="entry-content" itemprop="mainContentOfPage">
    <section id="boxed-content">
        <div class="entry-title animate__animated animate__fadeInUp"><?php the_title("<h1>","</h1>"); ?></div>
        <p class='center'>Last Updated: <?= get_the_modified_date('j F, Y') ?></p>
        <?php the_content();?>
    </section>
</div>
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>