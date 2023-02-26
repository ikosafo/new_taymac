<?php
/**
 * Construction Hub functions and definitions
 *
 * @package Construction Hub
 * @subpackage construction_hub
 */
function construction_hub_setup() {
	
	load_theme_textdomain( 'construction-hub', get_template_directory() . '/language' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'title-tag' );
	add_theme_support( "responsive-embeds" );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'construction-hub-featured-image', 2000, 1200, true );
	add_image_size( 'construction-hub-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary-menu'    => __( 'Primary Menu', 'construction-hub' ),
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array('image','video','gallery','audio',) );

	add_theme_support( 'html5', array('comment-form','comment-list','gallery','caption',) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', construction_hub_fonts_url() ) );
}
add_action( 'after_setup_theme', 'construction_hub_setup' );

/**
 * Register custom fonts.
 */
function construction_hub_fonts_url(){
	$construction_hub_font_url = '';
	$construction_hub_font_family = array();
	$construction_hub_font_family[] = 'Fira Sans:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';
	$construction_hub_font_family[] = 'Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';

	$construction_hub_query_args = array(
		'family'	=> rawurlencode(implode('|',$construction_hub_font_family)),
	);
	$construction_hub_font_url = add_query_arg($construction_hub_query_args,'//fonts.googleapis.com/css');
	return $construction_hub_font_url;
}

/**
 * Register widget area.
 */
function construction_hub_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'construction-hub' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'construction-hub' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Page Sidebar', 'construction-hub' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your sidebar on pages.', 'construction-hub' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 3', 'construction-hub' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'construction-hub' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'construction-hub' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add widgets here to appear in your footer.', 'construction-hub' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'construction-hub' ),
		'id'            => 'footer-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'construction-hub' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'construction-hub' ),
		'id'            => 'footer-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'construction-hub' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'construction-hub' ),
		'id'            => 'footer-4',
		'description'   => __( 'Add widgets here to appear in your footer.', 'construction-hub' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'construction_hub_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function construction_hub_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'construction-hub-fonts', construction_hub_fonts_url(), array(), null );

	// Bootstrap
	wp_enqueue_style( 'bootstrap-css', get_theme_file_uri( '/assets/css/bootstrap.css' ) );

	// Theme stylesheet.
	wp_enqueue_style( 'construction-hub-style', get_stylesheet_uri() );
	require get_parent_theme_file_path( '/tp-theme-color.php' );
	require get_parent_theme_file_path( '/tp-body-width-layout.php' );
	wp_add_inline_style( 'construction-hub-style',$construction_hub_tp_theme_css );
	wp_style_add_data('construction-hub-style', 'rtl', 'replace');

	// Theme block stylesheet.
	wp_enqueue_style( 'construction-hub-block-style', get_theme_file_uri( '/assets/css/blocks.css' ), array( 'construction-hub-style' ), '1.0' );

	// Fontawesome
	wp_enqueue_style( 'fontawesome-css', get_theme_file_uri( '/assets/css/fontawesome-all.css' ) );

	wp_enqueue_script( 'bootstrap-js', get_theme_file_uri( '/assets/js/bootstrap.js' ), array( 'jquery' ), true );

	if(!wp_is_mobile()){
		wp_enqueue_script( 'jquery-superfish', get_theme_file_uri( '/assets/js/jquery.superfish.js' ), array( 'jquery' ), true );
		wp_enqueue_script( 'construction-hub-superfish-custom-scripts', esc_url( get_template_directory_uri() ) . '/assets/js/construction-hub-superfish-custom.js', array('jquery','jquery-superfish'), true);
	}

	wp_enqueue_script( 'construction-hub-custom-scripts', esc_url( get_template_directory_uri() ) . '/assets/js/construction-hub-custom.js', array('jquery'), true);

	wp_enqueue_script( 'construction-hub-focus-nav', esc_url( get_template_directory_uri() ) . '/assets/js/focus-nav.js', array('jquery'), true);
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'construction_hub_scripts' );

//Admin Enqueue for Admin
function construction_hub_admin_enqueue_scripts(){
	wp_enqueue_style('construction-hub-admin-style', esc_url( get_template_directory_uri() ) . '/assets/css/admin.css');
	wp_enqueue_script( 'construction-hub-custom-scripts', esc_url( get_template_directory_uri() ). '/assets/js/construction-hub-custom.js', array('jquery'), true);
}
add_action( 'admin_enqueue_scripts', 'construction_hub_admin_enqueue_scripts' );

