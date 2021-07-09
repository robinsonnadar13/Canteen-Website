<?php 
    session_start();
    error_reporting(0);
    require_once "Signup/pdo.php";
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

    include 'Dbconnect.php';      
        if(isset($_POST['itemid'])){
            $itemid = $_POST['itemid'];
            $itemname = $_POST['itemname'];
            $itemprice = $_POST['itemprice'];
            $itemimage = $_POST['itemimage'];
            $itemcode = $_POST['itemcode'];
            $itemqty = 1;

            $stmt = $conn->prepare("SELECT item_code FROM cart WHERE item_code=?");
            $stmt->bind_param("s",$itemcode);
            $stmt->execute();
            $res = $stmt->get_result();
            $r = $res->fetch_assoc();
            $code=isset($r['item_code']) ? strlen($r['item_code']):0;
                if(!$code){
                    $query = $conn->prepare("INSERT INTO cart (id,item_name,item_price,item_image,item_qty,total_price,item_code) VALUES (?,?,?,?,?,?,?)");
                    $query->bind_param("isisiis",$itemid,$itemname,$itemprice,$itemimage,$itemqty,$itemprice,$itemcode);
                    $query->execute();
                                                                    
                echo'<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Item added to your cart!</strong> 
                    </div>';
                }
                else{
                    echo'<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Item already added to your cart!</strong> 
                </div>';
                }
        }
        if(isset($_GET['cartItem']) && isset($_GET['cartItem'])=='cart_item'){
            $stmt = $conn->prepare("SELECT * FROM cart");
            $stmt->execute();
            $stmt->store_result();
            $rows = $stmt->num_rows;
            echo $rows;
        }
        if(isset($_GET['remove'])){
            $id = $_GET['remove'];
            $stmt= $conn->prepare("DELETE FROM cart WHERE id=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();

            $_SESSION['showAlert'] = 'block';
            $_SESSION['message'] = 'Item removed from the cart!';
            header('location:cartpage.php');
        }
        if(isset($_GET['clear'])){
            $stmt = $conn->prepare("DELETE FROM cart");
            $stmt->execute();

            $_SESSION['showAlert'] = 'block';
            $_SESSION['message'] = 'Your cart is empty!';        
            header('location:cartpage.php');
        }
        if(isset($_POST['itemqty'])){
            $itemqty = $_POST['itemqty'];
            $itemid = $_POST['itemid'];
            $itemprice= $_POST['itemprice'];
            $totalprice = $itemqty*$itemprice;
            
            $stmt = $conn->prepare("UPDATE cart SET item_qty= ?, total_price= ?  WHERE id=?");
            $stmt->bind_param("iii",$itemqty,$totalprice,$itemid); 
            $stmt->execute();
        }
        ///////////////////////ADDITION///////////////////
        if(isset($_POST['action']) && isset($_POST['action'])=='order'){

        

            if (($row['wallet_balance']) >= $_POST['grand_total']){

            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $items = $_POST['items'];
            $grand_total = $_POST['grand_total'];
            $rollno = $_POST['rollno'];
            $pmode = $_POST['pmode'];

            $new_balance = (($row['wallet_balance']) - ($_POST['grand_total']));
            
            $data = '';
            $stmt = $conn->prepare("INSERT INTO orders(name,email,rollno,phone,pmode,items,amount_paid) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("ssisssi",$row['name'],$row['email'],$row['rollno'],$phone,$pmode,$items,$grand_total);             
            $stmt->execute();
            $data .= '<div class="text-center">
                        <h2 class="text-success"> Order placed Successfully!</h2>
                        <h4>#Name : '.$row['name'].'</h4>
                        <h4>#RollNo : '.$row['rollno'].'</h4>
                        <h4>#Phone : '.$phone.'</h4>
                        <h4>Total Amount Paid : '.number_format($grand_total,2).'</h4>
                        <h4>Payment Mode : '.$pmode.'</h4>
                        <h4 class="bg-danger text-light rounded p-2">Items Purchased : '.$items.'</h4>
                    </div>';

            echo $data;

            $query = $conn->prepare("TRUNCATE TABLE cart");
            $query->execute();

        $stmt = $conn->prepare("UPDATE signupdata SET wallet_balance = ? WHERE rollno = ?");
        $stmt->bind_param("ii",$new_balance,$row['rollno']); 
        $stmt->execute();

        }
    
    else{

        $phone = $_POST['phone'];
        $pmode = $_POST['pmode'];
        $items = $_POST['items'];

        $data .= '<div class="text-center">
                        <h2 class="alert alert-danger alert-dismissible">Insufficient balance!!</h2>
                        <h4>#Name : '.$row['name'].'</h4>
                        <h4>#RollNo : '.$row['rollno'].'</h4>
                        <h4>#Phone : '.$phone.'</h4>
                        <h4>Total Amount Paid : '.number_format($grand_total,2).'</h4>
                        <h4>Payment Mode : '.$pmode.'</h4>
                        <h4 class="bg-danger text-light rounded p-2">Items Purchased : '.$items.'</h4>
                    </div>';

            echo $data;
        
       
       }
}
    

?>
