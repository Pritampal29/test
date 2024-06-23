<?php
/**
 * This Template is for Displaying Home Page
 */

 get_header(); ?>

<style>
.row {
    margin: 15px;
}

button {
    text-align: center !important;
}

.row a {
    margin-bottom: 20px;
}

img {
    object-fit: cover;
    height: 220px;
    width: 300px;
}

/* #load-less-images{
    display: none;
} */
</style>



<section class="main-gallery">
  <div class="container">
    <div class="row" id="image-gallery">
      <?php
      if (have_rows('gallery_repeater', 8)) {
        $counter = 0;
        $limit = 6;
        while (have_rows('gallery_repeater', 8) && $counter < $limit) {
          the_row();
          $image = get_sub_field('images', 8);
          ?>
          <a href="<?php echo esc_url($image); ?>" data-toggle="lightbox" data-gallery="gallery" class="col-md-4">
            <img src="<?php echo esc_url($image); ?>" class="img-fluid rounded">
          </a>
          <?php
          $counter++;
        }
      }
      ?>
      <?php $total_data = count(get_field('gallery_repeater', 8));
      if ($total_data > $limit) { ?>
        <div id="load-more-wrapper">
          <button id="load-more-images" data-offset="<?php echo $limit; ?>" class="btn btn-primary my-3">Load More</button>
        </div>
        <div id="load-less-wrapper" style="display:none;">
          <button id="load-less-images" data-limit="<?php echo $limit; ?>" class="btn btn-primary my-3">Load Less</button>
        </div>
      <?php } ?>
    </div>
  </div>
</section>







<script>
$(document).on("click", '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});
</script>

<?php
get_footer();?>