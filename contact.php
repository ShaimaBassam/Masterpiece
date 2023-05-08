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
    <title>Center Point</title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
    <link rel="icon" type="image/x-icon" href="./assets/logo.png">
    
<!-- Google Mapl -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
    <script type="text/javascript" src="./gmap.js"></script>
</head>
<style>
    .image-container {
  position: relative;
}

.image-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color:#fff;
  font-size: 18px;
  text-align:center;
  text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.5);


}
.text-container p {
  text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.5);
}
/* Styling for the container of the form */
.containerform {
  width: 50%;
  /* margin-top: 40px; */
  margin-left: 30%;
padding: 50px;

}

/* Styling for the labels */
label {
  display: block;
  margin-bottom: 5px;
}

/* Styling for the input fields */
input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-bottom: 10px;
}

/* Styling for the submit button */
input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

</style>

<body>
    <div id="page" class="site page-cart">
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
         <div class="single-cart">
            <!-- <div class="container"> -->
            <div class="containerform">
                <?php
            // insert form data into database
if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = isset($_POST['phone']) ? $_POST['phone'] : NULL;
    $address = isset($_POST['address']) ? $_POST['address'] : NULL;
    $city = isset($_POST['city']) ? $_POST['city'] : NULL;
    $state = isset($_POST['state']) ? $_POST['state'] : NULL;
    
    $sql = "INSERT INTO contacts (first_name, last_name, email, phone, address, city, state) VALUES ('$first_name', '$last_name', '$email', '$phone', '$address', '$city', '$state')";
    
    
}
?>
  <form action="" style="  padding: 20px;
  background-color: #f2f2f2;
  border-radius: 5px;" method="post" action="">

      <label for="first_name">First Name:</label>
      <input type="text" id="first_name" name="first_name" required><br>

      <label for="last_name">Last Name:</label>
      <input type="text" id="last_name" name="last_name" required><br>

     

      <label for="address">Address:</label>
      <input type="text" id="address" name="address"><br>

      <label for="city">City:</label>
      <input type="text" id="city" name="city"><br>
      
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required><br>

      <label for="phone">Phone:</label>
      <input type="tel" id="phone" name="phone"><br><br>
      
      <input type="submit" value="Submit">
</form>
</div>
         </div>

    </main>

    <footer>
       
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
<!-- 
    <div id="modal" class="modal">
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
    <div class="backtotop">
        <a href="#" class="flexcol">
            <i class="ri-arrow-up-line"></i>
            <span>Top</span>
        </a>
    </div>

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