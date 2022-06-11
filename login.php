<?php include 'includes/connection.php';?>
<?php include 'includes/header.php';?>
<?php include 'includes/navbar.php';?>

<?php
session_start();
if (isset($_POST['login'])) {
  $username  = $_POST['user'];
  $password = $_POST['pass'];
  mysqli_real_escape_string($conn, $username);
  mysqli_real_escape_string($conn, $password);
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn , $query) or die (mysqli_error($conn));
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_array($result)) {
    $id = $row['id'];
    $user = $row['username'];
    $pass = $row['password'];
    $name = $row['name'];
    $email = $row['email'];
    $role= $row['role'];
    $course = $row['course'];
    if (password_verify($password, $pass )) {
      $_SESSION['id'] = $id;
      $_SESSION['username'] = $username;
      $_SESSION['name'] = $name;
      $_SESSION['email']  = $email;
      $_SESSION['role'] = $role;
      $_SESSION['course'] = $course;
      header('location: dashboard/');
    }
    else {
      echo "<script>alert('invalid username/password');
      window.location.href= 'login.php';</script>";

    }
  }
}
else {
      echo "<script>alert('invalid username/password');
      window.location.href= 'login.php';</script>";

    }
}
?>
<head>
    <script src="./app.js"></script>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body>
          <div class="wrapper">
              <header>LogIn Form</header>
              <form method="POST">
                 <div class="field email">
                   <div class="input-area">
                     <input type="text" name="user" placeholder="Username" required="">
                     <i class="icon fas fa-envelope"></i>
                     <i class="error error-icon fas fa-exclamation-circle"></i>
                    </div>
                  </div>
                  <div class="field email">
                    <div class="input-area">
                      <input type="password" name="pass" placeholder="Password" required="">
                      <i class="icon fas fa-lock"></i>
                      <i class="error error-icon fas fa-exclamation-circle"></i>
                    </div>
                  </div>
                  <input type="submit" name="login" class="login login-submit" value="login">
               </form>
    
              <div class="login-help">
                <a href="signup.php">Register</a> • <a href="recoverpassword.php">Forgot Password</a>
              </div>
           </div>

  <script src='css/jquery.min.js'></script>
  <script src='css/jquery-ui.min.js'></script>

  
</body>
</html>
