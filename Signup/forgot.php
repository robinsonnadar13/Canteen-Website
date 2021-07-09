<?php
require_once "pdo.php";
$email = $_POST["email"];
$failure = false;
$comment = false;

if ( isset($_POST['back'] ) ) {
    header('Location: login.php');
    return;
}

if ( isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['repeatpass']) ) {
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $failure = "Email must have an at-sign (@)";
    }
    elseif ( strlen($_POST['pass']) < 5 ) {
        $failure = "Use at least 6 characters for password.";
    } 
    elseif ( strlen($_POST['repeatpass']) < 5 ) {
        $failure = "Use at least 6 characters for password.";
    } 
    elseif ( strlen($_POST['pass']) !== strlen($_POST['repeatpass'])) {
        $failure = "Password's don't match.";
    } 
    else{

        $salt = "dhjl@bxjkns238njknwqs".$_POST['password'];
    $hashed = hash('md5',$salt);

            $sql = "SELECT name FROM signupdata
            WHERE email = :em ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
            ':em' => $_POST['email']));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row === false) {
              $failure = "Invalid email address.";
              error_log("Unsuccess password change attempt.".$_POST['email']);
            }
            else {
                $sql = "UPDATE signupdata
                SET password = :pw
                WHERE email = :em";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                ':pw' => $hashed,
                ':em' => $_POST['email']));

                $comment = "Password successfully changed.";
                error_log("Password changed successfully. ".$_POST['email']);
            }

            
}
}
?>


<html>
<head>
  <title>Forgot Password</title>
  <link rel="stylesheet" href="font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="demo4.css">
  <link rel = "icon" href = "../Images/logo2.png" type = "image/x-icon"> 
</head>
<body>


  <div class="overlay">
  <form method="post">
   <!--   con = Container  for items in the form-->
   <div class="con">
   <header class="head-form">

    <button name="back" class="backs">Go Back</button>
  
      <h2>Reset Password</h2>
      <p>Enter the registered email address</p>
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

      <!--   user name -->
         <span class="input-item">
           <i class="fa fa-user-circle"></i>
         </span>
        <!--   user name Input-->
         <input class="form-input1" id="mm" type="text" placeholder="Email" name="email" >
         
     
      <br>
      <!--   user name -->
         <span class="input-item">
           <i class="fa fa-user-circle"></i>
         </span>
        <!--   user name Input-->
         <input class="form-input1" id="mm" type="text" placeholder="New Password" name="pass" >
      <br>
      <!--   user name -->
         <span class="input-item">
           <i class="fa fa-user-circle"></i>
         </span>
        <!--   user name Input-->
         <input class="form-input1"  class="mm" type="text" placeholder="Repeat Password" name="repeatpass" >
<!--        buttons -->
<!--      button LogIn -->
      <button class="btn submits sign-up" name="login"> Continue </button>
   </div>
  
<!--   End Conrainer  -->
  </div>
  
  <!-- End Form -->
</form>
</div>
<script src="js/demo4.js"></script>
</body>
</html>