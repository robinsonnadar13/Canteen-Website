<?php

//start session
session_start();

//include "..\php\CreateDb.php";

//create instance of CreateDb class
// error_reporting(0);


require_once "./Signup/pdo.php";
session_start();
$rollno = $_SESSION['rollno'];

if (  isset($_SESSION["rollno"] )) {
$sql = "SELECT * FROM signupdata WHERE rollno = $rollno";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
            ':nm' => $_POST['name'],
            ':rn' => $_POST['rollno'],
            ':em' => $_POST['email'],
            ':pw' => $_POST['password']));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
}


?>

<!DOCTYPE html>
<html>
<head>

  <title>FCRIT CANTEEN</title>
     <meta name="viewport" content="width=device-width,initial-scale=1">
         
         <link rel="stylesheet" type="text/css" href="style.css">
    
         <link rel = "icon" href = "Images/logo2.png" type = "image/x-icon">    

         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>   

        <link rel="stylesheet" href="styles.css" />
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
         <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
                 <script src="store.js" async></script>

         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
         <script src="https://kit.fontawesome.com/ebfafc2eb8.js" crossorigin="anonymous"></script>
         <script type="text/javascript" src="search.js"></script> 

         <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" ></script>
         <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>



          <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



  </head>
<body style="background-color: white;">


<!-- ####################NAVBAR############# -->
<header id="header">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="nav-btn">
    <label for="nav-check">
      <span></span>
    </label>
  </div>
  <a class="navbar-brand" href="home.php"><i class="fas fa-utensils"></i>&nbsp; Fcrit Cafeteria <i class="fas fa-utensils-alt"></i> </a>
        <button class="navbar-toggler" type="button"
                data-target = "#collapsibleNavbar">
                <span class="navbar-toggler-icon "></span>
        </button>
   
  
  <?php
error_reporting(0);
  if (  isset($_SESSION["rollno"] )){

  echo'<div class="nav-link" style="margin-right: 50%;">';
  
  echo'<li class="nav-item" >
                <a class="nav-link nav-link active" href="cartpage.php" style="align-self: right"> Cart&nbsp;<i class="fas fa-shopping-cart"></i>
                <span id="cart-item" class="badge badge-danger"></span>
                </a></li>'; 
      
      if(isset($_SESSION['cart'])){
        $count=count($_SESSION['cart']);
        echo "<span>$count</span>";
      }
      else{
        echo "<span></span>";
      }

  echo'</a>';
  echo'</div>';

  }

  else{
        echo'<div class="nav-links" style="margin-right: 60%;">';
        
        echo'</div>';
  }
    ?>

      
      <?php
  
  if ( ! isset($_SESSION["rollno"] )) {

  echo'<div class="nav-links">';
    echo'<a href="./Signup/login.php"><button class="btn btn-warning ">Login</button></a>';
    echo'<a href="./Signup/signup.php" target="_self" style="padding-left: 20px"><button class="btn btn-warning ">Signup</button></a>';
  echo'</div>';
  }

  else {
    //echo'<a class="navbar-brand1" style="padding: 0px; padding-top: 5px;" href="#">';
    //echo'<img src="Images/Profile.png" width=45" height="40" style="padding-top: 0px;"alt="" loading="lazy">';
    //echo'</a>';
    echo'<div class="dropdown" style="padding-top: 4px; margin-right: 10%" >';
    echo'<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="font-size: 16px;text-align: center; margin-top: 2.8px; background-color: #ffa70f;">';
    echo htmlentities($row['name']);
    echo'</button>';
    echo'<ul class="dropdown-menu">';
    echo'<li><a href="Signup/account.php" style="font-size: 16px;">My Account</a></li>';
    echo'<li><a href="Signup/logout.php" onclick="logoutnow();" style="font-size: 16px;">Logout</a></li>';
    echo'</ul>';
    
    echo'</div>';
  }

  ?>

  </div>
</nav>
</header>



<!-- ######################SEARCH BOX#####################> 


<div class="searchbox animated zoomIn">

                <form method="get">
                  
                    <input oninput="triggercross(this.value)" type="text" placeholder="search food item" id="search" name="search"
                        class="search"><i class="fas fa-search"></i>
                    <button onclick="close1()" id="closeid" type="reset" class="close">
                        <i class="fas fa-times"></i>
                        <p id="demo"></p>
                    </button>
                </form>

</div-->


