
<?php

include './components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['order'])){

   $chose_name = $conn->prepare("SELECT * 
                                 FROM cart 
                                 INNER JOIN users WHERE cart.user_id = users.user_id");
   $chose_name->execute();
   $fetch_name_user = $chose_name->fetch(PDO::FETCH_ASSOC);

   $name = $fetch_name_user['name'];
   $number = $fetch_name_user['mobile'];
   $email = $fetch_name_user['email'];

   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .','. $_POST['country'];
   $total_quantity = $_POST['quantity'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, location, total_quantity, total_price, order_time, mobile) VALUES(?,?,?,?,?,?)");
      date_default_timezone_set("Asia/Amman");
      $date_of_order = date("Y:m:d h:i:sa"); 
      $insert_order->execute([$user_id, $address, $total_quantity, $total_price, $date_of_order, $number]);

      $select_order_to_add = $conn->prepare("SELECT * FROM `orders`ORDER BY order_id DESC LIMIT 1;");
      $select_order_to_add->execute();
      if($select_order_to_add->rowCount()>0){
         while($fetch_order_to_details = $select_order_to_add->fetch(PDO::FETCH_ASSOC)){
            $order_id = $fetch_order_to_details['order_id']; } }
      
      $add_product_id_to_order_details = $conn->prepare("SELECT * FROM `cart` WHERE user_id='$user_id'");
      $add_product_id_to_order_details->execute();

      while ($fetch_to_take_product_id = $add_product_id_to_order_details->fetch(PDO::FETCH_ASSOC)){
         $product_id_in_cart = $fetch_to_take_product_id['product_id'];
         $product_quantity = $fetch_to_take_product_id['quantity'];
         $product_price = $fetch_to_take_product_id['price'];
         $insert_order_details = $conn->prepare("INSERT INTO `order_details`(order_id, product_id, quantity, price) VALUES(?,?,?,?)");
         $insert_order_details->execute([$order_id, $product_id_in_cart, $product_quantity, $product_price]);
      }


      while($fetch_cart_to_update = $check_cart->fetch(PDO::FETCH_ASSOC)){
         $id = $fetch_cart_to_update['product_id'];
         $update_products_after_sell = $conn->prepare("SELECT sold FROM `products` WHERE product_id = '$id' ");
         $update_products_after_sell->execute();
         $fetch_product_to_update_store = $update_products_after_sell->fetch(PDO::FETCH_ASSOC);
         $sold_item = (int)$fetch_product_to_update_store['sold'] + 1;
         $update_sold_product = $conn->prepare("UPDATE `products` SET sold ='$sold_item' WHERE product_id = '$id' ");
         $update_sold_product->execute();
      }


      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Center Point</title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
    <link rel="icon" type="image/x-icon" href="./assets/logo.png">

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

.shipping-methods {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.inputBox {
  width: calc(50% - 10px);
  margin-bottom: 20px;
}

.inputBox span {
  display: block;
  margin-bottom: 5px;
}

.box {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

.box:focus {
  outline: none;
  border-color: #666;
}
</style>
<body>
    <div id="page" class="site page-checkout">
        <aside class="site-off desktop-hide">
            <div class="off-canvas">
                <div class="canvas-head flexitem">
                    <div class="logo"><img src="./assets/logo.png" alt=""></a></div>
                      <a href="" class="t-close flexcenter"><i class="ri-close-line"></i></a>
                </div>
                <div class="departments"></div>
                <nav></nav>
                <div class="thetop-nav"></div>
            </div>
        </aside>
        <!-- first nav bar -->
        <header>
        <div class="header-top mobile-hide">
                <div class="container">
                    <div class="wrapper flexitem">
                        <div class="left">
                            <ul class="flexitem main-links">
                                
                            </ul>
                        </div>
                        <div class="right">
                            <ul class="flexitem main-links">
                                
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
                                        <a href="./about.php">About Us
                                            <div class="icon-small"></div>
                                        </a>
                                       
                                    <li><a href="./contact.php">Contact
                                            <!-- <div class="fly-item">
                                                <span>New!</span>
                                            </div> -->
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

                                <li class="mobile-hide"><a href="./whishlist.php">
                                        <div class="icon-large"><i class="ri-heart-line"></i></div>
                                        <?php
                                         if(isset($_SESSION['user_id'])){ ?>
                                        <div class="fly-item"><span class="item-number"><?= $total_wishlist_counts; ?></span></div>
                                    </a>
                                </li>

                                

                                <li class="iscart"><a href="./cart.php">
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
                                                        <a href=""><img src="assets/products/QUARTZ VEIL LIQUID EYESHADOW.png" alt=""></a>
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
            <!-- second nav bar -->
            <div class="header-main mobile-hide">
                <div class="container">
                    <div class="wrapper flexitem">
                        <div class="left">
                            <div class="dpt-cat">
                                <div class="dpt-head">
                                      <div class="main-text">All Departments</div>
                                    <?php
                                    // prepare SQL query to count total number of products
$sql = "SELECT COUNT(*) as total FROM products";
// execute query
$stmt = $conn->prepare($sql);
$stmt->execute();
?>

                                    <div class="mini-text mobile-hide">
                                        <?php
                                    // output total number of products
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_products = $row["total"];
    echo "Total $total_products Products<br>";
} else {
    echo "No products found.";
}
?>
                                    </div>
                                    <a href="#" class="dpt-trigger mobile-hide">
                                        <i class="ri-menu-3-line ri-xl"></i>
                                    </a>
                                </div>
                                <div class="dpt-menu">
                                    <ul class="second-links">
                                        <li class="has-child Womens">
                                            <a href="category.php?category=1">
                                                <div class="icon-large"><i class="ri-t-shirt-line"></i></div>
                                                Women's Fashion
                                            </a>
                                        </li>
                                        <li class="has-child Mens">
                                            <a href="category.php?category=2">
                                                <div class="icon-large"><i class="ri-shirt-line"></i></div>
                                                Men's Fashion
                                            </a>
                                        </li>
                                        <li class="has-child Girls">
                                            <a href="category.php?category=3">
                                                <div class="icon-large"><i class="ri-user-5-line"></i></div>
                                                Girl's Fashion
                                            </a>
                                        </li>
                                        <li class="has-child Boys">
                                            <a href="category.php?category=4">
                                                <div class="icon-large"><i class="ri-user-6-line"></i></div>
                                                Boy's Fashion
                                            </a>
                                        </li>
                                        <li class="has-child Home">
                                            <a href="category.php?category=5">
                                                <div class="icon-large"><i class="ri-home-4-line"></i></div>
                                                Home & Kitchen
                                            </a>
                                        </li>
                                        <li class="has-child Brokers">
                                            <a href="category.php?category=6">
                                                <div class="icon-large"><i class="ri-stack-line"></i></div>
                                                Products From Brokers
                                            </a>
                                        </li>
                                       
                                    </ul>
                                </div>
                            </div>
                        </div>
                        

                        <div class="right">
  <div class="search-box">
    <form class="search" method="get" action="search.php">
      <span class="icon-large"><i class="ri-search-line"></i></span>
      <input type="search" name="query" placeholder="Search for products" value="<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>">
      <button type="submit">Search</button>
    </form>
    <?php
    if (isset($_GET['query'])) {
      $query = $_GET['query'];

      $sql = "SELECT * FROM products WHERE name LIKE '%".$query."%' OR description LIKE '%".$query."%'";
      $result = $conn->query($sql);
      
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<a href='./search.php?pid=".$row['product_id']."'>".$row['name']."</a><br>";
        }
      } else {
        echo "No results found.";
      }
    }
    ?>
  </div>
</div>

                    </div>
                </div>
            </div>
        </header>
         <!-- header  -->
         <main>
   <div class="single-checkout">
      <div class="container">
         <div class="wrapper">
            <div class="checkout flexwrap">
               <div class="item left styled">
                  <form action="" method="POST">
                     <div class="shipping-methods">
                        <div class="inputBox">
                           <span>payment method :</span>
                           <select name="method" class="box" required>
                              <option value="cash on delivery" selected>cash on delivery</option>
                           </select>
                        </div>
                        <div class="inputBox">
                           <span>Flat number :</span>
                           <input type="text" name="flat" placeholder="e.g. flat number" class="box" maxlength="50" required>
                        </div>
                        <div class="inputBox">
                           <span>Street name :</span>
                           <input type="text" name="street" placeholder="e.g. street name" class="box" maxlength="50" required>
                        </div>
                        <div class="inputBox">
                           <span>City :</span>
                           <input type="text" name="city" placeholder="e.g. mumbai" class="box" maxlength="50" required>
                        </div>
                        <div class="inputBox">
                           <span>Country :</span>
                           <input type="text" name="country" placeholder="e.g. India" class="box" maxlength="50" required>
                        </div>
                     </div>
               </div>
               <div class="item right">
                  <h2>Order Summary</h2>
                  <div class="summary-order is_sticky">
                     <?php
                        $total_quantity=0;
                        $total_price = 0;
                        $cart_items[] = '';
                        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                        $select_cart->execute([$user_id]);
                        if($select_cart->rowCount() > 0){
                           while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                              $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
                              $total_products = implode($cart_items);
                              $total_price += ($fetch_cart['price'] * $fetch_cart['quantity']);
                              $total_quantity += $fetch_cart['quantity'];
                     ?>
                     <p> <?= $fetch_cart['name']; ?> <span>(<?= 'JD'.$fetch_cart['price'].' x '. $fetch_cart['quantity']; ?>)</span> </p>
                     <?php
                        }
                     }else{
                        echo '<p class="empty">your cart is empty!</p>';
                     }
                     ?>
                     <input type="hidden" name="total_products" value="<?= $total_products; ?>">
                     <input type="hidden" name="total_price" value="<?= $total_price; ?>" value="">
                     <div class="grand-total">Total Price : <span>JD<?= $total_price; ?></span></div>
                     <div class="primary-checkout" style="margin-top:50px;">
                        <input type="hidden" name="quantity" value="<?= $total_quantity ?>">
                         <input  type="submit" name="order" href="./home.php" class="primary-button" <?= ($total_price > 1)?'':'disabled'; ?> value="place order" style="border:none;">
                     </div>
                  </form>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</main>
    <footer>


        <div class="footer-info" style="background-color: var(--light-bg-color);">
            <div class="container" >
                <div class="wrapper" >
                    <div class="flexcol" >
                        <div class="logo" >
                            <img src="./assets/logo.png" style="height: 150px;width:150px;margin-left:29px">
                           
                        </div>
                        <div class="socials" >
                            <ul class="flexitem" >
                                <!-- <li><a href="#"><i class="ri-twitter-line"></i></a></li> -->
                                <li><a href="https://www.facebook.com/" target="_blank" style="background-color: var(--primary-color)!important;color:white;"><i class="ri-facebook-line" style="color:wihte;"></i></a></li>
                                <li><a href="https://www.instagram.com/" target="_blank" style="background-color: var(--primary-color)!important;color:white;"><i class="ri-instagram-line"></i></a></li>
                                <li><a href="https://www.linkedin.com/" target="_blank" style="background-color: var(--primary-color)!important;color:white;"><i class="ri-linkedin-line"></i></a></li>
                                <li><a href="https://www.youtube.com/" target="_blank" style="background-color: var(--primary-color)!important;color:white;"><i class="ri-youtube-line"></i></a></li>
                            </ul>
                        </div>

                        <div style="color:black; justify-content: space-between; display: flex;gap: 20px; margin-left:50px">
                                <!-- <li><a href="#"><i class="ri-twitter-line"></i></a></li> -->
                                <p><a href="./shop.php" style="color:var(--secondary-dark-color);">Shop</a></p>
                                <p><a href="./account.php" style="color:var(--secondary-dark-color);">Account</a></p>
                                <p><a href="./whishlist.php" style="color:var(--secondary-dark-color);">Whishlist</a></p>
                                <p><a href="./cart.php" style="color:var(--secondary-dark-color);">Cart</a></p>
                                <p><a href="./about.php" style="color:var(--secondary-dark-color);">About </a></p>
                                <p><a href="./contact.php" style="color:var(--secondary-dark-color);">Contact</a></p>
                        </div>
                        
                       
                    </div>
                    <p class="mini-text"  style="color:black;margin-left:50px;font-size:8px;color:var(--secondary-dark-color);">Copyright 2023 .Center Point. All right reserved </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer  -->

    <div class="menu-bottom desktop-hide">
        <div class="container">
            <div class="wrapper">
                <nav>
                    <ul class="flexitem menu-unorder-list">
                       
                        <li>
                            <a href="./account.php">
                                <i class="ri-user-6-line"></i>
                                <span>Account</span>
                            </a>
                        </li>
                        <li>
                            <a href="./whishlist.php">
                                <i class="ri-heart-line"></i>
                                <span>Wishlist</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="t-search">
                                <i class="ri-search-line"></i>
                                <span>Search</span>
                            </a>
                        </li>
                        <li>
                            <a href="./cart.php">
                                <i class="ri-shopping-cart-line"></i>
                                <span>Cart</span>
                                <div class="fly-item">
                                    <span class="item-number">0</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- menu bottom  -->

    <div class="search-bottom desktop-hide">
        <div class="container">
            <div class="wrapper">

            <form class="search" method="get" action="search.php">
      <span class="icon-large"><i class="ri-search-line"></i></span>
      <input type="search" name="query" placeholder="Search for products" value="<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>">
      <button type="submit">Search</button>
    </form>
    <?php
    if (isset($_GET['query'])) {
      $query = $_GET['query'];

      $sql = "SELECT * FROM products WHERE name LIKE '%".$query."%' OR description LIKE '%".$query."%'";
      $result = $conn->query($sql);
      
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<a href='./search.php?pid=".$row['product_id']."'>".$row['name']."</a><br>";
        }
      } else {
        echo "No results found.";
      }
    }
    ?>
            </div>
        </div>
    </div>
    <!-- Search bottom  -->

    <div class="backtotop">
        <a href="#" class="flexcol">
            <i class="ri-arrow-up-line"></i>
            <span>Top</span>
        </a>
    </div>

    <!-- <div class="overlay">
        
    </div> -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.3.1/index.js"></script>
    <script>
        const FtoShow = '.filter';
        const Fpopup = document.querySelector(FtoShow);
        const Ftrigger = document.querySelector('.filter-trigger');

        Ftrigger.addEventListener('click', () => {
            setTimeout(() => {
                if(!Fpopup.classList.contains('show')){
                    Fpopup.classList.add('show')
                }
            },250)
        })
        //auto close by click outside .filter//
        document.addEventListener('click', (e) => {
            const isClosest = e.target.closest(FtoShow);
            if (!isClosest && Fpopup.classList.contains('show')) {
                Fpopup.classList.remove('show')
            }
        })
    </script>
    <script src="script.js"></script>
</body>
</html>