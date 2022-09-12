<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="shortcut icon" href="images/truck_icon.ico" />
    <link rel="stylesheet" href="service-style.css" />
    <title>Service</title>
  </head>
  <body>
    <!--*HTML Display-->

    <header>
      <h1><a href="index.html">Cargo</a></h1>
      <div>
        <ul class="menu">
          <li><a href="#">Help</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">My Earnings</a></li>
          <li><a href="#">Driver</a></li>
        </ul>
      </div>
    </header>
    <img src="images/bg_curve.svg" class="bg" alt="curve" />
    <div class="dialogue-box" id="dialogue-box">
    <h2 id="dialogue"></h2>
    <button class="accept" id="Accept" onclick="ifaccept()">Accept</button>
    <button class="decline" id="Decline" onclick="ifdecline()">Decline</button>
    </div>

    <!--*Map Display-->

    <div id="map"></div>

    <!--*Start of JavaScript-->
        
<?php
	// define variables and set to empty values 
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbName = "cargo";
		// Create connection
		$conn = new mysqli($servername, $username, $password,$dbName);
     
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
    $sql = "select * from cargo";
    $results=$conn->query($sql);
    if ($results->num_rows > 0) {
      // output data of each row
      echo "<script>";
      while($row = $results->fetch_assoc()) {
        
      echo "var PickAdd='".$row["PickUpAdd"]."';";
      echo "var DestAdd='".$row["DestAdd"]."';";
      echo "var PickLat='".$row["PickUpLat"]."';";
      echo "var PickLng='".$row["PickUpLng"]."';";
      
      }
      echo "</script>";
    }
?>
    <script>
     
      //global variables
      var userlat1= null;
      var userlat2 = parseFloat(PickLat);
      var userlng1 = null;
      var userlng2 = parseFloat(PickLng);
      var gmarkers = [];
      var gcircles = [];
      var directionsDisplay;
      var directionsService;
      document.getElementById("dialogue").innerHTML = `Pick-Up parcel from : ${PickAdd} <br><br> Deliver to : ${DestAdd}`;
      //Get User Location
      function getLocation() {
        navigator.geolocation.getCurrentPosition(showPosition);
      }

      function showPosition(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        userlat1 = lat;
        userlng1 = lng;
        initialize(lat, lng);
      }
      //Add Marker
      function addMarker(props, map) {
        var marker = new google.maps.Marker({
          position: props.coords,
          map: map,
          draggable: true,
          animation: google.maps.Animation.DROP,
          icon: props.iconImage,
          flat: false
        });
        var circle = new google.maps.Circle({
          map: map,
          radius: 10,
          fillColor: '#FF6347',
          strokeOpacity: 0,
          geodesic: true
        });
        circle.bindTo('center', marker, 'position');
        default_marker = marker;
        default_circle = circle;
        if (marker.position.lat() == userlat1) {
          gmarkers[0] = marker;
          gcircles[0] = circle;
        }
        if (marker.position.lat() == userlat2) {
          gmarkers[1] = marker;
          gcircles[1] = circle;
        }
      }
      //Map Functions
      function initialize(lat, lng) {
        var userlat = lat;
        var userlng = lng;
        //map options
        var options = {
          zoom: 18,
          center: { lat: userlat, lng: userlng },
          mapTypeControl: false,
          streetViewControl: false,
          zoomControl: false
        };
        
        //new map
        var map = new google.maps.Map(document.getElementById('map'), options);
        var directionsDisplay1 = new google.maps.DirectionsRenderer();
        var directionsService1 = new google.maps.DirectionsService();
        directionsDisplay = directionsDisplay1;
        directionsService = directionsService1;
        //add marker
        addMarker(
          { coords: { lat: userlat, lng: userlng }, iconImage: 'images/man_pickup.png' },
          map
        );
        document.getElementById('Accept').addEventListener("click", initMap2(map));;
      }
      
function initMap2(map) {
  var lat=userlat2;
  var lng=userlng2;
  var map1 = map;
  if (gmarkers[1]) {
    gmarkers[1].setMap(null);
    gcircles[1].setMap(null);
  }
  map1.setZoom(12);
  addMarker({ coords: { lat: userlat2, lng: userlng2 }, iconImage: 'images/girl_drop.png' }, map);
  calculateRoute(map1);
}
//Calculate Route
function calculateRoute(map1) {
  var map = map1;
  var latlng1 = new google.maps.LatLng(userlat1, userlng1);
  var latlng2 = new google.maps.LatLng(userlat2, userlng2);
  directionsDisplay.setMap(map);
  var request = {
    origin: latlng1,
    destination: latlng2,
    travelMode: 'DRIVING'
  };
  directionsDisplay.setOptions({
    suppressMarkers: true,
    polylineOptions: {
      strokeColor: '#FF6347',
      strokeOpacity: 0.7,
      strokeWeight: 5.5,
      geodesic: true
    }
  });
  directionsService.route(request, function(result, status) {
    if (status == 'OK') {
      directionsDisplay.setDirections(result);
      distance = result.routes[0].legs[0].distance.value;
      time = result.routes[0].legs[0].duration.text;
    } 
  });
}
function ifaccept(){
  alert('PickUp Initiated');
        window.location.reload();
}
function ifdecline(){
  alert('Pickup Declined');
  window.location.reload();
}
    </script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASEvncDVzSDP-to6DndDucKuaqvGFPmF4&libraries=places&callback=getLocation"
      async
      defer
    ></script>

    
    <!--*End of JavaScript-->
  </body>
</html>