<!-- ###############carousel slide############## -->

 <section>
        <div class="slider">
          <div id="slider" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="images/slider1.png" class="d-block w-100" >
              </div>
              <div class="carousel-item">
                <img src="images/slider2.png" class="d-block w-100" style="width: 100%;">
              </div>
              <div class="carousel-item">
                <img src="images/slider4.png" class="d-block w-100" style="width: 100%;">
              </div>
              <div class="carousel-item">
                <img src="images/slider3.png" class="d-block w-100" style="width: 100%;">
              </div>
              <ol class="carousel-indicators">
                <li data-target="#slider" data-slide-to="0" class="active"></li>
                <li data-target="#slider" data-slide-to="1"></li>
                <li data-target="#slider" data-slide-to="2">
                <li data-target="#slider" data-slide-to="2"></li>
                </li>
              </ol>
            </div>
            <a class="carousel-control-prev" href="#slider" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#slider" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
              </div> 
        </div>
    </section>
    

<!-- ################MENU CARD################### -->

  <section class="menu">
    <h1 class="title">Menu</h1>

    <div class="TabsContainer">
      <div class="ButtonContainer">
        <button onclick="showPanel(0,'#35DB29')">Veg</button>
        <button onclick="showPanel(1,'#FC1F1F')">Non-Veg</button>
        <button onclick="showPanel(2,'#25D4F3')">Beverages</button>
        <button onclick="showPanel(3,'#A83CFA')">Desserts</button>
      </div>

      <div class="TabPanel">
        <section class="container content-section">
            
                <div class="container pb-5">
  
        <div class="row mt-2 pb-3">
            <?php
                        include 'Dbconnect.php';
                        $stmt = $conn->prepare("SELECT * FROM product");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while  ($row = $result->fetch_assoc()):
                          if($row['id']>=17&&$row['id']<=28):
                    ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                        <div class= "card-deck">
                            <div class="card p-2 border-secondary mb-2">
                                <img src="<?= $row['item_image'] ?>" class="card-img-top"
                                height="180">
                                <div class="card-body p-1">
                                    <h5 class="card-title text-center"><?= $row['item_name'] ?></h5>
                                    <h6 class="card-title text-center"><i class="fas fa-rupee-sign">&nbsp;</i><?= number_format($row['item_price'] )?>/-</h6>
                                    <div class="card-footer p-1">
                                    <form action = "home.php" class="form-submit">
                                        <input type="hidden" class="itemid" value="<?= $row['id'] ?>">
                                        <input type="hidden" class="itemname" value="<?= $row['item_name'] ?>">
                                        <input type="hidden" class="itemprice" value="<?= $row['item_price'] ?>">
                                        <input type="hidden" class="itemimage" value="<?= $row['item_image'] ?>">
                                        <input type="hidden" class="itemcode" value="<?= $row['item_code'] ?>">
                                        <button class="btn btn-info btn-block addItemBtn">Add to Cart&nbsp;<i class="fas fa-shopping-cart"></i></button>
                                    </form> 
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif;
                  endwhile; ?>
        </div>
    </div>    
                
        </section>
      </div>

      <div class="TabPanel">
        <section class="container content-section">
            
                <div class="container">
  
        <div class="row mt-2 pb-3">
            <?php
                        include 'Dbconnect.php';
                        $stmt = $conn->prepare("SELECT * FROM product");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while  ($row = $result->fetch_assoc()):
                          if($row['id']>=11&&$row['id']<=16):
                    ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                        <div class= "card-deck">
                            <div class="card p-2 border-secondary mb-2">
                                <img src="<?= $row['item_image'] ?>" class="card-img-top"
                                height="180">
                                <div class="card-body p-1">
                                    <h5 class="card-title text-center"><?= $row['item_name'] ?></h5>
                                    <h6 class="card-title text-center"><i class="fas fa-rupee-sign">&nbsp;</i><?= number_format($row['item_price'] )?>/-</h6>
                                    <div class="card-footer p-1">
                                    <form action = "home.php" class="form-submit">
                                        <input type="hidden" class="itemid" value="<?= $row['id'] ?>">
                                        <input type="hidden" class="itemname" value="<?= $row['item_name'] ?>">
                                        <input type="hidden" class="itemprice" value="<?= $row['item_price'] ?>">
                                        <input type="hidden" class="itemimage" value="<?= $row['item_image'] ?>">
                                        <input type="hidden" class="itemcode" value="<?= $row['item_code'] ?>">
                                        <button class="btn btn-info btn-block addItemBtn">Add to Cart&nbsp;<i class="fas fa-shopping-cart"></i></button>
                                    </form> 
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif;
                  endwhile; ?>
        </div>
    </div>    
                
        </section>
      </div>

      <div class="TabPanel">
        <section class="container content-section">
            
                <div class="container">
  
        <div class="row mt-2 pb-3">
            <?php
                        include 'Dbconnect.php';
                        $stmt = $conn->prepare("SELECT * FROM product");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while  ($row = $result->fetch_assoc()):
                          if($row['id']>=4&&$row['id']<=10):
                    ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                        <div class= "card-deck">
                            <div class="card p-2 border-secondary mb-2">
                                <img src="<?= $row['item_image'] ?>" class="card-img-top"
                                height="180">
                                <div class="card-body p-1">
                                    <h5 class="card-title text-center"><?= $row['item_name'] ?></h5>
                                    <h6 class="card-title text-center"><i class="fas fa-rupee-sign">&nbsp;</i><?= number_format($row['item_price'] )?>/-</h6>
                                    <div class="card-footer p-1">
                                    <form action = "home.php" class="form-submit">
                                        <input type="hidden" class="itemid" value="<?= $row['id'] ?>">
                                        <input type="hidden" class="itemname" value="<?= $row['item_name'] ?>">
                                        <input type="hidden" class="itemprice" value="<?= $row['item_price'] ?>">
                                        <input type="hidden" class="itemimage" value="<?= $row['item_image'] ?>">
                                        <input type="hidden" class="itemcode" value="<?= $row['item_code'] ?>">
                                        <button class="btn btn-info btn-block addItemBtn">Add to Cart&nbsp;<i class="fas fa-shopping-cart"></i></button>
                                    </form> 
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif;
                  endwhile; ?>
        </div>
    </div>    
        </section>
      </div>

      <div class="TabPanel">
        <section class="container content-section">
            
        
