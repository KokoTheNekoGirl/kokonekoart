<div class="entry-summary">

<section class="portfolio-piece">
    <?php if ( ( has_post_thumbnail() ) && ( !is_search() ) ) : ?>
    <div class="featured-image">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        <?php the_post_thumbnail(); ?></a>
    </div>
    <?php endif; ?>
    <div class="mini-box">
        <h3><?php the_title_attribute(); ?></h3>
        <div class="portfolio-labels">
        <?php $categories = get_the_category();
            if ( ! empty( $categories ) ) :
                foreach ( $categories as $category ) :
                    $bg_color = get_field('bg_color', 'category_' . $category->term_id);
                    $text_color = get_contrast_color($bg_color);
                ?>
                <a class="btn btn-portfolio" style="background:<?= $bg_color; ?>; color:<?= $text_color; ?>" href="<?= esc_url( get_category_link( $category->term_id ) )?>'">
                    <?= esc_html( $category->name ); ?>
                </a>
                <?php endforeach;
            endif;?>
        </div>
        <?php the_excerpt(); ?>
        <a class='btn btn-primary' role='button' style="margin-top:1.5em;" title="<?php the_title_attribute(); ?>" href='<?php the_permalink(); ?>'><span class="whiskers-left"></span>Read More<span class="whiskers-right"></span></a>
    </div>
</section>

<?php if ( is_search() ) { ?>
<div class="entry-links"><?php wp_link_pages(); ?></div>
<?php } ?>
</div>