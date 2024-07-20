// jQuery(document).ready(function($) {
//     $('#propertyType, #location, #category').on('change keyup', function() {
//         var propertyType = $('#propertyType').val();
//         var location = $('#location').val();
//         var category = $('#category').val();
//         var ajaxurl = "http://localhost/fitness/wp-admin/admin-ajax.php";

//         $.ajax({
//             url: ajaxurl, // WordPress provides this URL in the admin area
//             type: 'GET',
//             data: {
//                 action: 'fetch_properties',
//                 property_type: propertyType,
//                 location: location,
//                 category: category
//             },
//             success: function(data) {
//                 $('.posts').html(data);
//             }
//         });
//     });
// });


jQuery(document).ready(function($) {
    $('#propertyType, #location, #category').on('change keyup', function() {
        var propertyType = $('#propertyType').val();
        var location = $('#location').val();
        var category = $('#category').val();
        var ajaxurl = "http://localhost/fitness/wp-admin/admin-ajax.php";
        // var ajaxurl = ajax_object.ajaxurl;
        

        $('.posts').fadeOut(600, function() {
            $.ajax({
                url: ajaxurl,
                type: 'GET',
                data: {
                    action: 'fetch_properties',
                    property_type: propertyType,
                    location: location,
                    category: category
                },
                success: function(data) {
                    $('.posts').html(data);
                    $('.posts').fadeIn(600);
                }
            });
        });
    });
});
