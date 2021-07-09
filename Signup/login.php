<?php
error_reporting(0);
require_once "pdo.php";
$email = $_POST["email"];
$failure = false;
$comment = false;

if ( isset($_POST['signup'] ) ) {
    // Redirect the browser to game.php
    header('Location: signup.php');
    return;
}


if ( isset($_POST['forgotpa'] ) ) {

    header('Location: forgot.php');
    return;
}

if ( isset($_POST['rollno']) && isset($_POST['password']) ) {

    $salt = "dhjl@bxjkns238njknwqs".$_POST['password'];
    $hashed = hash('md5',$salt);
    
    if( !is_numeric($_POST['rollno']) || strlen($_POST['rollno']) !== 6) {
        $failure = "Roll number should be numeric";
    }
    elseif ( strlen($_POST['password']) < 5 ) {
        $failure = "Use at least 6 characters for password.";
    } 
    else{
            $sql = "SELECT name FROM signupdata
            WHERE rollno = :em AND password = :pw";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
            ':em' => $_POST['rollno'],
            ':pw' => $hashed));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row === false) {
              $failure = "Invalid login credentials.";
              error_log("Login unsuccess ".$_POST['rollno']);
            }
            else {
                $comment = "Login Successful";
                session_start();
                $_SESSION['rollno'] = $_POST['rollno'];
                header("Location: ../home.php?rollno=".urlencode($_POST['rollno']));
                error_log("Login success ".$_POST['rollno']);
            }

            
}
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="demo4.css">
  <link rel="stylesheet" href="font-awesome.min.css">
  <link rel = "icon" href = "../Images/logo2.png" type = "image/x-icon"> 
</head>
<body>
    <div class="overlay">

   <form method="post">
   <!--   con = Container  for items in the form-->
   <div class="con">
   <header class="head-form">
      <h2>Log In</h2>
      <p>login here using your roll no and password</p>
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
         <input class="form-input" id="txt-input" type="number" placeholder="Roll number" name="rollno" >
     
      <br>
     
           <!--   Password -->
     
      <span class="input-item">
      <i class="fa fa-key"></i>
      </span>
      <input class="form-input" type="password" placeholder="Password" id="pwd"  name="password">
     
<!--      Show/hide password  -->
     <span>
        <i class="fa fa-eye" aria-hidden="true"  type="button" id="eye"></i>
     </span>
     
     
      <br>
<!--        buttons -->
<!--      button LogIn -->
      <button class="log-in" name="login"> Log In </button>
   </div>
  
<!--   other buttons -->
   <div class="other">
<!--      Forgot Password button-->
      <button class="btn submits frgt-pass" name="forgotpa">Forgot Password</button>
<!--     Sign Up button -->
      <button class="btn submits sign-up" name="signup">Sign Up 
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

