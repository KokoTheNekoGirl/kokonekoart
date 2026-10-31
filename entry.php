<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<header class="entry-title">
<?php if ( is_singular() ) { echo '<h1 itemprop="headline">';  ?>
    <?php the_title(); ?>
<?php echo '</h1>'; } ?>
<?php //edit_post_link(); ?>
<?php if ( !is_search() && is_singular() ) { get_template_part( 'entry', 'meta' ); } ?>
<?php if(is_singular() && get_the_ID() != 441):?><a class='btn btn-primary' role='button' href='#finished'><span class="whiskers-left"></span>Scroll to Final Result<span class="whiskers-right"></span></a><?php endif;?>
</header>
<?php get_template_part( 'entry', ( is_front_page() || is_home() || is_front_page() && is_home() || is_archive() || is_search() ? 'summary' : 'content' ) ); ?>
<?php //if ( is_singular() ) { get_template_part( 'entry-footer' ); } ?>
</article>
