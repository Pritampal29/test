jQuery(document).ready(function ($) {
  var initialLimit = 6; // Initial limit set in the PHP

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
      },
    });
  }

  function loadLessImages() {
    $("#image-gallery > a").slice(initialLimit).fadeOut("slow", function () {
      $(this).remove();

      if ($("#image-gallery > a").length <= initialLimit) {
        history.go(0);
      }
    });
  }

  $(document).on("click", "#load-more-images", loadMoreImages);
  $(document).on("click", "#load-less-images", loadLessImages);
});
