jQuery(function ($) {
  $(".loadmore").click(function () {
    var button = $(this),
      data = {
        action: "loadmore",
        query: boilerplate_params.posts, // Get params from localize script function
        page: boilerplate_params.current_page,
      };

    $.ajax({
      url: boilerplate_params.ajax_url, // AJAX handler
      data: data,
      type: "POST",
      beforeSend: function (xhr) {
        button.text("Loading..."); // change the button text
      },
      success: function (data) {
        if (data) {
          button.text("More posts").prev().after(data); // inset new posts
          boilerplate_params.current_page++;

          if (boilerplate_params.current_page == boilerplate_params.max_page) {
            button.remove(); // if the last page, remove the button
          }
        } else {
          button.remove();
        }
      },
    });
  });
});
