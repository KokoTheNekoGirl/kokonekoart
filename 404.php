<?php get_header(); ?>
<article id="post-0" class="post not-found">
<header class="header">
<h1 class="entry-title" itemprop="name">
    <i class="fa-solid fa-cat"></i>
    <?php esc_html_e( '404 - Page Not Found', 'kokoneko' ); ?>
    <img width="64" height="64" src="<?= get_template_directory_uri(); ?>/img/symbols/yarn.svg" class="attachment-full size-full" alt="Icon of a ball of yarn." decoding="async">
</h1>
</header>
<div class="entry-content" itemprop="mainContentOfPage">
<p><strong><?php esc_html_e( 'Oh no! The page ran off like a curious kitten chasing a shooting star.', 'kokoneko' ); ?></strong></p>
<a class='btn btn-primary' role='button' href='/'><span class="whiskers-left"></span><i class="fa-solid fa-left-long"></i> <?php esc_html_e( 'Go back to home', 'kokoneko' ); ?><span class="whiskers-right"></span></a>
</div>
</article>
<?php get_footer(); ?>