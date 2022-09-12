//global variables
var userlat1;
var userlat2;
var userlng1;
var userlng2;
var gmarkers = [];
var gcircles = [];
var directionsDisplay;
var directionsService;
var distance;
var time;
var cost;
var default_marker;
var default_circle;

function PopulateInput() {
  document.getElementById('PickUpLat').setAttribute('value', userlat1);
  document.getElementById('PickUpLng').setAttribute('value', userlng1);
  document.getElementById('DestLat').setAttribute('value', userlat2);
  document.getElementById('DestLng').setAttribute('value', userlng2);
  document.getElementById('pickup').setAttribute('value', 'User Location');
}

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

function addClass() {
  var input = document.getElementById('input');
  input.classList.add('input-container-changed');
  input = document.getElementById('pickup');
  input.classList.add('pickup-changed');
  input = document.getElementById('arrows');
  input.classList.add('arrows-changed');
  input = document.getElementById('destination');
  input.classList.add('destination-changed');
  input = document.getElementById('show-time');
  input.classList.add('show-time');
  input = document.getElementById('span-time');
  input.innerHTML = `${time}`;
  input = document.getElementById('show-cost');
  input.classList.add('show-cost');
  input = document.getElementById('span-cost');
  if (distance < 10000) {
    input.innerHTML = `₹ 20`;
  } else {
    cost = 0.0025 * distance;
    cost = Math.round(cost);
    input.innerHTML = `₹ ${cost}`;
  }
  input = document.getElementById('button');
  input.classList.add('show-button');
  PopulateInput();
}

//refresh
function checkEmpty() {
  if (document.getElementById('pickup').value.length == 0) {
    window.location.reload();
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
  addMarker({ coords: { lat: userlat, lng: userlng }, iconImage: 'images/man_pickup.png' }, map);

  //Autocomplete
  var input = document.getElementById('pickup');
  var autocomplete = new google.maps.places.Autocomplete(input);
  var input2 = document.getElementById('destination');
  var autocomplete2 = new google.maps.places.Autocomplete(input2);

  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    var place = autocomplete.getPlace();
    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();
    document.getElementById('pickup').addEventListener('change', initMap(lat, lng, map));
  });

  google.maps.event.addListener(autocomplete2, 'place_changed', function() {
    var place = autocomplete2.getPlace();
    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();
    document.getElementById('destination').addEventListener('change', initMap2(lat, lng, map));
  });
}

//Pickup Functions
function initMap(lat, lng, map) {
  userlat1 = lat;
  userlng1 = lng;
  var map1 = map;
  if (default_marker.position.lat() != userlat2) {
    default_marker.setMap(null);
  }
  if (gmarkers[0]) {
    gmarkers[0].setMap(null);
    gcircles[0].setMap(null);
  }

  map1.panTo({ lat: userlat1, lng: userlng1 });
  addMarker({ coords: { lat: userlat1, lng: userlng1 }, iconImage: 'images/man_pickup.png' }, map);
  calculateRoute(map1);
}
//Destination Functions
function initMap2(lat, lng, map) {
  userlat2 = lat;
  userlng2 = lng;
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
    if (document.getElementById('destination').value == document.getElementById('pickup').value) {
      alert('Destination And Pickup Cannot Be Same');
      window.location.reload();
    }

    if (status == 'OK') {
      directionsDisplay.setDirections(result);
      distance = result.routes[0].legs[0].distance.value;
      time = result.routes[0].legs[0].duration.text;
      addClass();
    } else {
      if (document.getElementById('destination').value != 0) {
        alert('No Valid Route Found');
        window.location.reload();
      }
    }
  });
}
