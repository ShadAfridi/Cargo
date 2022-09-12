<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="login_style.css" />
    <link rel="shortcut icon" href="images/truck_icon.ico" />
    <title>Login</title>
  </head>
  <body>
    <header>
      <h1><a href="#">Cargo</a></h1>
      <h2><a href="http://127.0.0.1/cargo/SignUp.php">Sign Up</a></h2>
    </header>
    <div class="login-box"></div>
    <form action="#" method="POST">
      <input
        type="text"
        name="email"
        class="User-Id"
        id="userID"
        placeholder="E-mail"
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
        onclick="show_pass()"
      />
      <button type="submit" class="log-in">Log In</button>
    </form>
    <script>
      function show_pass() {
        var x = document.getElementById('password');

        if (x.type === 'password') {
          x.type = 'text';
          document.getElementById('Eye').src = 'images/hide_eye.png';
          document.getElementById('Eye').style.top = '259.3px';
        } else {
          x.type = 'password';
          document.getElementById('Eye').src = 'images/eye.png';
          document.getElementById('Eye').style.top = '267px';
        }
      }
    </script>
    
    <?php
      $email=$userPassword= $results="";
      
      if($_SERVER["REQUEST_METHOD"]=="POST"){
        if( isset($_POST["email"]) and isset($_POST["password"]) ){
              $email=$_POST["email"];
              $userPassword=$_POST["password"];

                      
              $servername = "localhost";
              $username = "root";
              $password = "";
              $dbName = "cargo";
            // Create connection
            $conn = new mysqli($servername, $username, $password,$dbName);
            $sql = "select * from userBase";
            $results=$conn->query($sql);
            if ($results->num_rows > 0) {
              // output data of each row
             
              while($row = $results->fetch_assoc()) {
               
               if($row["email"]===$email and $row["userPassword"]===$userPassword) {
                
            
                header('Location:http://127.0.0.1/cargo/create.php');
                $conn->close();
               }   
                
                 
              }
           }
           $conn->close();
      }
    }
    ?>
  </body>
</html>
