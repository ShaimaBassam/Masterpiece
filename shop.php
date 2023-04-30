<?php

include './components/connect.php';


session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
};


if(isset($_POST['delete'])){
   $wishlist_id = $_POST['id'];
   $delete_wishlist_item = $conn->prepare("DELETE FROM `favorite` WHERE id = ?");
   $delete_wishlist_item->execute([$wishlist_id]);
}

if(isset($_GET['delete_all'])){
   $delete_wishlist_item = $conn->prepare("DELETE FROM `favorite` WHERE user_id = ?");
   $delete_wishlist_item->execute([$user_id]);
   header('location:wishlist.php');
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
      $send_to_cart = $conn->prepare("INSERT INTO `cart` (user_id , product_id , name , price , image , quantity)
                                    VALUES (? , ? , ? , ?, ? , ?)"); 
      $send_to_cart->execute([$user_id , $product_id , $product_name , $product_price, $product_image, $product_quantity]);
   }
}



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
</style>

<body>
    <div id="page" class="site page-category">
        <aside class="site-off desktop-hide">
            <div class="off-canvas">
                <div class="canvas-head flexitem">
                    <div class="logo"><img src="assets/Untitled-1.png" alt=""></a></div>
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
            </div>
            <!-- header-top  -->
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

            <div class="header-main mobile-hide">
                <div class="container">
                    <div class="wrapper flexitem">
                        <div class="left">
                            <div class="dpt-cat">
                                <div class="dpt-head">
                                    <div class="main-text">All Departments</div>
                                    <div class="mini-text mobile-hide">
                                        Total 40 Products
                                    </div>
                                    <a href="#" class="dpt-trigger mobile-hide">
                                        <i class="ri-menu-3-line ri-xl"></i>
                                        <i class="ri-close-line ri-xl"></i>
                                    </a>
                                </div>
                                <div class="dpt-menu">
                                    <ul class="second-links">
                                        <li class="has-child Womens">
                                            <a href="#">
                                                <div class="icon-large"><i class="ri-t-shirt-line"></i></div>
                                                Women's Fashion
                                            </a>
                                        </li>
                                        <li class="has-child Mens">
                                            <a href="#">
                                                <div class="icon-large"><i class="ri-shirt-line"></i></div>
                                                Men's Fashion
                                            </a>
                                        </li>
                                        <li class="has-child Girls">
                                            <a href="#">
                                                <div class="icon-large"><i class="ri-user-5-line"></i></div>
                                                Girl's Fashion
                                            </a>
                                        </li>
                                        <li class="has-child Boys">
                                            <a href="#">
                                                <div class="icon-large"><i class="ri-user-6-line"></i></div>
                                                Boy's Fashion
                                            </a>
                                        </li>
                                        <li class="has-child Home">
                                            <a href="#">
                                                <div class="icon-large"><i class="ri-home-4-line"></i></div>
                                                Home & Kitchen
                                            </a>
                                        </li>
                                        <li class="has-child Brokers">
                                            <a href="#">
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
                                <form action="" class="search">
                                    <span class="icon-large"><i class="ri-search-line"></i></span>
                                    <input type="search" placeholder="Search for products">
                                    <button type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
         <!-- header  -->
    <main>

        <div class="single-category">
            <div class="container">
                <div class="wrapper">
                    <div class="column">
                        <div class="holder">
                            <!-- <div class="row sidebar">
                                <div class="filter">
                                    <div class="filter-block">
                                        <h4>Category</h4>
                                        <ul>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="bags">
                                                <label for="bags">
                                                    <span class="checked"></span>
                                                    <span>Bags</span>
                                                </label>
                                                <span class="count">15</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="beauty">
                                                <label for="beauty">
                                                    <span class="checked"></span>
                                                    <span>Beauty</span>
                                                </label>
                                                <span class="count">5</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="outdoor">
                                                <label for="outdoor">
                                                    <span class="checked"></span>
                                                    <span>Outdoor</span>
                                                </label>
                                                <span class="count">4</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="travel">
                                                <label for="travel">
                                                    <span class="checked"></span>
                                                    <span>Travel</span>
                                                </label>
                                                <span class="count">3</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="urban">
                                                <label for="urban">
                                                    <span class="checked"></span>
                                                    <span>Urban</span>
                                                </label>
                                                <span class="count">7</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="filter-block">
                                        <h4>Activity</h4>
                                        <ul>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="athletic">
                                                <label for="athletic">
                                                    <span class="checked"></span>
                                                    <span>Athletic</span>
                                                </label>
                                                <span class="count">11</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="lounge">
                                                <label for="lounge">
                                                    <span class="checked"></span>
                                                    <span>Lounge</span>
                                                </label>
                                                <span class="count">8</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="cloting">
                                                <label for="cloting">
                                                    <span class="checked"></span>
                                                    <span>Clothing</span>
                                                </label>
                                                <span class="count">6</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="jewelry">
                                                <label for="jewelry">
                                                    <span class="checked"></span>
                                                    <span>Jewelry</span>
                                                </label>
                                                <span class="count">2</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="shoes">
                                                <label for="shoes">
                                                    <span class="checked"></span>
                                                    <span>Shoes</span>
                                                </label>
                                                <span class="count">3</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="filter-block">
                                        <h4>Brands</h4>
                                        <ul>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="nike">
                                                <label for="nike">
                                                    <span class="checked"></span>
                                                    <span>Nike</span>
                                                </label>
                                                <span class="count">1</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="louisvuitton">
                                                <label for="louisvuitton">
                                                    <span class="checked"></span>
                                                    <span>Louis Vuitton</span>
                                                </label>
                                                <span class="count">3</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="hermes">
                                                <label for="hermes">
                                                    <span class="checked"></span>
                                                    <span>Hermes</span>
                                                </label>
                                                <span class="count">2</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="gucci">
                                                <label for="gucci">
                                                    <span class="checked"></span>
                                                    <span>Gucci</span>
                                                </label>
                                                <span class="count">2</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="checkbox" id="zara">
                                                <label for="zara">
                                                    <span class="checked"></span>
                                                    <span>Zara</span>
                                                </label>
                                                <span class="count">3</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="filter-block products">
                                        <h4>Color</h4>
                                        <ul class="bycolor variant flexitem">
                                            <li>
                                                <input type="radio" name="color" id="cogrey">
                                                <label for="cogrey" class="circle"></label>
                                            </li>
                                            <li>
                                                <input type="radio" name="color" id="coblue">
                                                <label for="coblue" class="circle"></label>
                                            </li>
                                            <li>
                                                <input type="radio" name="color" id="cogreen">
                                                <label for="cogreen" class="circle"></label>
                                            </li>
                                            <li>
                                                <input type="radio" name="color" id="cored">
                                                <label for="cored" class="circle"></label>
                                            </li>
                                            <li>
                                                <input type="radio" name="color" id="colight">
                                                <label for="colight" class="circle"></label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="filter-block pricing">
                                        <h4>Price</h4>
                                        <div class="byprice">
                                            <div class="range-track">
                                                <input type="range" value="25000" min="0" max="100000">
                                            </div>
                                            <div class="price-range">
                                                <span class="price-form">50 JD</span>
                                                <span class="price-to">5000 JD</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="section">
                                <div class="row">
                                    <div class="cat-head">
                                        <div class="breadcrumb">
                                            <ul class="flexitem">
                                                <li><a href="./home.php">Home</a></li>
                                                <li>Shop</li>
                                            </ul>
                                        </div>
                                        <div class="page-title">
                                            <h1>Shop</h1>
                                        </div>
                                      
                                        <div class="cat-navigation flexitem">
                                            <!-- <div class="item-filter desktop-hide"> -->
                                                <!-- <a href="#" class="filter-trigger label">
                                                    <i class="ri-menu-2-line ri-2x"></i>
                                                    <span>Filter</span>
                                                </a> -->
                                            <!-- </div> -->
                                            <!-- <div class="item-sortir">
                                                <div class="label">
                                                    <span class="mobile-hide">Sort By Default</span>
                                                    <div class="desk-top-hide">Defualt</div>
                                                    <i class="ri-arrow-down-s-line"></i>
                                                </div>
                                                <ul>
                                                    <li>Default</li>
                                                    <li>Product Name</li>
                                                    <li>Price</li>
                                                    <li>Brand</li>
                                                </ul>
                                            </div> -->
                                            <!-- <div class="item-perpage mobile-hide">
                                                <div class="label">Items 10 per page</div>
                                                <div class="desktop-hide">10</div>
                                            </div> -->
                                            <!-- <div class="item-options">
                                                <div class="label">
                                                    <span class="mobile-hide">Show 10 per page</span>
                                                    <div class="desktop-hide">10</div>
                                                    <i class="ri-arrow-down-s-line"></i>
                                                </div>
                                                <ul>
                                                    <li>10</li>
                                                    <li>20</li>
                                                    <li>30</li>
                                                    <li>All</li>
                                                </ul>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="products main flexwrap">

                                    <div class="item">
                                        <div class="media">
                                            <div class="thumbnail object-cover">
                                                <a href="#">
                                                    <img src="assets/products/BEADED SHOULDER BAG.png" alt="">
                                                </a>
                                            </div>
                                            <div class="hoverable">
                                                <ul>
                                                    <li class="active"><a href="#"><i class="ri-heart-line"></i></a></li>
                                                    <!-- <li><a href="#"><i class="ri-eye-line"></i></a></li> -->
                                                    <!-- <li><a href="#"><i class="ri-shuffle-line"></i></a></li> -->
                                                </ul>
                                            </div>
                                            <!-- <div class="discount circle flexcenter"><span>25%</span></div> -->
                                        </div>
                                        <div class="content">
                                            <!-- <div class="rating">
                                                <div class="stars"></div>
                                                <span class="mini-text">(2,148)</span>
                                            </div> -->
                                            <h3 class="main-links"><a href="#">BEADED SHOULDER BAG</a></h3>
                                            <div class="price">
                                                <span class="current"> 16.99 JD</span>
                                                <span class="normal mini-text"> 20.55 JD</span>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- <div class="item">
                                        <div class="media">
                                            <div class="thumbnail object-cover">
                                                <a href="#">
                                                    <img src="assets/products/p7.png" alt="">
                                                </a>
                                            </div>
                                            <div class="hoverable">
                                                <ul>
                                                    <li class="active"><a href="#"><i class="ri-heart-line"></i></a></li>
                                                    <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                                    <li><a href="#"><i class="ri-shuffle-line"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="discount circle flexcenter"><span>25%</span></div>
                                        </div>
                                        <div class="content">
                                            <div class="rating">
                                                <div class="stars"></div>
                                                <span class="mini-text">(2,148)</span>
                                            </div>
                                            <h3 class="main-links"><a href="#">Happy Sailed Woman's Summer Boho Floral</a></h3>
                                            <div class="price">
                                                <span class="current"> 29.74 JD</span>
                                                <span class="normal mini-text"> 42.29 JD</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="media">
                                            <div class="thumbnail object-cover">
                                                <a href="#">
                                                    <img src="assets/products/p6.png" alt="">
                                                </a>
                                            </div>
                                            <div class="hoverable">
                                                <ul>
                                                    <li class="active"><a href="#"><i class="ri-heart-line"></i></a></li>
                                                    <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                                    <li><a href="#"><i class="ri-shuffle-line"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="discount circle flexcenter"><span>25%</span></div>
                                        </div>
                                        <div class="content">
                                            <div class="rating">
                                                <div class="stars"></div>
                                                <span class="mini-text">(2,148)</span>
                                            </div>
                                            <h3 class="main-links"><a href="./page-offer.html">CONTRAST KNIT DRESS WITH CUTWORK EMBROIDERY</a></h3>
                                            <div class="price">
                                                <span class="current"> 54 JD</span>
                                                <span class="normal mini-text"> 75 JD</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="media">
                                            <div class="thumbnail object-cover">
                                                <a href="#">
                                                    <img src="assets/products/PLATFORM HEELED SLINGBACK SHOES.png" alt="">
                                                </a>
                                            </div>
                                            <div class="hoverable">
                                                <ul>
                                                    <li class="active"><a href="#"><i class="ri-heart-line"></i></a></li>
                                                    <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                                    <li><a href="#"><i class="ri-shuffle-line"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="discount circle flexcenter"><span>25%</span></div>
                                        </div>
                                        <div class="content">
                                            <div class="rating">
                                                <div class="stars"></div>
                                                <span class="mini-text">(2,548)</span>
                                            </div>
                                            <h3 class="main-links"><a href="#">PLATFORM HEELED SLINGBACK SHOES</a></h3>
                                            <div class="price">
                                                <span class="current"> 25 JD</span>
                                                <span class="normal mini-text"> 34 JD</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="media">
                                            <div class="thumbnail object-cover">
                                                <a href="#">
                                                    <img src="assets/products/p8.png" alt="">
                                                </a>
                                            </div>
                                            <div class="hoverable">
                                                <ul>
                                                    <li class="active"><a href="#"><i class="ri-heart-line"></i></a></li>
                                                    <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                                    <li><a href="#"><i class="ri-shuffle-line"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="discount circle flexcenter"><span>25%</span></div>
                                        </div>
                                        <div class="content">
                                            <div class="rating">
                                                <div class="stars"></div>
                                                <span class="mini-text">(2,548)</span>
                                            </div>
                                            <h3 class="main-links"><a href="#">Happy Sailed Woman's Summer Boho Floral</a></h3>
                                            <div class="price">
                                                <span class="current"> 14 JD</span>
                                                <span class="normal mini-text"> 18 JD</span>
                                            </div>
                                            <!-- Additional Structure -->
                                            <!-- <div class="footer">
                                                <ul class="mini-text">
                                                    <li>Polyster, Cotton</li>
                                                    <li>Pull On Closure</li>
                                                    <li>Fashion Personality</li>
                                                </ul>
                                            </div>
                                        </div> -->
                                    <!-- </div> -->
                                </div> 
                                <div class="load-more flexcenter">
                                    <a href="#" class="secondary-button">Load More</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="banners">
            <div class="container">
                <div class="wrapper">
                    <div class="column">
                        <div class="banner flexwrap">
                            <div class="row">
                                <div class="item">
                                    <div class="image">
                                        <img src="assets/slider1/s6.png" alt="">
                                    </div>
                                    <div class="text-content flexcol">
                                        <h4>Brutal Sale!</h4>
                                        <h3><span>Get the deal in here</span><br>Living Room Chair</h3>
                                        <a href="#" class="primary-button">Shop Now</a>
                                    </div>
                                    <a href="#" class="over-link"></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="item get-gray">
                                    <div class="image">
                                        <img src="assets/slider1/s2.png" alt="">
                                    </div>
                                    <div class="text-content flexcol">
                                        <h4>Brutal Sale!</h4>
                                        <h3><span>Discount Everyday</span><br>Office Outfit</h3>
                                        <a href="#" class="primary-button">Shop Now</a>
                                    </div>
                                    <a href="#" class="over-link"></a>
                                </div>
                            </div>
                         -->
                            <!-- banners  -->
                            <!-- <div class="product-categories flexwrap">
                            <div class="row">
                                <div class="item">
                                    <div class="image">
                                        <img src="assets/products/Advanced Snail 96 Mucin Power Essence.png" alt="">
                                    </div>
                                    <div class="content mini-links">
                                        <h4>Beauty</h4>
                                        <ul class="flexcol">
                                            <li><a href="#">Makeup</a></li>
                                            <li><a href="#">Skin Care</a></li>
                                            <li><a href="#">Hair Care</a></li>
                                            <li><a href="#">Fragrance</a></li>
                                            <li><a href="#">Foot & Hand Care</a></li>
                                        </ul>
                                        <div class="second-links">
                                            <a href="#" class="view-all">View All<i class="ri-arrow-right-line"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="item">
                                    <div class="image">
                                        <img src="assets/products/Rachel Bag.png" alt="">
                                    </div>
                                    <div class="content mini-links">
                                        <h4>Beauty</h4>
                                        <ul class="flexcol">
                                            <li><a href="#">Makeup</a></li>
                                            <li><a href="#">Skin Care</a></li>
                                            <li><a href="#">Hair Care</a></li>
                                            <li><a href="#">Fragrance</a></li>
                                            <li><a href="#">Foot & Hand Care</a></li>
                                        </ul>
                                        <div class="second-links">
                                            <a href="#" class="view-all">View All<i class="ri-arrow-right-line"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="item">
                                    <div class="image">
                                        <img src="assets/products/spela.png" alt="">
                                    </div>
                                    <div class="content mini-links">
                                        <h4>Beauty</h4>
                                        <ul class="flexcol">
                                            <li><a href="#">Makeup</a></li>
                                            <li><a href="#">Skin Care</a></li>
                                            <li><a href="#">Hair Care</a></li>
                                            <li><a href="#">Fragrance</a></li>
                                            <li><a href="#">Foot & Hand Care</a></li>
                                        </ul>
                                        <div class="second-links">
                                            <a href="#" class="view-all">View All<i class="ri-arrow-right-line"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </main>

    <footer>
        <div class="newsletter">
            <div class="container">
                <div class="wrapper">
                    <div class="box">
                        <div class="content">
                            <h3>Join Our Newsletter</h3>
                            <p>Get E-mail updates about our latest shop and <strong>special offers</strong></p>
                        </div>
                        <form action="" class="search">
                            <span class="icon-large"><i class="ri-mail-line"></i></span>
                            <input type="mail" placeholder="Your email address" required>
                            <button type="submit">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- newsletter -->

        <div class="widgets">
            <div class="container">
                <div class="wrapper">
                    <div class="flexwrap">
                        <div class="row">
                            <div class="item mini-links">
                                <h4>Help & Contact</h4>
                                <ul class="flexcol">
                                    <li><a href="#">Your Account</a></li>
                                    <li><a href="#">Your Order</a></li>
                                    <li><a href="#">Shipping Rates</a></li>
                                    <li><a href="#">Returns</a></li>
                                    <li><a href="#">Assistant</a></li>
                                    <li><a href="#">Help</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="item mini-links">
                                <h4>Payment Info</h4>
                                <ul class="flexcol">
                                    <li><a href="">Bussines Card</a></li>
                                    <li><a href="">Shop with Points</a></li>
                                    <li><a href="">Reload Your Balance</a></li>
                                    <li><a href="">Paypal</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="item mini-links">
                                <h4>About Us</h4>
                                <ul class="flexcol">
                                    <li><a href="">Company Info</a></li>
                                    <li><a href="">News</a></li>
                                    <li><a href="">Investors</a></li>
                                    <li><a href="">Careers</a></li>
                                    <li><a href="">Policies</a></li>
                                    <li><a href="">Customer reviews</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="item mini-links">
                                <h4>Product Categories</h4>
                                <ul class="flexcol">
                                    <li><a href="">Bueaty</a></li>
                                    <li><a href="">Electronic</a></li>
                                    <li><a href="">Woman's Fashion</a></li>
                                    <li><a href="">Men's Fashion</a></li>
                                    <li><a href="">Home & Kitchen</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- widgets -->

        <div class="footer-info">
            <div class="container">
                <div class="wrapper">
                    <div class="flexcol">
                        <div class="logo">
                            <a href=""><span class="circle">.Store</span></a>
                        </div>
                        <div class="socials">
                            <ul class="flexitem">
                                <li><a href="#"><i class="ri-twitter-line"></i></a></li>
                                <li><a href="#"><i class="ri-facebook-line"></i></a></li>
                                <li><a href="#"><i class="ri-instagram-line"></i></a></li>
                                <li><a href="#"><i class="ri-linkedin-line"></i></a></li>
                                <li><a href="#"><i class="ri-youtube-line"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <p class="mini-text">Copyright 2023 .StoreName. All right reserved. </p>
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
                            <a href="#">
                                <i class="ri-bar-chart-line"></i>
                                <span>Trending</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="ri-user-6-line"></i>
                                <span>Account</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="ri-heart-line"></i>
                                <span>Wishlist</span>
                            </a>
                        </li>
                        <li>
                            <a href="#0" class="t-search">
                                <i class="ri-search-line"></i>
                                <span>Search</span>
                            </a>
                        </li>
                        <li>
                            <a href="#0" class="cart-trigger">
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

    <!-- <div id="modal" class="modal">
        <div class="content flexcol">
            <div class="image object-cover">
                <img src="assets/products/p3.png" alt="">
            </div>
            <h2>Get the latest deals and coupons</h2>
            <p class="mobile-hide">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet, velit!</p>
            <form action="" class="search">
                <span class="icon-large"><i class="ri-mail-line"></i></span>
                <input type="email" placeholder="Your Email Address">
                <button>Subscribe</button>
            </form>
            <a href="#" class="mini-text">Do not show me this again</a>
            <a href="#" class="t-close modalclose flexcenter">
                <i class="ri-close-line"></i>
            </a>
        </div>
    </div> -->
    <!-- modal -->
    <!-- <div class="backtotop">
        <a href="#" class="flexcol">
            <i class="ri-arrow-up-line"></i>
            <span>Top</span>
        </a>
    </div> -->

    <div class="search-bottom desktop-hide">
        <div class="container">
            <div class="wrapper">

                <form action="" class="search">
                    <a href="#" class="t-close search-close flexcenter"><i class="ri-close-line"></i></a>
                    <span class="icon-large"><i class="ri-search-line"></i></span>
                    <input type="search" placeholder="Your email address" required>
                    <button type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Search bottom  -->
<!-- 
    <div class="overlay">
        
    </div>
    </div> -->
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