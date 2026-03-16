<?php
require "db.php";

if(isset($_POST['insert'])){
  $mail = htmlspecialchars($_POST['mail']);
  $phone = htmlspecialchars($_POST['phone']);
  $pass= $_POST['pass'];
  $role = "user";
  $time_var = date('y-m-d');

  $insert = $conn->prepare("INSERT INTO users (mail, phone,pass, role, date) 
  VALUES(?,?,?,?,?)");
  $insert->bind_param('sssss', $mail, $phone,$pass,$role, $time_var);
  
  if($insert->execute()){
    $error= 'Unmatch Email<br>and password ';
  }
}
if(isset($error)) {
  echo "<div class='errorp'>".$error."</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>net Hunter-free internet</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time();?>">
  <style>
    .no{
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Net Hunter-free internet</h1>
      <p>Unlimited free internet access for everyone</p>
    </div>
    <div class="form-section">
      <h2>Get Free 5GB Internet Now</h2>
      <form id="signupForm" action="" method="post">
        <div class="input-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" placeholder="Enter your email" name="mail" required>
          <div class="error-message" id="emailError"></div>
        </div>

        <div class="input-group">
          <label for="phone">Phone Number</label>
          <input type="text" id="phone" placeholder="Enter your phone number" name="phone" required>
          <div class="error-message" id="phoneError"></div>
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" placeholder="Create a password" name="pass" minlength="6"required>
          <div class="error-message" id="passwordError"></div>
        </div>

        <button type="submit" name="insert">Create Free Account</button>
      </form>
    </div>
    <div class="features">
      <div class="feature">
        <div style="font-size:30px;">⚡</div>
        <h3>High Speed 10mb/s</h3>
        <p>Enjoy blazing fast speeds with no bandwidth limits</p>
      </div>
      <div class="feature">
        <div style="font-size:30px;">🌍</div>
       <a href="log.php" class="no"><h3>Global Access</h3></a> 
        <p>Access content from anywhere in the world, Including Africa Country like Keniya, Ethiopia, Uganda, Tanzania, Kenya, Nigeria, Ghana, etc..</p>
      </div>
    </div>

    <footer>
      © 2025 NetHunter. All rights reserved.
    </footer>
  </div>
  </div>
  <script src="script.js?v=<?php echo filemtime('script.js'); ?>"></script>
</body>
</html>
