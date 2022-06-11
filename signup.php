<?php include 'includes/connection.php';?>
<?php include 'includes/header.php';?>
<?php include 'includes/navbar.php';?>

<?php
if (isset($_POST['signup'])) {
require "gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 

$gump->validation_rules(array(
  'username'    => 'required|alpha_numeric|max_len,20|min_len,4',
  'name'        => 'required|alpha_space|max_len,30|min_len,5',
  'email'       => 'required|valid_email',
  'password'    => 'required|max_len,50|min_len,6',
));
$gump->filter_rules(array(
  'username' => 'trim|sanitize_string',
  'name'     => 'trim|sanitize_string',
  'password' => 'trim',
  'email'    => 'trim|sanitize_email',
  ));
$validated_data = $gump->run($_POST);

if($validated_data === false) {
  ?>
  <center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
  <?php
}
else if ($_POST['password'] !== $_POST['repassword']) 
{
  echo  "<center><font color='red'>Passwords do not match </font></center>";
}
else {
      $username = $validated_data['username'];
      $checkusername = "SELECT * FROM users WHERE username = '$username'";
      $run_check = mysqli_query($conn , $checkusername) or die(mysqli_error($conn));
      $countusername = mysqli_num_rows($run_check); 
      if ($countusername > 0 ) {
    echo  "<center><font color='red'>Username is already taken! try a different one</font></center>";
}
$email = $validated_data['email'];
$checkemail = "SELECT * FROM users WHERE email = '$email'";
      $run_check = mysqli_query($conn , $checkemail) or die(mysqli_error($conn));
      $countemail = mysqli_num_rows($run_check); 
      if ($countemail > 0 ) {
    echo  "<center><font color='red'>Email is already taken! try a different one</font></center>";
}

  else {
      $name = $validated_data['name'];
      $email = $validated_data['email'];
      $pass = $validated_data['password'];
      $password = password_hash("$pass" , PASSWORD_DEFAULT);
      $role = $_POST['role'];
      $course = $_POST['course'];
      $gender = $_POST['gender'];
      $joindate = date("F j, Y");
      $query = "INSERT INTO users(username,name,email,password,role,course,gender,joindate,token) VALUES ('$username' , '$name' , '$email', '$password' , '$role', '$course', '$gender' , '$joindate' , '' )";
      $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
      if (mysqli_affected_rows($conn) > 0) { 
        echo "<script>alert('SUCCESSFULLY REGISTERED');
        window.location.href='login.php';</script>";
}
else {
  echo "<script>alert('Error Occured');</script>";
}
}
}
}
?>
<head>
    <script src="./app.js"></script>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<br>

<div class="wrapper">
     <header>SignUp Form</header>
        <form id="contactform" method="POST"> 
                 <div class="field name">
                   <div class="input-area">
                   <input id="name" name="name" placeholder="Full Name" required="" tabindex="1" type="text" value="<?php if(isset($_POST['signup'])) { echo $_POST['name']; } ?>"> 
                     <i class="icon fas fa-user"></i>
                    </div>
                  </div>
                  <div class="field email">
                   <div class="input-area">
                   <input id="email" name="email" placeholder="Enter Email" required="" type="email" value="<?php if(isset($_POST['signup'])) { echo $_POST['email']; } ?>"> 
                     <i class="icon fas fa-envelope"></i>
                    </div>
                  </div>
                  <div class="field username">
                   <div class="input-area">
                     <input id="username" name="username" placeholder="Enter Username" required="" tabindex="2" type="text" value="<?php if(isset($_POST['signup'])) { echo $_POST['username']; } ?>"> 
                     <i class="icon fas fa-user-check"></i>
                    </div>
                  </div>
                  <div class="field password">
                   <div class="input-area">
                     <input type="password" placeholder="Enter Password" id="password" name="password" required=""> 
                     <i class="icon fas fa-lock"></i>
                    </div>
                  </div>
                  <div class="field repassword">
                   <div class="input-area">
                     <input type="password" placeholder="Re-enter Password" id="repassword" name="repassword" required="">  
                     <i class="icon fas fa-key"></i>
                    </div>
                  </div>
                  <div class="field gender">
                    <div class="input-area">
                      <select class="select-style gender" name="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                    </div>
                  </div>
                  <div class="field whour">
                    <div class="input-area">
                      <select class="select-style whour" name="role">
                       <option value="teacher">Teacher</option>
                       <option value="student">Student</option>
                      </select>
                    </div>
                  </div>
                  <div class="field department">
                    <div class="input-area">
                       <select class="select-style department" name="course">
                           <option value="Computer Science">Computer Sc Engineering</option>
                           <option value="Electrical">Electrical Engineering</option>
                           <option value="Mechanical">Mechanical Engineering</option>
                        </select>
                    </div>
                  </div>
                  <input type="submit" name="signup" class="login login-submit" value="Sign Up">
   </form>     
</div>

</body>
</html>