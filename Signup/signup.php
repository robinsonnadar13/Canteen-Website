<?php
require_once "pdo.php";
error_reporting(0);
$email = $_POST["email"];
$failure = false; 
$comment = false;
$valrollno=$_GET['rollno'];
if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to cancel
    header('Location: ../home.php');
    return;
}

if ( isset($_POST['login'] ) ) {
    header('Location: login.php');
    return;
}

try {

    if ( isset($_POST['name']) && isset($_POST['rollno']) && isset($_POST['email']) 
&& isset($_POST['password'])) {

    $salt = "dhjl@bxjkns238njknwqs".$_POST['password'];
    $hashed = hash('md5',$salt);

    if ( strlen($_POST['name']) < 1 ) {
        $failure = "Name is required";
    } 
    elseif ( !is_numeric($_POST['rollno']) || strlen($_POST['rollno']) !== 6) {
        $failure = "Roll number should be numeric";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $failure = "Email must have an at-sign (@)";
    }
    elseif ( strlen($_POST['password']) < 5 ) {
        $failure = "Use at least 6 characters for password.";
    } 
    else{
          $sql = "INSERT INTO signupdata (name, rollno, email, password)
          VALUES (:name, :rollno, :email, :password)";
          $stmt = $pdo->prepare($sql);
          $stmt->execute(array(
          ':name' => $_POST['name'],
          ':rollno' => $_POST['rollno'],
          ':email' => $_POST['email'],
          ':password' => $hashed));
          $comment = "Successfully registered.";    
    }

  }
}
catch (\PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        $failure = "Roll number already registered.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  <link rel="stylesheet" type="text/css" href="demo4.css">
  <link rel="stylesheet" href="font-awesome.min.css">
  <link rel = "icon" href = "../Images/logo2.png" type = "image/x-icon"> 
</head>
<body>
    <div class="overlay">

   <form method="post">
   <!--   con = Container  for items in the form-->
   <div class="con">
   <!--     Start  header Content  -->
   <header class="head-form">
      <h2>Sign Up</h2>
      <!--     A welcome message or an explanation of the login form -->
      <p>signup here using your roll number</p>
   </header>
   <!--     End  header Content  -->
   <br>

   <div class="field-set">
         <?php

         if ( $failure !== false ) {
             echo('<p style="color: red; text-align:centre;">'.htmlentities($failure)."</p>\n");
         }

         if ( $comment !== false ) {
             echo('<p style="color: green; text-align:centre;">'.htmlentities($comment)."</p>\n");
         }

         ?>
         <span class="input-item">
           <i class="fa fa-user-circle"></i>
         </span>
         <input class="form-input" id="txt-input" name ="name" type="text" placeholder="Name" >
      <br>

          <span class="input-item">
          <i class="fa fa-user-circle"></i>
          </span>
          <input class="form-input" id="txt-input" name = "rollno" type="number" placeholder="Roll No.">
          <br>

          <span class="input-item">
          <i class="fa fa-user-circle"></i>
          </span>
          <input class="form-input" id="txt-input" name ="email" type="text" placeholder="Email">
          <br>
     
          <span class="input-item">
          <i class="fa fa-key"></i>
          </span>
          <input class="form-input" type="password" placeholder="Password" id="pwd"  name="password">
          <span >
          <i class="fa fa-eye" aria-hidden="true" type="button" id="eye"></i>
          </span>
</span>
     
      <br>
<!--        buttons -->
<!--      button LogIn -->
      <button class="signup"> Sign Up </button>
   </div>
  
<!--   other buttons -->
   <div class="other">
<!--      Forgot Password button-->
      <button class="btn submits frgt-pass" name="cancel">Cancel</button>
<!--     Sign Up button -->
      <button class="btn submits sign-up" name="login">Login 
<!--         Sign Up font icon -->
      </button>
<!--      End Other the Division -->
   </div>
     
<!--   End Conrainer  -->
  </div>
  
  <!-- End Form -->
</form>
</div>
<script src="js/demo4.js"></script>
</body>
</html>

