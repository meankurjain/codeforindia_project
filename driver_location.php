<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Waypoints in directions</title>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
        float: left;
        width: 70%;
        height: 100%;
      }
#right-panel {
  font-family: 'Roboto','sans-serif';
  line-height: 30px;
  padding-left: 10px;
}

#right-panel select, #right-panel input {
  font-size: 15px;
}

#right-panel select {
  width: 100%;
}

#right-panel i {
  font-size: 12px;
}

      #right-panel {
        margin: 20px;
        border-width: 2px;
        width: 20%;
        float: left;
        text-align: left;
        padding-top: 20px;
      }
      #directions-panel {
        margin-top: 20px;
        background-color: #FFEE77;
        padding: 10px;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <div id="right-panel">
    
    <div id="directions-panel"></div>
    </div>
    <script>
function initMap() {
  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer;
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: {lat: 28.6100, lng: 77.2300}
  });
  directionsDisplay.setMap(map);

  
    calculateAndDisplayRoute(directionsService, directionsDisplay);
  
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
  var waypts = [];
  waypts.push({
        location: 'Ashok+Vihar,+Phase+II-GBSSS,068-ASHOK+VIHAR,NORTH+WEST+DELHI,Delhi,110052',
        stopover: true
      });
      waypts.push({
        location: 'RUKMINI+DEVI+PUBLIC+SCHOOL,054-PITAMPURA+(NORTH),NORTH+WEST+DELHI,Delhi,110034',
        stopover: true
      });
      waypts.push({
        location: 'Pooth+Khurd+Old,027-BEGUMPUR,NORTH+WEST+DELHI,Delhi,110039',
        stopover: true
      });
      waypts.push({
        location: 'Ashok+Vihar,+Phase+II-GBSSS,068-ASHOK+VIHAR,NORTH+WEST+DELHI,Delhi,110052',
        stopover: true
      });

  directionsService.route({
    origin: 'LALITA+BLOCK++II,73-SHASTRI+NAGAR,NORTH+DELHI,Delhi,110052',
    destination: 'LALITA+BLOCK++II,73-SHASTRI+NAGAR,NORTH+DELHI,Delhi,110052',
    waypoints: waypts,
    optimizeWaypoints: true,
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    if (status === google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
      var route = response.routes[0];
      var summaryPanel = document.getElementById('directions-panel');
      summaryPanel.innerHTML = '';
      // For each route, display summary information.
      for (var i = 0; i < route.legs.length; i++) {
        var routeSegment = i + 1;
        summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
            '</b><br>';
        summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
        summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
        summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
      }
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpM55wfpCD2ARxmyhb-CljqftzmPYZsOg&signed_in=true&callback=initMap"
        async defer></script>
  </body>
</html>

