jQuery(document).ready(function ($) {
  function loadMoreImages() {
    var button = $("#load-more-images");
    var offset = button.data("offset");

    console.log("Offset:", offset);

    $.ajax({
      url: load_more_params.ajaxurl,
      type: "POST",
      data: {
        action: "load_more_images",
        offset: offset,
      },
      beforeSend: function () {
        button.text("Please Wait...");
      },
      success: function (response) {
        console.log("Response:", response);

        if (response) {
          $("#load-more-wrapper").remove();

          var newContent = $(response).hide();
          $("#image-gallery").append(newContent);
          newContent.fadeIn("slow");

          $("html, body").animate(
            {
              scrollTop: $("#load-more-wrapper").offset().top,
            },
            800
          );
        } else {
          button.remove();
        }
      },
    });
  }

  $("#image-gallery").on("click", "#load-more-images", loadMoreImages);
});
