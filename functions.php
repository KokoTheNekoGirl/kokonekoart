<?php

add_action( 'after_setup_theme', 'kokoneko_setup' );
function kokoneko_setup() {
load_theme_textdomain( 'kokoneko', get_template_directory() . '/languages' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'responsive-embeds' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'html5', array( 'search-form', 'navigation-widgets' ) );
add_theme_support( 'appearance-tools' );
add_theme_support( 'woocommerce' );
global $content_width;
if ( !isset( $content_width ) ) { $content_width = 1920; }
register_nav_menus( array( 'primary_menu' => esc_html__( 'Primary Menu', 'kokoneko' ) ) );
}
add_action( 'wp_enqueue_scripts', 'kokoneko_enqueue' );
function kokoneko_enqueue() {
    wp_enqueue_style( 'kokoneko-style', get_stylesheet_uri() );
    wp_enqueue_style( 'kokoneko-theme-style', get_template_directory_uri()."/css/theme.css" );
    wp_enqueue_style( 'kokoneko-resume-style', get_template_directory_uri()."/css/resume.css" );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'kokoneko-scripts', get_template_directory_uri()."/js/scripts.js" );
}
add_action( 'wp_footer', 'kokoneko_footer' );
function kokoneko_footer() {
?>
<script>
jQuery(document).ready(function($) {
var deviceAgent = navigator.userAgent.toLowerCase();
if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
$("html").addClass("ios");
$("html").addClass("mobile");
}
if (deviceAgent.match(/(Android)/)) {
$("html").addClass("android");
$("html").addClass("mobile");
}
if (navigator.userAgent.search("MSIE") >= 0) {
$("html").addClass("ie");
}
else if (navigator.userAgent.search("Chrome") >= 0) {
$("html").addClass("chrome");
}
else if (navigator.userAgent.search("Firefox") >= 0) {
$("html").addClass("firefox");
}
else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
$("html").addClass("safari");
}
else if (navigator.userAgent.search("Opera") >= 0) {
$("html").addClass("opera");
}
});
</script>
<?php
}
add_filter( 'document_title_separator', 'kokoneko_document_title_separator' );
function kokoneko_document_title_separator( $sep ) {
$sep = esc_html( '|' );
return $sep;
}
add_filter( 'the_title', 'kokoneko_title' );
function kokoneko_title( $title ) {
if ( $title == '' ) {
return esc_html( '...' );
} else {
return wp_kses_post( $title );
}
}
function kokoneko_schema_type() {
$schema = 'https://schema.org/';
if ( is_single() ) {
$type = "Article";
} elseif ( is_author() ) {
$type = 'ProfilePage';
} elseif ( is_search() ) {
$type = 'SearchResultsPage';
} else {
$type = 'WebPage';
}
echo 'itemscope itemtype="' . esc_url( $schema ) . esc_attr( $type ) . '"';
}
add_filter( 'nav_menu_link_attributes', 'kokoneko_schema_url', 10 );
function kokoneko_schema_url( $atts ) {
$atts['itemprop'] = 'url';
return $atts;
}
if ( !function_exists( 'kokoneko_wp_body_open' ) ) {
function kokoneko_wp_body_open() {
do_action( 'wp_body_open' );
}
}
add_action( 'wp_body_open', 'kokoneko_skip_link', 5 );


function kokoneko_skip_link() {
echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__( 'Skip to the content', 'kokoneko' ) . '</a>';
}
add_filter( 'the_content_more_link', 'kokoneko_read_more_link' );

