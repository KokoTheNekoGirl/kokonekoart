<?php
get_header(); ?>

<header class="header entry-title">
    <h1 class="animate__animated animate__fadeInUp" itemprop="name">
        <?php single_cat_title(); ?>
    </h1>
</header>

<div class="portfolio-posts">

    <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'entry', 'summary' ); ?>

        <?php endwhile; ?>

        <?php get_template_part( 'nav', 'below' ); ?>

    <?php else : ?>

        <p>No posts found.</p>

    <?php endif; ?>

</div>

<?php get_footer(); ?>