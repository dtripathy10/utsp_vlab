$(document).ready(function() {
            $("a[href^='http:']:not([href*='" + window.location.host + "'])").each(function() {
                $(this).attr("target", "_blank");
            });
            $(".alert-success").click(function() {
            	
  					$("#top_container1").css( {
    "margin": "1px auto",
    "position": "relative"
  } );
			});
        });
