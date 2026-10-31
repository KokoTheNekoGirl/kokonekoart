<div class="entry-content" itemprop="mainEntityOfPage">
<meta itemprop="description" content="<?php echo esc_html( wp_strip_all_tags( get_the_excerpt(), true ) ); ?>">
<?php the_content(); ?>
<?php if(get_the_ID() != 441):?><div class="btn-group" style="padding-bottom:0;" id="finished"><?php endif;?>
<?php
if(get_field('github_link')):?>
    <a class='btn btn-primary' target='_blank' role='button' rel='external' href='<?= get_field('github_link'); ?>'><span class="whiskers-left"></span><i class="fa-brands fa-github"></i><span class="btn-text">View code</span><span class="whiskers-right"></span></a>
<?php endif;
if(get_field('internal_file')):?>
    <a class='btn btn-primary' target='_blank' role='button' href='/project/<?= get_field('internal_file'); ?>'><span class="whiskers-left"></span><i class="fa-solid fa-computer-mouse"></i><span class="btn-text">View live</span><span class="whiskers-right"></span></a>
<?php endif;
if(get_field('figma_share')):?>
    <a class='btn btn-primary' target='_blank' role='button' rel='external' href='<?= get_field('figma_share'); ?>'><span class="whiskers-left"></span><i class="fa-brands fa-figma"></i><span class="btn-text">View <?php if(get_field('figma_type')) : echo "prototype"; else: echo "design"; endif; ?></span><span class="whiskers-right"></span></a>
<?php endif;
if(get_field('uploaded_file')):?>
    <a class='btn btn-primary' target='_blank' role='button' href='<?= get_field('uploaded_file'); ?>'><span class="whiskers-left"></span><i class="fa-solid fa-file-pdf"></i><span class="btn-text">View mockup</span><span class="whiskers-right"></span></a>
<?php endif;
if(get_field('external_site')):?>
    <a class='btn btn-primary' target='_blank' role='button' rel='external' href='<?= get_field('external_site'); ?>'><span class="whiskers-left"></span><i class="fa-solid fa-globe"></i><span class="btn-text">View site</span><span class="whiskers-right"></span></a>
<?php endif;?>
</div>
<div class="btn-group" style="padding-bottom:5em;margin-top:0;!important">
<a class='btn btn-primary' role='button' href='/portfolio'><span class="whiskers-left"></span><i class="fa-solid fa-left-long"></i><span class="btn-text">View all projects</span><span class="whiskers-right"></span></a>
</div>
<div class="entry-links"><?php //wp_link_pages(); ?></div>
</div>