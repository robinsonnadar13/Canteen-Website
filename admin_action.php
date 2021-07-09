<?php 
    session_start();
    error_reporting(0);
    include 'Dbconnect.php';      
        if(isset($_POST['itemid'])){
            $itemid = $_POST['itemid'];
            $itemname = $_POST['itemname'];
            $itemprice = $_POST['itemprice'];
            $itemimage = $_POST['itemimage'];
            $itemcode = $_POST['itemcode'];
           
            $stmt = $conn->prepare("SELECT item_code FROM product WHERE item_code=?");
            $stmt->bind_param("s",$itemcode);
            $stmt->execute();
            $res = $stmt->get_result();
            $r = $res->fetch_assoc();
            $code=isset($r['item_code']) ? strlen($r['item_code']):0;
                if(!$code){
                    $query = $conn->prepare("INSERT INTO product (id,item_image,item_name,item_price,item_code) VALUES (?,?,?,?,?)");
                    $query->bind_param("issis",$itemid,$itemimage,$itemname,$itemprice,$itemcode);
                    $query->execute();

                                                                    
                echo'<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Item added to your menu!</strong> 
                    </div>';
                }
                else{
                    echo'<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Item already added present in your menu!</strong> 
                </div>';
                }
        }
        
        if(isset($_GET['remove'])){
            $id = $_GET['remove'];
            $stmt= $conn->prepare("DELETE FROM product WHERE id=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();

            $_SESSION['showAlert'] = 'block';
            $_SESSION['message'] = 'Item removed from menu!!';
            header('location:admin.php#posts');
        }
        


?>