/*radio button sanitization*/
function construction_hub_sanitize_choices( $input, $setting ) {
    global $wp_customize; 
    $control = $wp_customize->get_control( $setting->id ); 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

/* Excerpt Limit Begin */
function construction_hub_string_limit_words($string, $word_limit) {
	$construction_hub_words = explode(' ', $string, ($word_limit + 1));
	if(count($construction_hub_words) > $word_limit)
	array_pop($construction_hub_words);
	return implode(' ', $construction_hub_words);
}

function construction_hub_sanitize_dropdown_pages( $page_id, $setting ) {
  // Ensure $input is an absolute integer.
  $page_id = absint( $page_id );
  // If $page_id is an ID of a published page, return it; otherwise, return the default.
  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

function construction_hub_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

function construction_hub_sanitize_checkbox( $input ) {
	// Boolean check 
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function construction_hub_sanitize_number_absint( $number, $setting ) {
	// Ensure $number is an absolute integer (whole number, zero or greater).
	$number = absint( $number );
	
	// If the input is an absolute integer, return it; otherwise, return the default
	return ( $number ? $number : $setting->default );
}

function construction_hub_sanitize_number_range( $number, $setting ) {
	
	// Ensure input is an absolute integer.
	$number = absint( $number );
	
	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;
	
	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
	
	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
	
	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
	
	// If the number is within the valid range, return it; otherwise, return the default
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'construction_hub_loop_columns');
if (!function_exists('construction_hub_loop_columns')) {
	function construction_hub_loop_columns() {
		$columns = get_theme_mod( 'construction_hub_per_columns', 3 );
		return $columns;
	}
}

//Change number of products that are displayed per page (shop page)
add_filter( 'loop_shop_per_page', 'construction_hub_per_page', 20 );
function construction_hub_per_page( $cols ) {
  	$cols = get_theme_mod( 'construction_hub_product_per_page', 9 );
	return $cols;
}

/**
 * Use front-page.php when Front page displays is set to a static page.
 */
function construction_hub_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template','construction_hub_front_page_template' );

define('CONSTRUCTION_HUB_CREDIT',__('https://www.themespride.com/themes/free-construction-wordpress-theme/','construction-hub') );
if ( ! function_exists( 'construction_hub_credit' ) ) {
	function construction_hub_credit(){
		echo "<a href=".esc_url(CONSTRUCTION_HUB_CREDIT)." target='_blank'>".esc_html__('Construction WordPress Theme','construction-hub')."</a>";
	}
}

function construction_hub_activation_notice() { ?>
    <div class="updated notice notice-get-started-class is-dismissible" data-notice="get_started">
        <div class="construction-hub-getting-started-notice clearfix">
            <div class="construction-hub-theme-notice-content">
                <h2 class="construction-hub-notice-h2">
	            	<?php
		                printf(
		                /* translators: 1: welcome page link starting html tag, 2: welcome page link ending html tag. */
		                    esc_html__( 'Welcome! Thank you for choosing %1$s!', 'construction-hub' ), '<strong>'. wp_get_theme()->get('Name'). '</strong>' );
	                ?>
                </h2>

                <p class="plugin-install-notice"><?php echo sprintf(__('Click here to get started with the theme set-up.', 'construction-hub')) ?></p>

                <a class="construction-hub-btn-get-started button button-primary button-hero construction-hub-button-padding" href="<?php echo esc_url( admin_url( 'themes.php?page=construction-hub-about' )); ?>" ><?php esc_html_e( 'Get started', 'construction-hub' ) ?></a><span class="construction-hub-push-down">
                <?php
                    /* translators: %1$s: Anchor link start %2$s: Anchor link end */
                    printf(
                        'or %1$sCustomize theme%2$s</a></span>',
                        '<a target="_blank" href="' . esc_url( admin_url( 'customize.php' ) ) . '">',
                        '</a>'
                    );
                ?>
            </div>
        </div>
    </div>
<?php }

add_action( 'admin_notices', 'construction_hub_activation_notice' );

/**
 * Logo Custamization.
 */

function construction_hub_logo_width(){

	$construction_hub_logo_width   = get_theme_mod( 'construction_hub_logo_width', 80 );

	echo "<style type='text/css' media='all'>"; ?>
		img.custom-logo {
		    width: <?php echo absint( $construction_hub_logo_width ); ?>px;
		    max-width: 100%;
		}
	<?php echo "</style>";
}

add_action( 'wp_head', 'construction_hub_logo_width' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * Load Theme About Page
 */
require get_parent_theme_file_path( '/inc/about-theme.php' );