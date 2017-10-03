(function(window,mapster ){
		
	var option = mapster.MAP_OPTIONS,
	element = document.getElementById('gmap'),

	map = mapster.create(element,option);

var marker = map.addMarker({
		lat: 10.312468,
		lng: 123.879362,
		content: 'Bagzki' 
});

/*
var found = map.findMarkerByLat(37.791350);
console.log(found);
*/

/*
map._removeMarker(marker2);
console.log(map.markers);
*/

}(window, window.Mapster));

/*
Marker
var mark = new google.maps.Marker({	
		position: {
			lat:37.791350,
			lng:-122.435883
		},
		map: map.gMap
	});*/

/*
Marker with Event
var marker = map.addMarker({
		lat:37.791350,
		lng:-122.435883,
		draggable:true,
		id:1,
		event: {
			name: 'click',
			callback: function(){
				alert('clicked!');
			}
		}
	});
	*/

