<?php
 session_start();
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div style="display:<?php if(isset($_SESSION['showAlert'])){ echo $_SESSION['showAlert'];}
                else{ echo 'none';} unset($_SESSION['showAlert']); ?>"class="alert alert-success alert-dismissible mt-3">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong> <?php if(isset($_SESSION['message'])){ echo $_SESSION['message'];}unset($_SESSION['showAlert']);?></strong> 
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <td colspan="7">
                                <h4 class="text-center text m-0" style= "color:blue">Items added to your cart&nbsp;<i style="color:black" class="fa fa-cart-arrow-down"></i>
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Item name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>
                            <a href="action.php?clear=all" class="badge-danger badge p-2"
                             onclick="return confirm('Are you sure you want to clear your cart?');"> 
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'Dbconnect.php';
                        $stmt = $conn->prepare("SELECT * FROM cart");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $grand_total=0;
                        while($row=$result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <input type="hidden" class="itemid" value="<?= $row['id'] ?>">
                            <td><img src="<?=$row['item_image']?>" width="120"></td>
                            <td><b><?= $row['item_name'] ?></b></td>
                            <td><i class="fas fa-rupee-sign"></i>&nbsp;<b><?= number_format( $row['item_price'],2)?></b> </td>
                            <input type="hidden" class="itemprice" value="<?= $row['item_price'] ?>">
                            <td><input type="number" min="1" class="form-control itemQty" value="<?= $row['item_qty'] ?>" style="width:50px;"></td>
                            <td><i class="fas fa-rupee-sign"></i>&nbsp;<b><?= number_format( $row['total_price'],2)?></b></td>
                            <td><a href="action.php?remove=<?=$row['id']?>" class="text-danger lead"
                            onclick="return confirm('Are you sure you want to remove this item?');"><i class="fas fa-trash"></i></a></td>
                        </tr>
                        <?php $grand_total += $row['total_price'];?>
                        <?php endwhile; ?>
                        <tr>
                            <td colspan="3">
                                <a href="home.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;Continue Shopping</a>
                            </tb>
                            <td colspan="2"><b>Grand Total</b></td>
                            <td><b><i class="fas fa-rupee-sign"></i>&nbsp;<b><?= number_format( $grand_total,2)?></b></td>
                            <td>
                                <a href="checkout.php" class="btn btn-info <?= ($grand_total >1)?"":"disabled"; ?>"><i class="far fa-credit-card"></i>&nbsp;Checkout</a>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
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
            
   $(".itemQty").on('change',function(){
    var $elem = $(this).closest('tr');
    var itemid = $elem.find(".itemid").val();
    var itemprice = $elem.find(".itemprice").val();
    var itemqty = $elem.find(".itemQty").val();
    location.reload(true);
    $.ajax({
        url: 'action.php',
        method: 'post',
        cache: false,
        data: {itemqty:itemqty,itemid:itemid,itemprice:itemprice},
        success: function(response){
            console.log(response);
        }
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
});
  </script> 
</body>
</html>