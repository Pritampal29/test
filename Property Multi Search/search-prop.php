<?php
/**
 * Template Name: Property Listing
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Listing</title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">
</head>
<body>

<div class="banner">
    <h1><?php the_title();?></h1>
</div>

<?php 
    if(isset($_GET['property_type']) && isset($_GET['location']) && isset($_GET['category'])) {
        $p_type = $_GET['property_type'];
        $p_loc = $_GET['location'];
        $p_cat = $_GET['category'];
    } ?>

<div class="searchQ">
    <h5>Search Result for <?php echo $p_type;?>,<?php echo $p_loc;?>,<?php echo $p_cat;?></h5>
</div>

<div class="posts">
    <?php
    $args = array(
        'post_type' => 'properties',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    // Modify query based on search form inputs
    if (isset($_GET['property_type']) && !empty($_GET['property_type'])) {
        $args['meta_query'][] = array(
            'key' => 'property_type',
            'value' => sanitize_text_field($_GET['property_type']),
            'compare' => '=',
        );
    }

    if (isset($_GET['location']) && !empty($_GET['location'])) {
        $args['meta_query'][] = array(
            'key' => 'property_location',
            'value' => sanitize_text_field($_GET['location']),
            'compare' => 'LIKE',
        );
    }

    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'properties-category',
            'field' => 'slug',
            'terms' => sanitize_text_field($_GET['category']),
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
    ?>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
</body>
</html>
