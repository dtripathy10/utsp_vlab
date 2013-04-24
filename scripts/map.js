var map;
function initialize() {
  	var latlng = new google.maps.LatLng(19.132587,72.917282);
    var mapOptions = {
    	zoom: 12,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		navigationControl: false,
		streetViewControl: false,	
	    mapTypeControl: false,
	    scaleControl: false,
	    scrollwheel: false    
    }
       
    map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
	var myLatlng = new google.maps.LatLng(19.132587,72.917282);
	var image = new google.maps.MarkerImage(
	  	'images/marker.png',
		new google.maps.Size(48, 62),
    	new google.maps.Point(0, 0),
    	new google.maps.Point(24, 62)
	);	
	var marker = new google.maps.Marker({
	    position: myLatlng,
	    map: map,
	    clickable: false,	    
	    title: 'UTSP VLab',
	    icon: image
	});  
	 
}

$(function(){
	$(".zoom_plus").click(function(){
		var zoom = map.getZoom();
		map.setZoom(zoom+1);
		return false;
	});
	$(".zoom_minus").click(function(){
		var zoom = map.getZoom();
		map.setZoom(zoom-1);
		return false;
	});
	
});
google.maps.event.addDomListener(window, 'load', initialize);