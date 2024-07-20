<?php
/**
 * Practice Purpose functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Practice_Purpose
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
function practice_purpose_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Practice Purpose, use a find and replace
		* to change 'practice-purpose' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'practice-purpose', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'practice-purpose' ),
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
			'practice_purpose_custom_background_args',
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
add_action( 'after_setup_theme', 'practice_purpose_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function practice_purpose_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'practice_purpose_content_width', 640 );
}
add_action( 'after_setup_theme', 'practice_purpose_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function practice_purpose_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'practice-purpose' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'practice-purpose' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'practice_purpose_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function practice_purpose_scripts() {
	wp_enqueue_style( 'practice-purpose-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'practice-purpose-style', 'rtl', 'replace' );

	wp_enqueue_script( 'practice-purpose-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'practice_purpose_scripts' );

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
 * Create Custom Post Type : Properties
 */

 function create_properties_post_type() {
	register_post_type( 'properties',
		array(
			'labels' => array(
				'name' => 'Properties' ,
				'singular_name' => 'Properties',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Properties',
				'edit_item' => 'Edit Properties',
				'new_item' => 'New Properties',
				'view_item' => 'View Properties',
				'search_items' => 'Search Properties',
				'not_found' =>  'Nothing Found',
				'not_found_in_trash' => 'Nothing found in the Trash',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon'  => 'dashicons-welcome-learn-more',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail','page-attributes')
		)
	);

}
add_action( 'init', 'create_properties_post_type' );

function my_taxonomies_properties() {
	$labels = array(
	  'name'              => _x('Properties Categories', 'taxonomy general name' ),
	  'singular_name'     => _x('Properties Category', 'taxonomy singular name' ),
	  'search_items'      => __( 'Search Properties Categories' ),
	  'all_items'         => __( 'All Properties Categories' ),
	  'parent_item'       => __( 'Parent Properties Category' ),
	  'parent_item_colon' => __( 'Parent Properties Category:' ),
	  'edit_item'         => __( 'Edit Properties Category' ), 
	  'update_item'       => __( 'Update Properties Category' ),
	  'add_new_item'      => __( 'Add New Properties Category' ),
	  'new_item_name'     => __( 'New Properties Category' ),
	  'menu_name'         => __( 'Properties Categories' ),
	);
	$args = array(
	  'labels' => $labels,
	  'hierarchical' => true,
	  'show_ui' => true,
	  'show_admin_column' => true, 
	  'query_var' => true,
	);
	register_taxonomy( 'properties-category', 'properties', $args );
}
add_action( 'init', 'my_taxonomies_properties', 0 );








// Ajax Call Handle For Searching Data

add_action('wp_ajax_fetch_properties', 'fetch_properties');
add_action('wp_ajax_nopriv_fetch_properties', 'fetch_properties');

function fetch_properties() {
    $property_type = sanitize_text_field($_GET['property_type']);
    $location = sanitize_text_field($_GET['location']);
    $category = sanitize_text_field($_GET['category']);

    $args = array(
        'post_type' => 'properties',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if (!empty($property_type)) {
        $args['meta_query'][] = array(
            'key' => 'property_type',
            'value' => $property_type,
            'compare' => '=',
        );
    }

    if (!empty($location)) {
        $args['meta_query'][] = array(
            'key' => 'property_location',
            'value' => $location,
            'compare' => 'LIKE',
        );
    }

    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'properties-category',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    $property_query = new WP_Query($args);

    if ($property_query->have_posts()) {
        while ($property_query->have_posts()) {
            $property_query->the_post();
            ?>
            <div class="post">
                <?php $featured_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>
                <img src="<?php echo $featured_image; ?>" alt="<?php the_title_attribute(); ?>">
                <h2><?php the_title(); ?></h2>
                <p>Published on: <span><?php echo get_the_date('F d, Y'); ?></span></p>
                <div class="details">
                    <?php
                    $categories = get_the_terms($post->ID, 'properties-category');
                    if ($categories && !is_wp_error($categories)) {
                        foreach ($categories as $cat) {
                            echo '<p>Category: <span>' . $cat->name . '</span></p>';
                        }
                    }
                    ?>
                    <p>Location: <span><?php echo get_field('property_location', $post->ID); ?></span></p>
                    <p>Property Type: <span><?php echo get_field('property_type', $post->ID); ?></span></p>
                </div>
            </div>
            <?php
        }
        wp_reset_postdata();
    } else {
        echo '<p>No properties found.</p>';
    }

    wp_die();
}

