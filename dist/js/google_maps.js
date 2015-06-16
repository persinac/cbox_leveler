/**
 * Created by APersinger on 05/08/15.
 */

var list_of_events;
var markers = [];
var map;

function initialize_gmaps() {
    var dataToSend = { "lat":44.5403,
        "long" : -78.5463
    };
    GetUserLat(1);
}

function FinishInit(data, events) {

    var mapCanvas = document.getElementById('map-canvas');
    var mapOptions = {
        center: new google.maps.LatLng(data.lat, data.long),
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(mapCanvas, mapOptions);
    /**
     * HOME lat/long, don't need - yet
    var myCenter = new google.maps.LatLng(data.lat, data.long);

    var marker = new google.maps.Marker({
        position:myCenter,
        map: map
    });
    marker.setMap(map);
     */
    for(i=0;i < events.length; i++) {
        AddMarker(events[i]);
    }
    setAllMap(map);
    LoadEventTable(events);
}

function AddMarker(event) {
    var infowindow = new google.maps.InfoWindow();
    var marker;
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(event.lat, event.long),
        map: map
    });
    markers.push(marker);

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
            html = '<div><h4>' + event.event_name + '</h4><p><h5>Level: <span>'+event.level+'</span> </h5></p>';
            html += '<p><h5>Date: <span>'+event.date+'</span> </h5></p>';
            html += '<p><h5>Host: <span>'+event.host_box+'</span> </h5></p></div>';
            infowindow.setContent(html);
            infowindow.open(map, marker);
        }
    })(marker, i));
}

// Sets the map on all markers in the array.
function setAllMap(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
    setAllMap(null);
}

// Shows any markers currently in the array.
function showMarkers() {
    setAllMap(map);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
    clearMarkers();
    markers = [];
}

function GetUserLat(user_id) {
    var coordinates = { "lat":44.5403,
        "long" : -78.5463
    };
    /**
     * Ajax function to get user latitude position from DB if applicable
     * If no lat is found in DB, call google API to get both Lat/Long
     */
    $.ajax({
        type: "POST",
        url: "/CRUD/general/test_geoCode.php",
        data: {"user_id":user_id},
        dataType: "html",
        success: function(response) {
            var retval = JSON.parse(response);
            var location = JSON.parse(retval.url_ret)
            var events = retval.events;
            list_of_events = events;
            console.log(location.results[0].geometry.location.lat);
            console.log(location.results[0].geometry.location.lng);
            coordinates.lat = location.results[0].geometry.location.lat;
            coordinates.long = location.results[0].geometry.location.lng;
            FinishInit(coordinates, events);
        }
    });
}