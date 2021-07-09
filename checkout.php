

<?php
    require 'Dbconnect.php';
    require_once "./Signup/pdo.php";
    error_reporting(0);
    session_start();
    $rollno = $_SESSION['rollno'];
    //echo $rollno;
    
    $sql = "SELECT * FROM signupdata WHERE rollno = $rollno";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
            ':nm' => $_POST['name'],
            ':rn' => $_POST['rollno'],
            ':em' => $_POST['email'],
            ':pw' => $_POST['password']));
    $ro = $stmt->fetch(PDO::FETCH_ASSOC);
    //echo htmlentities($ro['name']);


    
    $grand_total= 0;
    $allItems = '';
    $items = array();

    $sql="SELECT CONCAT (item_name, '(',item_qty,')') AS ItemQty,
        total_price FROM cart";
    $stmt =  $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        $grand_total += $row['total_price'];
        $items[] =$row['ItemQty'];
    }
   $allItems = implode(",", $items);


   
   

   ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel = "icon" href = "Images/logo2.png" type = "image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha512-xA6Hp6oezhjd6LiLZynuukm80f8BoZ3OpcEYaqKoCV3HKQDrYjDE1Gu8ocxgxoXmwmSzM4iqPvCsOkQNiu41GA==" crossorigin="anonymous" />
</head>
<body>
    <!------------------------ NAV BAR ----------------------->
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="home.php"><i class="fas fa-utensils"></i>&nbsp; Fcrit Cafeteria <i class="fas fa-utensils-alt"></i> </a>
        <button class="navbar-toggler" type="button"
                data-target = "#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                <a class="nav-link active" href="home.php">Menu</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="Signup/account.php">Profile</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="checkout.php">Checkout</a>
                </li>
                <li class="nav-item">
                <a class="nav-link nav-link active" href="cartpage.php"> Cart <i class="fas fa-shopping-cart"></i>
                <span id="cart-item" class="badge badge-danger"></span>
                </a></li>
            </ul>
        </div>
    </nav>
<!------------------------ MENU ----------------------->    
    <section class="menu">
        

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 px-4 pb-4" id="order">
                    <h4 class="text-center text-info p-2">Complete your order!</h4>
                        <div class="jumbotron p-3 mb-2 text-center">
                            <h6 class="lead"><b>Item(s) : </b><?=$allItems;?></h6>
                            <h5><b>Total Amount Payable:</b>&nbsp;<?= number_format($grand_total,2)?>/-</h5>
                        </div>
                        <form action="" method="post" id="placeOrder">
                        <input type="hidden" name="items" value="<?=$allItems;?>">   
                        <input type="hidden" name="grand_total" value="<?=$grand_total;?>">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" value="<?=($ro['name']);?>" disabled="disabled" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" value="<?=($ro['email']);?>" disabled="disabled" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="rollno" class="form-control" value="<?=($ro['rollno']);?>" disabled="disabled" required>
                        </div>
                        <div class="form-group">
                            <input type="number" name="phone" class="form-control"
                            placeholder="Enter Phone" required>
                        </div>
                        <h6 class="text-center lead">Select Payment Mode</h6>
                        <div class="form-group">
                         <select name="pmode" class="form-control">
                            <option value="" selected disabled>-Select Payment Mode-</option>
                            <option value="cash counter">Cash Counter</option>
                            <option value="e-wallet">E-wallet</option>
                         </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
  include('includes/footer.php');
 ?>
    </section>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>                     
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

 <script type="text/javascript">
   $(document).ready(function(){
    $("#placeOrder").submit(function(e){
        e.preventDefault();
        $.ajax({
            url:'action.php',
            method:'post',
            data: $('form').serialize()+"&action=order",
            success: function(response){
                $("#order").html(response);
            }
        });
    });

    
   });
</script> 
 </body>
 </html>