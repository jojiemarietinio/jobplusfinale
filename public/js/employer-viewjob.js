$(document).ready(function(){
    initialize();
    initializeMap();

$(document).on('click','#btn-viewjob',function(){
        $('#viewjob-Modal').modal('show');
    });

}

var local;
var map;
var centers = {lat:10.309937078055952,lng:123.89307975769043};
function initializeMap(){
    map = new google.maps.Map(document.getElementById('map'), {
        center:centers,
        zoom: 18,
        mapTypeId: google.maps.MapTypeId.HYBRID
    });
    var input = document.getElementById('job-address');
    var searchBox = new google.maps.places.SearchBox(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });
        var markers = [];
        google.maps.event.addListener(map, 'click', function (e) {
            var ll = {lat: e.latLng.lat(), lng: e.latLng.lng()};
              //alert(e.latLng.lat());
              markers.forEach(function(marker) {
                marker.setMap(null);
              });
              markers = [];
              lastMarker = new google.maps.Marker({
                position: ll,
                map: map,
                title: 'Hello World!'
              });
              markers.push(lastMarker);
              getAddressByLatlng(ll);
          });
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();
            if (places.length == 0) {
                return;
            }
          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];
          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };
            // Create a marker for each place.
            markers.push(new google.maps.Marker({
                map: map,
                icon: icon,
                title: place.name,
                position: place.geometry.location
            }));
            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }
      });
          map.fitBounds(bounds);
      });
        function getAddressByLatlng(latlng){
            var lat =latlng.lat;
            var lng =latlng.lng;
            var inputSearchBox = document.getElementById('job-address');
            var cLatValId = document.getElementById('clat');
            var cLongValId = document.getElementById('clong');
            cLatValId.value=lat;
            cLongValId.value=lng;
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        inputSearchBox.value =  results[1].formatted_address;
                    }
                    var res = results[0].address_components;
                    for(var i=0; i<res.length; i++){
                        for (var y = 0; y<(res[i].types).length; y++) {
                            if(res[i].types[y] === "locality") {
                                local= res[i].long_name;
                            }
                        }
                     }
                 }
            });
        }
    }
    $("#jobpost-Modal").on("shown.bs.modal", function () {
        google.maps.event.trigger(map, "resize");
        map.setCenter(centers);
    });