<div class="container">
  
        <div class="row mt-2 pb-3">
            <?php
                        include 'Dbconnect.php';
                        $stmt = $conn->prepare("SELECT * FROM product");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while  ($row = $result->fetch_assoc()):
                          if($row['id']>=1&&$row['id']<=3):
                    ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                        <div class= "card-deck">
                            <div class="card p-2 border-secondary mb-2">
                                <img src="<?= $row['item_image'] ?>" class="card-img-top"
                                height="180">
                                <div class="card-body p-1">
                                    <h5 class="card-title text-center"><?= $row['item_name'] ?></h5>
                                    <h6 class="card-title text-center"><i class="fas fa-rupee-sign">&nbsp;</i><?= number_format($row['item_price'] )?>/-</h6>
                                    <div class="card-footer p-1">
                                    <form action = "home.php" class="form-submit">
                                        <input type="hidden" class="itemid" value="<?= $row['id'] ?>">
                                        <input type="hidden" class="itemname" value="<?= $row['item_name'] ?>">
                                        <input type="hidden" class="itemprice" value="<?= $row['item_price'] ?>">
                                        <input type="hidden" class="itemimage" value="<?= $row['item_image'] ?>">
                                        <input type="hidden" class="itemcode" value="<?= $row['item_code'] ?>">
                                        <button class="btn btn-info btn-block addItemBtn">Add to Cart&nbsp;<i class="fas fa-shopping-cart"></i></button>
                                    </form> 
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif;
                  endwhile; ?>
        </div>
    </div>    



                
        </section>
      </div>

    </div>
    <?php
  include('includes/footer.php');
 ?>
    

   </section>

  
<link rel="stylesheet" type="text/css" href="header.css">
       
<!--script src="bootstrap/bootstrap.js"></script-->
<script >
function addtocart(){

  <?php
    if ( ! isset($_SESSION["rollno"] )){

        echo'swal("UnSuccessful!", "You need to log in!", "warning");';
    }
    else{
       
         echo'swal("Successfully!", "Added to cart!", "success");';

       
    }
  ?>
}
</script>

<script src="myScript.js">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>                     
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

 <script type="text/javascript">
   $(document).ready(function(){
            $(".addItemBtn").click(function(e){
                e.preventDefault();
                var $form = $(this).closest(".form-submit");
                var itemid = $form.find(".itemid").val();
                var itemname = $form.find(".itemname").val();
                var itemprice = $form.find(".itemprice").val();
                var itemimage = $form.find(".itemimage").val();
                var itemcode = $form.find(".itemcode").val();
            $.ajax({
                url: 'action.php',
                method: 'post',
                data: {itemid:itemid, itemname:itemname, itemprice:itemprice, itemimage:itemimage, itemcode:itemcode},
                success:function(response){
                $("#message").html(response);
                window.scrollTo(0,0);
                load_cart_item_number();  
                }
            });
        });
    });
    load_cart_item_number();
    function load_cart_item_number(){
        $.ajax({
            url: 'action.php',
                method: 'get',
                data: {cartItem:"cart_item"},
                success:function(response){
                $("#cart-item").html(response);
            }
        });
    }
</script> 

</body>
</html>