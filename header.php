<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php kokoneko_schema_type(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="commission-goal"><?= do_shortcode('[commission_goal]')?></div>
<div id="wrapper" class="hfeed">
<section class="topbar">
    <span>I stand with human artists and developers. <a href="https://www.teamhuman.org/" target="_blank" rel="external">Support #TeamHuman</a>.</span>
</section>
<header id="header" role="banner">
    <div id="branding">
        <div id="site-title" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
            <a class="site-branding" href="<?= esc_url( home_url( '/' ) );?>" title="<?= esc_attr( get_bloginfo( 'name' ) ) ?>" rel="home" itemprop="url">
                <img width="400" height="400" src="<?= get_template_directory_uri(); ?>/img/logo.png" class="site-logo" alt="KokoNekoArt's Logo" decoding="async" fetchpriority="high">
                <img width="1011" height="140" src="<?= get_template_directory_uri(); ?>/img/kokonekoart.png"  class="site-name" alt="KokoNekoArt" decoding="async">
            </a>
        </div>
    </div>
    <nav id="mobile-menu" class='site-nav' role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
        <input id="menu-toggle" name="mblmenu" type="checkbox" />
        <label for="menu-toggle">
            <i class="fa-solid"></i>
        </label>
        <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'link_before' => '<span itemprop="name">', 'link_after' => '</span>' ) ); ?>
    </nav>
    <nav id="menu" class='site-nav' role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
    <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'link_before' => '<span itemprop="name">', 'link_after' => '</span>' ) ); ?>
    </nav>
</header>
<div id="container">
<main id="content" role="main">