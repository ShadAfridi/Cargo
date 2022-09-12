<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="signup.css" />
    <link rel="shortcut icon" href="images/truck_icon.ico" />
    <title>Sign Up</title>
  </head>
  <body>
    <header>
      <h1><a href="#">Cargo</a></h1>
      <h2><a href="http://127.0.0.1/cargo/login.php">Log In</a></h2>
    </header>
    <div class="login-box"></div>
    <form action="#" method="POST">
      <input
        type="text"
        name="name"
        class="Name"
        id="userName"
        onblur="checkEmpty()"
        placeholder="Full Name"
        spellcheck="false"
        ondblclick="this.select()"
      />
      <input
        type="text"
        name="email"
        class="Email"
        id="Email"
        onblur="checkEmpty()"
        placeholder="E-Mail"
        spellcheck="false"
        ondblclick="this.select()"
      />
      <input
        type="password"
        name="password"
        class="Password"
        id="password"
        placeholder="Password"
        spellcheck="false"
        ondblclick="this.select()"
      />
      <img
        src="images/eye.png"
        alt="eye"
        class="eye"
        id="Eye"
        role="button"
        onclick="show_pass(id,'password')"
      />
      <input
        type="password"
        name="confirm-password"
        class="conf-Password"
        id="confirm-password"
        placeholder="Confirm Password"
        spellcheck="false"
        ondblclick="this.select()"
      />
      <img
        src="images/eye.png"
        alt="eye2"
        class="eye2"
        id="Eye2"
        role="button"
        onclick="show_pass(id,'confirm-password')"
      />
      <button type="submit" class="sign-up">Sign Up</button>
    </form>
    <script>
      function show_pass(id, pss) {
        var x = document.getElementById(pss);

        if (x.type === 'password') {
          x.type = 'text';
          document.getElementById(id).src = 'images/hide_eye.png';
          if (id == 'Eye') document.getElementById(id).style.top = '310px';
          else document.getElementById(id).style.top = '380px';
        } else {
          x.type = 'password';
          document.getElementById(id).src = 'images/eye.png';
          if (id == 'Eye') document.getElementById(id).style.top = '317px';
          else document.getElementById(id).style.top = '387px';
        }
      }
    </script>
    <?php
      $userName=$email=$userPassword="";
      
      if($_SERVER["REQUEST_METHOD"]=="POST"){
        if( isset($_POST["name"]) and isset($_POST["email"]) and isset($_POST["password"]) and isset($_POST["confirm-password"])){
           if($_POST["password"]===($_POST["confirm-password"])){
              $userName=$_POST["name"];
              $email=$_POST["email"];
              $userPassword=$_POST["password"];

                      
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
            $sql = "INSERT INTO userBase (userName,email,userPassword)
            VALUES ('$userName', '$email','$userPassword')";
            $conn->query($sql);
            

            $conn->close();
            header('Location:http://127.0.0.1/cargo/login.php');
           }
          }
      }
    ?>
  </body>
</html>
