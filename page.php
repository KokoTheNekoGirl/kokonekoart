<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<header class="header entry-title">
<h1 itemprop="name"><?php if(!is_front_page())the_title(); ?></h1>
</header>
<div class="entry-content" itemprop="mainContentOfPage">
    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) ); } ?>
    <span class="center"><?php the_content();?></span>
    <div class="entry-links"><?php wp_link_pages(); ?></div>
</div>
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>