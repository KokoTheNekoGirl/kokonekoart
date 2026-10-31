<?php
get_header(); ?>
<header class="header entry-title">
<h1 class="animate__animated animate__fadeInUp" itemprop="name"><?php the_title(); ?></h1>
</header>
<div class="portfolio-posts">
<?php
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$portfolio_query = new WP_Query([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 10,
    'paged'          => $paged
]);

if ( $portfolio_query->have_posts() ) :
    while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
        get_template_part( 'entry','summary' );
    endwhile;

    // Pagination
    get_template_part( 'nav', 'below' );
else :
    echo '<p>No posts found.</p>';
endif;

// Reset global $post data
wp_reset_postdata();
?>
</div>
<?php get_footer(); ?>