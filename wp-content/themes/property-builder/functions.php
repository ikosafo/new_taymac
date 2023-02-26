<?php

require get_stylesheet_directory() . '/customizer/customizer.php';

add_action( 'after_setup_theme', 'property_builder_after_setup_theme' );
function property_builder_after_setup_theme() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'property-builder-featured-image', 2000, 1200, true );
    add_image_size( 'property-builder-thumbnail-avatar', 100, 100, true );

    // Set the default content width.
    $GLOBALS['content_width'] = 525;

    // Add theme support for Custom Logo.
    add_theme_support( 'custom-logo', array(
        'width'       => 250,
        'height'      => 250,
        'flex-width'  => true,
    ) );

    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff'
    ) );

    add_theme_support( 'html5', array('comment-form','comment-list','gallery','caption',) );

    add_editor_style( array( 'assets/css/editor-style.css') );
}

/**
 * Register widget area.
 */
function property_builder_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Blog Sidebar', 'property-builder' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'property-builder' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Page Sidebar', 'property-builder' ),
        'id'            => 'sidebar-2',
        'description'   => __( 'Add widgets here to appear in your sidebar on pages.', 'property-builder' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Sidebar 3', 'property-builder' ),
        'id'            => 'sidebar-3',
        'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'property-builder' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 1', 'property-builder' ),
        'id'            => 'footer-1',
        'description'   => __( 'Add widgets here to appear in your footer.', 'property-builder' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 2', 'property-builder' ),
        'id'            => 'footer-2',
        'description'   => __( 'Add widgets here to appear in your footer.', 'property-builder' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 3', 'property-builder' ),
        'id'            => 'footer-3',
        'description'   => __( 'Add widgets here to appear in your footer.', 'property-builder' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 4', 'property-builder' ),
        'id'            => 'footer-4',
        'description'   => __( 'Add widgets here to appear in your footer.', 'property-builder' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'property_builder_widgets_init' );

// enqueue styles for child theme
function property_builder_enqueue_styles() {

    // Bootstrap
    wp_enqueue_style( 'bootstrap-css', get_theme_file_uri( '/assets/css/bootstrap.css' ) );

    // Owl Carousel
    wp_enqueue_style( 'owl.carousel-css', get_theme_file_uri( '/assets/css/owl.carousel.css' ) );

    // Theme block stylesheet.
    wp_enqueue_style( 'property-builder-block-style', get_theme_file_uri( '/assets/css/blocks.css' ), array( 'property-builder-child-style' ), '1.0' );
    
    // enqueue parent styles
    wp_enqueue_style('construction-hub-style', get_template_directory_uri() .'/style.css');
    
    // enqueue child styles
    wp_enqueue_style('property-builder-child-style', get_stylesheet_directory_uri() .'/style.css', array('construction-hub-style'));

    require get_theme_file_path( '/tp-theme-color.php' );
    wp_add_inline_style( 'property-builder-child-style',$construction_hub_tp_theme_css );

    wp_style_add_data('property-builder-child-style', 'rtl', 'replace');
    
    // Owl Carousel
    wp_enqueue_script( 'owl.carousel-js', get_stylesheet_directory_uri() . '/assets/js/owl.carousel.js', array( 'jquery' ));

    // Custom JS
    wp_enqueue_script( 'property-builder-custom-script-js', get_stylesheet_directory_uri() . '/assets/js/script.js', array( 'jquery' ));

    wp_enqueue_script( 'comment-reply', '/wp-includes/js/comment-reply.min.js', array(), false, true );    
}
add_action('wp_enqueue_scripts', 'property_builder_enqueue_styles');

function property_builder_header_style() {
    if ( get_header_image() ) :
    $custom_header = "
        .header-main{
            background-image:url('".esc_url(get_header_image())."') !important;
            background-position: center top;
        }";
        wp_add_inline_style( 'property-builder-child-style', $custom_header );
    endif;
}
add_action( 'wp_enqueue_scripts', 'property_builder_header_style' );

function property_builder_admin_scripts() {
    // Backend CSS
    wp_enqueue_style( 'property-builder-backend-css', get_theme_file_uri( '/assets/css/customizer.css' ) );
}
add_action( 'admin_enqueue_scripts', 'property_builder_admin_scripts' );

define('PROPERTY_BUILDER_CREDIT',__('https://www.themespride.com/themes/free-property-builder-wordpress-theme/','property-builder') );
if ( ! function_exists( 'property_builder_credit' ) ) {
    function property_builder_credit(){
        echo "<a href=".esc_url(PROPERTY_BUILDER_CREDIT)." target='_blank'>".esc_html__('Property Builder WordPress Theme','property-builder')."</a>";
    }
}

if ( ! defined( 'CONSTRUCTION_HUB_PRO_THEME_NAME' ) ) {
    define( 'CONSTRUCTION_HUB_PRO_THEME_NAME', esc_html__( 'Builder Pro Theme', 'property-builder' ));
}
if ( ! defined( 'CONSTRUCTION_HUB_FREE_THEME_URL' ) ) {
    define( 'CONSTRUCTION_HUB_FREE_THEME_URL', 'https://www.themespride.com/themes/free-property-builder-wordpress-theme/' );
}
if ( ! defined( 'CONSTRUCTION_HUB_RATE_THEME_URL' ) ) {
    define( 'CONSTRUCTION_HUB_RATE_THEME_URL', 'https://wordpress.org/support/theme/property-builder/reviews/' );
}
if ( ! defined( 'CONSTRUCTION_HUB_CHANGELOG_THEME_URL' ) ) {
    define( 'CONSTRUCTION_HUB_CHANGELOG_THEME_URL', get_stylesheet_directory() . '/readme.txt' );
}
if ( ! defined( 'CONSTRUCTION_HUB_SUPPORT_THEME_URL' ) ) {
    define( 'CONSTRUCTION_HUB_SUPPORT_THEME_URL', 'https://wordpress.org/support/theme/property-builder/' );
}