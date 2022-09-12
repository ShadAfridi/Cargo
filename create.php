<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="parcel_style.css" />
    <link rel="shortcut icon" href="images/truck_icon.ico" />
    <title>Send Parcel</title>
  </head>
  <body>
    <!--*HTML Display-->

    <header>
      <h1><a href="#">Cargo</a></h1>
      <div>
        <ul class="menu">
          <li><a href="#">Join</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">My Orders</a></li>
          <li><a href="#">Shad</a></li>
        </ul>
      </div>
    </header>
    <img src="images/bg_curve.svg" class="bg" alt="curve" />

    <!--*Enter Pickup Location-->

    <div class="input-container" id="input"></div>
    <form method="POST">
      <input
        type="text"
        class="pickup"
        id="pickup"
        onblur="checkEmpty()"
        placeholder=" 📍 Current Location "
        spellcheck="false"
        ondblclick="this.select()"
		name="pickup"
      />
      <input
        type="text"
        class="destination"
        id="destination"
        placeholder="Enter Drop Location"
        spellcheck="false"
        ondblclick="this.select()"
		name="destination"
      />
      <input name="PickUpLat" id="PickUpLat" style="display:none;"/>
      <input name="PickUpLng" id="PickUpLng" style="display:none;"/>
      <input name="DestLat" id="DestLat" style="display:none;"/>
      <input name="DestLng" id="DestLng" style="display:none;"/>
      <h3 class="hide-time" id="show-time">
        Delivery Time <br />
        <span id="span-time"></span>
      </h3>
      <h4 class="hide-cost" id="show-cost">
        Delivery Cost <br />
        <span id="span-cost"></span>
      </h4>
      <button type="submit" class="hide-button" id="button" >Cargo It !</button>
    </form>
    <img src="images/Arrows.png" alt="arrows" class="arrows" id="arrows" />

    <!--*Map Display-->

    <div id="map"></div>

    <!--*Start of JavaScript-->
    <script
    src="parcel.js">
    </script>
     
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASEvncDVzSDP-to6DndDucKuaqvGFPmF4&libraries=places&callback=getLocation"
      async
      defer
    ></script>
<?php
	// define variables and set to empty values
	$pickupErr = $destinationErr = "";
  $pickup = $destination = "";
  $PickUpLat=$PickUpLng=$DestLat=$DestLng=$dbName="";
  
    
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["pickup"])and isset($_POST["destination"]))
      $pickup=$_POST["pickup"];
      $destination=$_POST["destination"];
      $PickUpLat=$_POST["PickUpLat"];
      $PickUpLng=$_POST["PickUpLng"];
      $DestLat=$_POST["DestLat"];
      $DestLng=$_POST["DestLng"];
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
	  $sql = "INSERT INTO cargo (PickUpAdd,DestAdd,PickUpLat,PickUpLng,DestLat,DestLng)
    VALUES ('$pickup', '$destination',$PickUpLat,$PickUpLng,$DestLat,$DestLng)";
    $conn->query($sql);

	
		$conn->close();
	  
  }
	
?>
    <!--*End of JavaScript-->
  </body>
</html>
