<?php
/**
 * Pritam_wp_test functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Pritam_wp_test
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function pritam_wp_test_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Pritam_wp_test, use a find and replace
		* to change 'pritam_wp_test' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'pritam_wp_test', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'pritam_wp_test' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'pritam_wp_test_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'pritam_wp_test_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pritam_wp_test_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pritam_wp_test_content_width', 640 );
}
add_action( 'after_setup_theme', 'pritam_wp_test_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pritam_wp_test_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'pritam_wp_test' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'pritam_wp_test' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'pritam_wp_test_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function pritam_wp_test_scripts() {
	wp_enqueue_style( 'pritam_wp_test-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'pritam_wp_test-style', 'rtl', 'replace' );

	wp_enqueue_script( 'pritam_wp_test-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pritam_wp_test_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



/**
 * 
 * Custom Code
 * 
 */


/**
 * Enqueue JS File
 */
function enqueue_load_more_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('load-more', get_template_directory_uri() . '/js/load-more.js', array('jquery'), null, true);
  
	wp_localize_script('load-more', 'load_more_params', array(
	  'ajaxurl' => admin_url('admin-ajax.php')
	));
  }
  add_action('wp_enqueue_scripts', 'enqueue_load_more_scripts');
  
  /**
   * Handle Ajax Request
   */
  function load_more_images() {
	if (isset($_POST['offset'])) {
	  $offset = intval($_POST['offset']);
	}
  
	$counter = 0;
	$limit = 3; 
	$total_data = count(get_field('gallery_repeater', 8));
  
	ob_start();
  
	if (have_rows('gallery_repeater', 8)) {
	  while (have_rows('gallery_repeater', 8)) {
		the_row();
		$image = get_sub_field('images', 8);
  
		if ($counter >= $offset && $counter < $offset + $limit) {
		  ?>
		  <a href="<?php echo esc_url($image); ?>" data-toggle="lightbox" data-gallery="gallery" class="col-md-4">
			<img src="<?php echo esc_url($image); ?>" class="img-fluid rounded">
		  </a>
		  <?php
		}
		$counter++;
	  }
	} else {
	  echo 'No rows found';
	  wp_die();
	}
  
	if ($total_data > $offset + $limit) {
	  ?>
	  <div id="load-more-wrapper">
		<button id="load-more-images" data-offset="<?php echo $offset + $limit; ?>" class="btn btn-primary my-3">Load More</button>
	  </div>
	  <?php
	} else {
	  ?>
	  <div id="load-less-wrapper" style="display:none;">
		<button id="load-less-images" data-limit="<?php echo $offset + $limit - $limit; ?>" class="btn btn-primary my-3">Load Less</button>
	  </div>
	  <?php
	}
  
	$response = ob_get_clean();
  
	echo $response;
	wp_die();
  }
  add_action('wp_ajax_load_more_images', 'load_more_images');
  add_action('wp_ajax_nopriv_load_more_images', 'load_more_images');
  