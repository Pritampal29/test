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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="banner text-center">
        <h1><?php the_title();?></h1>
    </div>




    <!-- Ajax Based Search Form start -->
    <form id="searchForm">
        <select id="propertyType" name="property_type" class="form-control">
            <option value="">Select Property Type</option>
            <?php
                $args = array(
                    'post_type' => 'properties',
                    'posts_per_page' => -1,
                );
                $property_query = new WP_Query($args);

                $property_types = array();

                if ($property_query->have_posts()) {
                    while ($property_query->have_posts()) {
                        $property_query->the_post();

                        $property_type = get_field('property_type');

                        if (!in_array($property_type, $property_types)) {
                            $property_types[] = $property_type;
                        }
                    }
                    wp_reset_postdata();

                    foreach ($property_types as $type) {
                        echo '<option value="' . $type . '">' . ucfirst($type) . '</option>';
                    }
                }
                ?>
        </select>

        <input id="location" type="text" placeholder="Location..." name="location" class="form-control">

        <?php
            $args = array(
                'taxonomy' => 'properties-category',
            );

            $cats = get_categories($args);
            ?>
        <select id="category" name="category" class="form-control">
            <option value="">Select One</option>
            <?php foreach ($cats as $cat) { ?>
            <option value="<?php echo $cat->slug; ?>"><?php echo $cat->name; ?></option>
            <?php } ?>
        </select>
    </form>
    <!-- Ajax Based Search Form end -->

    <?php 
    if(isset($_GET['property_type']) && isset($_GET['location']) && isset($_GET['category'])) {
        $p_type = $_GET['property_type'];
        $p_loc = $_GET['location'];
        $p_cat = $_GET['category']; ?>



    <!-- Showing data if someone search from Home page start -->
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
    <!-- Showing data if someone search from Home page end -->

    <?php } else { ?>

    <!-- Showing all Data by default start -->
    <div class="posts">
        <?php
        $args = array(
            'post_type' => 'properties',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        );

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
    <!-- Showing all Data by default end -->

    <?php } ?>


    <script src="<?php echo get_template_directory_uri(); ?>/js/ajax-search.js"></script>
</body>

</html>