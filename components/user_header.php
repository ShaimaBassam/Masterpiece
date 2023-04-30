<?php

include './components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_SESSION['cart'])){
   
} else {
   $_SESSION['cart'] = [];
}

if(isset($_SESSION['fav'])){
   
} else {
   $_SESSION['fav'] = [];
}

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['addTOcart'])){
   $product_id = $_POST['product_id'];
   $product_name = $_POST['name'];
   $product_price = $_POST['price'];
   $product_image = $_POST['image'];
   $product_quantity = $_POST['quantity'];

   $check_product_id = $conn->prepare("SELECT product_id FROM `cart` WHERE user_id = '$user_id'");
   $check_product_id->execute();
   

   $flag = true;

   while($fetch_product = $check_product_id->fetch(PDO::FETCH_ASSOC)){
      if (in_array($product_id, $fetch_product)){
         $flag = false;
         break;
      }
   };
   if($flag==true){
      if($user_id > 0){
      $send_to_cart = $conn->prepare("INSERT INTO `cart` (user_id , product_id , name , price , image , quantity)
                                    VALUES (? , ? , ? , ?, ? , ?)"); 
      $send_to_cart->execute([$user_id , $product_id , $product_name , $product_price, $product_image, $product_quantity]);

   }else {
      $array_cart = [$product_id , $product_name , $product_price, $product_image, $product_quantity];
      array_push($_SESSION['cart'], $array_cart);
      // echo'<pre>';
      // print_r($_SESSION['cart']);
      // echo'</pre>';
   }
}
}







if(isset($_POST['add_to_wishlist'])){

   if($user_id == ''){

      $flag = true;
      $pid = $_POST['product_id'];

      foreach($_SESSION['fav'] as $id){
         if (in_array($pid,$id)){
            $flag = false;
            break;
         }
      };
      if($flag==true){
         $array_fav = [$pid];
         array_push($_SESSION['fav'], $array_fav);
         // echo'<pre>';
         // print_r($_SESSION['fav']);
         // echo'</pre>';
      }

   }else{

      $pid = $_POST['product_id'];


      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `favorite` WHERE product_id = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$pid, $user_id]);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE product_id = ? AND user_id = ?");
      $check_cart_numbers->execute([$pid, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $message[] = 'Your Product <span style="color:red">Already</span> Added To Wishlist!';
      }elseif($check_cart_numbers->rowCount() > 0){
         $message[] = 'Your Product <span style="color:red">Already</span> Added To Cart!';
      }else{
         $insert_wishlist = $conn->prepare("INSERT INTO `favorite`(user_id, product_id) VALUES(?,?)");
         $insert_wishlist->execute([$user_id, $pid]);
         $message[] = 'Your Product <span style="color:green">Added</span> To Wishlist!';
      }

   }

}
?>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message" style="background-color:silver !important;">
            <span style="color: black !important; font-weight:bold"> Notice : '.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>


