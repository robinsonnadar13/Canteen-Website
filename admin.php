<?php
session_start();






?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="index.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	 <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha512-xA6Hp6oezhjd6LiLZynuukm80f8BoZ3OpcEYaqKoCV3HKQDrYjDE1Gu8ocxgxoXmwmSzM4iqPvCsOkQNiu41GA==" crossorigin="anonymous" />
  <script type="text/javascript" href="index.js"></script>
</head>
<body>

<section class="main page">

	<div class="admin-panel clearfix">
  		<div class="slidebar">

  			<div class="logo">
			      <img src="Images/logo.jpeg" width="220" height="145">
			 </div>

  		<div>
    		<ul>
		      <li><a href="#dashboard" id="targeted"  >Dashboard</a></li>
		      <li><a href="#menu">View All Items</a></li>
		      <li><a href="#users">User Details</a></li>
		      <li><a href="#comments">Order History</a></li>
		      <li><a href="#settings">Recharge</a></li>
		    </ul>
  		</div>

  	</div>
  	<div class="main">
    <div class="mainContent clearfix">
     	 <div id="dashboard" >
        	<img src="Images/admin.png" >
        </div>
     <div id="menu" >
        	<div class="container">
        <div class="row justify-content-center pl-5">
            <div class="col-lg">
                <!--div style="display:<?php if(isset($_SESSION['showAlert'])){ echo $_SESSION['showAlert'];}
                else{ echo 'none';} unset($_SESSION['showAlert']); ?>"class="alert alert-success alert-dismissible mt-3">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong> <?php if(isset($_SESSION['message'])){ echo $_SESSION['message'];}unset($_SESSION['showAlert']);?></strong> 
                </div-->
                <div class="table-responsive mt-2">
                    <table class="table  table-striped text-center">
                    <thead>
                        <tr>
                            <td colspan="7">
                                <h4 class="text-center text m-0" style= "color:blue">Items present in your menu&nbsp;<i style="color:black" class="fa fa-cart-arrow-down"></i>
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Item name</th>
                            <th>Price</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'Dbconnect.php';
                        $stmt = $conn->prepare("SELECT * FROM menu");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $grand_total=0;
                        while($row=$result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <input type="hidden" class="itemid" value="<?= $row['id'] ?>">
                            <td><img src="<?=$row['item_image']?>" class="img-fluid" width="80"></td>
                            <td><b><?= $row['item_name'] ?></b></td>
                            <td><i class="fas fa-rupee-sign"></i>&nbsp;<b><?= number_format( $row['item_price'],2)?></b> </td>
                            <input type="hidden" class="itemprice" value="<?= $row['item_price'] ?>">
                            <td><a href="admin_action.php?remove=<?=$row['id']?>" class="text-danger lead"
                            onclick="return confirm('Remove this item from menu?'); " ><button class="btn btn-warning ">Remove</button></a></td>
                            <td>
                            	<form action = "admin.php" class="form-submit">
                                        <input type="hidden" class="itemid" value="<?= $row['id'] ?>">
                                        <input type="hidden" class="itemname" value="<?= $row['item_name'] ?>">
                                        <input type="hidden" class="itemprice" value="<?= $row['item_price'] ?>">
                                        <input type="hidden" class="itemimage" value="<?= $row['item_image'] ?>">
                                        <input type="hidden" class="itemcode" value="<?= $row['item_code'] ?>">
                                        <button class="btn btn-info btn-block addItemBtn">Add</i></button>
                                </form> 
                            </td>
                            <td>
                            	<?php
                            	?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
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
                                url: 'admin_action.php',
                                method: 'post',
                                data: {itemid:itemid, itemname:itemname, itemprice:itemprice, itemimage:itemimage, itemcode:itemcode},
                                success:function(response){
                                $("#message").html(response);
                                }
                            });
                        });
                    });
                </script> 

      </div>

        	 
     
     <div id="users" >
        	
            <div class="container">
        <div class="row justify-content-center pl-5">
            <div class="col-lg">
                <!--div style="display:<?php if(isset($_SESSION['showAlert'])){ echo $_SESSION['showAlert'];}
                else{ echo 'none';} unset($_SESSION['showAlert']); ?>"class="alert alert-success alert-dismissible mt-3">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong> <?php if(isset($_SESSION['message'])){ echo $_SESSION['message'];}unset($_SESSION['showAlert']);?></strong> 
                </div-->
                <div class="table-responsive mt-2">
                    <table class="table  table-striped text-center">
                    <thead>
                        <tr>
                            <td colspan="7">
                                <h4 class="text-center text m-0" style= "color:blue">User Details&nbsp;<i style="color:black" class="fa fa-user-circle"></i>
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Roll number</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th >Wallet Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'Dbconnect.php';
                        require "Signup/pdo.php";
                        $stmt = $conn->prepare("SELECT * FROM signupdata");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $grand_total=0;
                        while($row=$result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <input type="hidden" class="itemid" value="<?= $row['name'] ?>">
                            <td><?= $row['rollno'] ?></td>
                            <input type="hidden" class="itemname" value="<?= $row['rollno'] ?>">
                            <td><?= $row['email'] ?></td>
                            <input type="hidden" class="itemid" value="<?= $row['email'] ?>">
                            <td><?= $row['password'] ?></td>
                            <input type="hidden" class="itemid" value="<?= $row['password'] ?>">
                            <td>
                            <td><?= $row['wallet_balance'] ?></td>
                            <input type="hidden" class="itemid" value="<?= $row['wallet_balance'] ?>">
                            <td>
                                <form action = "admin.php" class="form-submit">
                                        <input type="hidden" class="itemid" value="<?= $row['name'] ?>">
                                        <input type="hidden" class="itemname" value="<?= $row['rollno'] ?>">
                                        <input type="hidden" class="itemprice" value="<?= $row['email'] ?>">
                                        <input type="hidden" class="itemimage" value="<?= $row['password'] ?>">
                                        <input type="hidden" class="itemcode" value="<?= $row['wallet_balance'] ?>">
                                </form> 
                            </td>
                            <td>
                                <?php
                                ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
     </div>
    <div id="comments" >
        	
            <div class="container">
        <div class="row justify-content-center pl-5">
            <div class="col-lg">
                <!--div style="display:<?php if(isset($_SESSION['showAlert'])){ echo $_SESSION['showAlert'];}
                else{ echo 'none';} unset($_SESSION['showAlert']); ?>"class="alert alert-success alert-dismissible mt-3">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong> <?php if(isset($_SESSION['message'])){ echo $_SESSION['message'];}unset($_SESSION['showAlert']);?></strong> 
                </div-->
                <div class="table-responsive mt-2">
                    <table class="table  table-striped text-center">
                    <thead>
                        <tr>
                            <td colspan="7">
                                <h4 class="text-center text m-0" style= "color:blue">Orders Received&nbsp;<i style="color:black" class="fa fa-cart-arrow-down"></i>
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Roll number</th>
                            <th>Phone number</th>
                            <th>Payment mode</th>
                            <th>Items</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'Dbconnect.php';
                        $stmt = $conn->prepare("SELECT name,rollno,phone,pmode,items,amount_paid FROM orders");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $grand_total=0;
                        while($row=$result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <input type="hidden" class="itemid" value="<?= $row['name'] ?>">
                            <td><?= $row['rollno'] ?></td>
                            <input type="hidden" class="itemname" value="<?= $row['rollno'] ?>">
                            <td><?= $row['phone'] ?></td>
                            <input type="hidden" class="itemid" value="<?= $row['phone'] ?>">
                            <td><?= $row['pmode'] ?></td>
                            <input type="hidden" class="itemid" value="<?= $row['pmode'] ?>">
                            <td><?= $row['items'] ?></td>
                            <input type="hidden" class="itemid" value="<?= $row['items'] ?>">
                            <td><i class="fas fa-rupee-sign"></i>&nbsp;<b><?= number_format( $row['amount_paid'],2)?></b> </td>
                            <input type="hidden" class="itemprice" value="<?= $row['amount_paid'] ?>">
                            <!--<td><a href="admin_action.php?remove=<?=$row['id']?>" class="text-danger lead"
                            onclick="return confirm('Remove this item from menu?');" ><button class="btn btn-warning ">Disperse</button></a></td>
                            <td>-->
                                <form action = "admin.php" class="form-submit">
                                        <input type="hidden" class="itemid" value="<?= $row['id'] ?>">
                                        <input type="hidden" class="itemname" value="<?= $row['item_name'] ?>">
                                        <input type="hidden" class="itemprice" value="<?= $row['item_price'] ?>">
                                        <input type="hidden" class="itemimage" value="<?= $row['item_image'] ?>">
                                        <input type="hidden" class="itemcode" value="<?= $row['item_code'] ?>">
                                </form> 
                            </td>
                            <td>
                                <?php
                                ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        
                    </tbody>
                    </table>
                </div>
            </div>
        </div>

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
                                url: 'admin_action.php',
                                method: 'post',
                                data: {itemid:itemid, itemname:itemname, itemprice:itemprice, itemimage:itemimage, itemcode:itemcode},
                                success:function(response){
                                $("#message").html(response);
                                }
                            });
                        });
                    });
                </script> 
            </div>
        
        </div>
    
       <div id="settings" >
        	<div id="rech">
         <h2 class="header">User Information</h2>
           <div class="quick-press">
          
           <form  action="admin.php"  method="post" id="balance">
            <!--div class="form-group">
             <input type="text" class="namer" class="form-control" placeholder="name"/></div-->
            <div class="form-group">
             <input type="text" name="rollnor" class="form-control" placeholder="rollno"/></div>
             <div class="form-group">
             <input type="text"  name="amount" class="form-control" placeholder="amount"/></div>
             <div class="form-group">
                <input type="submit" name="submit" value="Recharge" class="btn btn-danger btn-block">
            </div>
           </form>
         </div>
         <?php
         require "Signup/pdo.php";
         error_reporting(0);

         if (isset($_POST['submit']) && isset($_POST['amount'])){

            
            $rollnor = $_POST['rollnor'];

            $sql = "SELECT * FROM signupdata WHERE rollno = $rollnor";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                ':nm' => $_POST['name'],
                ':rn' => $_POST['rollno'],
                ':em' => $_POST['email'],
                ':wb' => $_POST['wallet_balance'],
                ':pw' => $_POST['password']));
            $ro = $stmt->fetch(PDO::FETCH_ASSOC);

            $amount = $_POST['amount'];
            $new_recharge = $ro['wallet_balance'] + $amount;
            echo'<script>console.log("1")</script>';
            
            
            $stmt = $conn->prepare("UPDATE signupdata SET wallet_balance = ? WHERE rollno = ? ");
            $stmt->bind_param("ii",$new_recharge,$rollnor); 
            $stmt->execute();
            
            header("Location: admin.php#recharge");
            }?>
         
       </div>
        
    	

</div>
</div>
</section>


</body>


</html>