function kokoneko_read_more_link() {
    if ( !is_admin() ) {
        return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . sprintf( __( '...%s', 'kokoneko' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
    }
}
add_filter( 'excerpt_more', 'kokoneko_excerpt_read_more_link' );

function kokoneko_excerpt_read_more_link( $more ) {
if ( !is_admin() ) {
    global $post;
    return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">' . sprintf( __( '...%s', 'kokoneko' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
}
}
add_filter( 'big_image_size_threshold', '__return_false' );
add_filter( 'intermediate_image_sizes_advanced', 'kokoneko_image_insert_override' );

function kokoneko_image_insert_override( $sizes ) {
    unset( $sizes['medium_large'] );
    unset( $sizes['1536x1536'] );
    unset( $sizes['2048x2048'] );
    return $sizes;
}
add_action( 'widgets_init', 'kokoneko_widgets_init' );

function kokoneko_widgets_init() {
    register_sidebar( array(
            'name' => esc_html__( 'Sidebar Widget Area', 'kokoneko' ),
            'id' => 'primary-widget-area',
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
    }
add_action( 'wp_head', 'kokoneko_pingback_header' );

function kokoneko_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}

function custom_wp_head() {
    ?>
    <meta name="robots" content="noai, noimageai">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles:wght@400;700&family=Reem+Kufi:wght@400..700&family=Spinnaker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <?php
}
add_action('wp_head', 'custom_wp_head');

function custom_wp_body() {
    ?>
    <div id="clouds"></div>
    <div id="star-container"></div>

    <div class="custom-recaptcha-badge" aria-label="Site protection">
        <div class="custom-recaptcha-badge__icon">
            <img src="<?= get_template_directory_uri(); ?>/img/symbols/recaptcha.svg" alt="reCAPTCHA" width="64" height="64">
        </div>

        <div class="custom-recaptcha-badge__content">
            <span>protected by reCAPTCHA</span>
        </div>
    </div>
    <?php
}
add_action('wp_body_open', 'custom_wp_body');

function font_awesome_enqueue() {
    wp_enqueue_style( 
        'font-awesome', 
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css', 
        array(), 
        '7.3.1' 
    );
}
add_action( 'wp_enqueue_scripts', 'font_awesome_enqueue' );

//Enqueue Slick Slider Settings
function slick_enqueue() {
    wp_register_style('slick_base', get_stylesheet_directory_uri() . '/css/slick.css');
	wp_enqueue_style('slick_base');
	wp_register_script( 'slick_library', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '', true );
	wp_enqueue_script( 'slick_library' );
}
add_action( 'wp_enqueue_scripts', 'slick_enqueue');

function slick_ini(){

        echo '<script>jQuery(document).ready(function(){

            jQuery(".viewport-content").slick({
		        dots: false,
		        arrows: false,
                infinite: true,
                speed: 750,
                fade: true,
                cssEase: "linear",
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2500,

          });
          
          jQuery(".viewport-content-img").slick({
		        dots: false,
		        arrows: false,
                infinite: true,
                speed: 750,
                fade: true,
                cssEase: "linear",
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 5000,

          });

      });</script>';

}
add_action('wp_footer','slick_ini',21,1);

function add_post_slug_to_body_class( $classes ) {
    global $post;
    if ( isset( $post ) ) {
        if ( is_single() ) {
            $classes[] = 'post-' . $post->post_name; // For posts
        }
        elseif ( is_page() ) {
            $classes[] = 'page-' . $post->post_name; // For pages
        }
    }
    return $classes;
}
add_filter( 'body_class', 'add_post_slug_to_body_class' );

function disable_mytheme_action() {
  define('DISALLOW_FILE_EDIT', TRUE);
}
add_action('admin_init','disable_mytheme_action'); 

function koko_add_csp_header() {
    header("Content-Security-Policy: base-uri 'self'; default-src 'self'; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://fonts.googleapis.com https://use.fontawesome.com https://www.gstatic.com; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com https://www.google.com https://www.gstatic.com https://www.googletagmanager.com https://www.google-analytics.com https://www.paypal.com https://www.paypalobjects.com; img-src 'self' data: https://i1.ytimg.com https://i2.ytimg.com https://i3.ytimg.com https://i4.ytimg.com https://s.w.org https://www.paypal.com https://www.paypalobjects.com https://lh3.googleusercontent.com https://www.kokoneko.art/; media-src 'self'; font-src 'self' data: https://fonts.gstatic.com https://cdnjs.cloudflare.com https://ka-f.fontawesome.com https://use.fontawesome.com; connect-src 'self' https://ka-f.fontawesome.com https://www.google-analytics.com https://www.googletagmanager.com https://www.paypal.com https://www.paypalobjects.com; worker-src 'self' blob:; frame-src 'self' https://www.youtube.com https://www.paypal.com https://www.google.com; form-action 'self';");

    header("Strict-Transport-Security: max-age=31536000; includeSubDomains");

    header("X-Frame-Options: SAMEORIGIN"); 

    header("X-Content-Type-Options: nosniff");

    header("Referrer-Policy: strict-origin-when-cross-origin");

    header("Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=(https://paypal.com)"); 
}
add_action('send_headers', 'koko_add_csp_header');

function keep_critical_errors_only_css() {
    echo '<style>
        /* Hide all success, information, and general warning alerts */
        .notice-success, 
        .notice-info, 
        .notice-warning, 
        .update-nag, 
        .vc_license-activation-notice { 
            display: none !important; 
        }
        
        /* Explicitly keep error wrappers visible */
        .notice-error { 
            display: block !important; 
        }
    </style>';
}
add_action('admin_head', 'keep_critical_errors_only_css');

function redirect_logged_in_to_404() {
    if ( !is_user_logged_in() && get_field('hidden_page')) {
        
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
        
        // Load the theme's 404 template
        include( get_query_template( '404' ) );
        exit;
    }
}
add_action('template_redirect', 'redirect_logged_in_to_404');

function scf_json_save_point( $path ) {
    return get_stylesheet_directory() . '/scf-json';
}

add_filter( 'acf/settings/save_json', 'scf_json_save_point' );

function scf_json_load_point( $paths ) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/scf-json';
    return $paths;
}

add_filter( 'acf/settings/load_json', 'scf_json_load_point' );

function get_contrast_color($hex) {
    $hex = ltrim($hex, '#');

    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

    return ($brightness >= 128) ? '#000000' : '#ffffff';
}

get_template_part('shortcodes');

//removes the filter that removes native custom fields
// add_filter('acf/settings/remove_wp_meta_box', '__return_false');