li.dropdown {
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {background-color: #f1f1f1;}

.dropdown:hover .dropdown-content {
  display: block;
}
</style>
<body>
<div class="header-top mobile-hide">
                <div class="container">
                    <div class="wrapper flexitem">
                        <div class="left">
                            <ul class="flexitem main-links">
                                <!-- <li><a href="#"></a>Wishlist</li>
                                <li><a href="#"></a>Order Tracking</li> -->
                            </ul>
                        </div>
                        <div class="right">
                            <ul class="flexitem main-links">
                                <!-- <li><a href="#"></a>Sign Up</li>
                                <li><a href="#"></a>My Account</li>
                                <li><a href="#">English</a></li>
                                <li><a href="#">JOD</a></li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header-top  -->
            <div class="header-nav">
                <div class="container">
                    <div class="wrapper flexitem">
                        <a href="#" class="trigger desktop-hide"><span class="i ri-menu-2-line"></span></a>
                        <div class="left flexitem">
                        
                            <div class="logo"><img src="./assets/logo.png" alt=""></a></div>

                            <nav class="mobile-hide">
                                <ul class="flexitem second-links">
                                    <li><a href="./home.php">Home</a></li>
                                    <li><a href="./shop.php">Shop</a></li>
                                    <li class="has-child">
                                        <a href="#">Women
                                            <div class="icon-small"></div>
                                        </a>
                                        
                                        <!-- mega menu -->
                                        <!-- <div class="mega">
                                            <div class="container">
                                                <div class="wrapper">
                                                    <div class="flexcol">
                                                        <div class="row">
                                                            <ul>
                                                                <h4>Women's Clothing</h4>
                                                                <li><a href="#">Top</a></li>
                                                                <li><a href="#">Prayer Clothes</a></li>
                                                                <li><a href="#">Dresses</a></li>
                                                                <li><a href="#">Pants</a></li>
                                                                <li><a href="#">Pajamas & Robes</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="flexcol">
                                                        <div class="row">
                                                            <ul>
                                                                <h4>Jewelry</h4>
                                                                <li><a href="#">Accessories</a></li>
                                                                <li><a href="#">Bags & Purses</a></li>
                                                                <li><a href="#">Necklaces</a></li>
                                                                <li><a href="#">Rings</a></li>
                                                                <li><a href="#">Bracelets</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="flexcol">
                                                        <div class="row">
                                                            <ul>
                                                                <h4>Beauty</h4>
                                                                <li><a href="#">Skin Care</a></li>
                                                                <li><a href="#">Hair Care</a></li>
                                                                <li><a href="#">Makeup & Cosmetics</a></li>
                                                                <li><a href="#">Face Masks</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="flexcol">
                                                        <div class="row">
                                                            <ul class="women-stores">
                                                                <h4>Women Stores</h4>
                                                                <li><a href="#">Hills</a></li>
                                                                <li><a href="#">Nai</a></li>
                                                                <a href="./page-category.html" class="view-all">View All Stores<i class="ri-arrow-right-line"></i></a>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <div class="flexcol products">
                                                        <div class="row">
                                                            <div class="media">
                                                                <div class="thumbnail object-cover">
                                                                    <a href="#">
                                                                        <img src="assets/products/p6.png"
                                                                            alt="">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="text-content">
                                                                <h4>Most Wanted!</h4>
                                                                <a href="./page-offer.html" class="primary-button">Order Now </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li> -->
                                    <!-- the end of mega menu -->
                                    <li><a href="#">Men
                                            <div class="fly-item">
                                                <span>New!</span>
                                            </div>
                                        </a>
                                    </li>
                                    
                                </ul>
                            </nav>

                        </div>
                        <div class="right">
                            <ul class="flexitem second-links">
                            <?php
                             $count_wishlist_items = $conn->prepare("SELECT * FROM `favorite` WHERE user_id = ?");
                             $count_wishlist_items->execute([$user_id]);
                             $total_wishlist_counts = $count_wishlist_items->rowCount();

                             $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                             $count_cart_items->execute([$user_id]);
                             $total_cart_counts = $count_cart_items->rowCount();
                             ?>
                                    <li class="dropdown mobile-hide">
                                     <a href="javascript:void(0)" class="dropbtn"> <div class="icon-large"><i class="ri-user-3-line"></i></div></a>
                                     <div class="dropdown-content">
                                     <?php          
                                    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE user_id = ?");
                                    $select_profile->execute([$user_id]);
                                    if($select_profile->rowCount() > 0){
                                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                                     ?>
                                    <a ><?= $fetch_profile["name"]; ?></a>
                                     <a href="./account.php">Account</a>
                                     <a href="./logout.php">Logout</a>

                                     <?php
                                     }else{
                                      ?>
                                     <a>please login or register first!</a>
                                     <a href="./login.php">Login</a>
                                     <a href="./register.php">Register</a>

                                     <?php
                                     }
                                    ?>  
                                     </div>
                                    </li>

                                <li class="mobile-hide"><a href="#">
                                        <div class="icon-large"><i class="ri-heart-line"></i></div>
                                        <?php
                                         if(isset($_SESSION['user_id'])){ ?>
                                        <div class="fly-item"><span class="item-number"><?= $total_wishlist_counts; ?></span></div>
                                    </a>
                                </li>

                                

                                <li class="iscart"><a href="#">
                                    <div class="icon-large">
                                        <i class="ri-shopping-cart-line"></i>
                                        <div class="fly-item"><span class="item-number"> <?= $total_cart_counts; ?></span></div>
                                    </div>
                                    <?php
                                        }else{ ?>
                                    <div class="fly-item"><span class="item-number"><?= count($_SESSION['fav']); ?></span></div>
                                    </a>
                                </li>

                                

                                <li class="iscart"><a href="#">
                                    <div class="icon-large">
                                        <i class="ri-shopping-cart-line"></i>
                                        <div class="fly-item"><span class="item-number"> <?= count($_SESSION['cart']); ?></span></div>
                                    </div>


                                     <?php }; ?>
                                    <div class="icon-text">
                                        <div class="mini-text">Total</div>
                                        <div class="cart-total">95.38 JD</div>
                                    </div>
                                </a>
                                <div class="mini-cart">
                                    <div class="content">
                                    <?php
                                        if(isset($_SESSION['user_id'])){ ?>
                                        <div class="cart-head">
                                        <?= $total_cart_counts; ?> items in cart
                                        </div>

                                       <?php }else{ ?>
                                        <div class="cart-head">
                                        <?= count($_SESSION['cart']); ?>items in cart
                                        </div>
                                        <?php }; ?>

                                        <div class="cart-body">
                                            <ul class="products mini">
                                                <li class="item">
                                                    <div class="thumbnail object-cover">
                                                        <a href="#"><img src="assets/products/QUARTZ VEIL LIQUID EYESHADOW.png" alt=""></a>
                                                    </div>
                                                    <div class="item-content">
                                                        <p><a href="#">QUARTZ VEIL LIQUID EYESHADOW</a></p>
                                                        <span class="price">
                                                            <span>9.55 JD</span>
                                                            <span class="fly-item"><span>2x</span></span>
                                                        </span>
                                                    </div>
                                                    <a href="" class="item-remove"><i class="ri-close-line"></i></a>
                                                </li>
                                                <li class="item">
                                                    <div class="thumbnail object-cover">
                                                        <a href="#"><img src="assets/products/BEADED SHOULDER BAG.png" alt=""></a>
                                                    </div>
                                                    <div class="item-content">
                                                        <p><a href="#">BEADED SHOULDER BAG</a></p>
                                                        <span class="price">
                                                            <span>25.99 JD</span>
                                                            <span class="fly-item"><span>2x</span></span>
                                                        </span>
                                                    </div>
                                                    <a href="" class="item-remove"><i class="ri-close-line"></i></a>
                                                </li>
                                                <li class="item">
                                                    <div class="thumbnail object-cover">
                                                        <a href="#"><img src="assets/products/EYE SHADOW PALETTE.png" alt=""></a>
                                                    </div>
                                                    <div class="item-content">
                                                        <p><a href="#">EYE SHADOW PALETTE</a></p>
                                                        <span class="price">
                                                            <span>9.55 JD</span>
                                                            <span class="fly-item"><span>2x</span></span>
                                                        </span>
                                                    </div>
                                                    <a href="" class="item-remove"><i class="ri-close-line"></i></a>
                                                </li>
                                                <li class="item">
                                                    <div class="thumbnail object-cover">
                                                        <a href="#"><img src="assets/products/EYEBROW PENCIL.png" alt=""></a>
                                                    </div>
                                                    <div class="item-content">
                                                        <p><a href="#">EYEBROW PENCIL</a></p>
                                                        <span class="price">
                                                            <span>5.20 JD</span>
                                                            <span class="fly-item"><span>1x</span></span>
                                                        </span>
                                                    </div>
                                                    <a href="" class="item-remove"><i class="ri-close-line"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="cart-footer">
                                            <div class="subtotal">
                                                <p>Subtotal</p>
                                                <p><strong>95.38 JD</strong></p>
                                            </div>
                                            <div class="actions">
                                                <a href="./checkout.php" class="secondary-button">Checkout</a>
                                                <a href="./cart.php" class="secondary-button">View Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
</body>
</html>