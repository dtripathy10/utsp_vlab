$(document).ready(function() {

//   $(window).scroll(function() {
//      if ($(this).scrollTop() > 1000) {
//         $('.scrollup').fadeIn();
//      } else {
//         $('.scrollup').fadeOut();
//      }
//   });
//
//   $('.scrollup').click(function() {
//      $("html, body").animate({scrollTop: 0}, 600);
//      return false;
//   });
   $("a[href^='http:']:not([href*='" + window.location.host + "'])").each(function() {
      $(this).attr("target", "_blank");
   });
   $(".alert-success").click(function() {

      $("#top_container1").css({
         "margin": "1px auto",
         "position": "relative"
      });
   });
});
