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

</head>
<style>
    .header-main{
        margin-bottom: 0em !important;
    }
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
<div id="page" class="site page-cart">
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
                        <a href="#" class="trigger desktop-hide"></a>
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
                                        <?php }?>
                                    </a>
                                </li>

                                

                                <li class="iscart"><a href="./cart.php">
                                    <div class="icon-large">
                                        <i class="ri-shopping-cart-line"></i>
                                    </div>


                                    
                                </a>
                                
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
            <div class="image-container">
            <div class="shadow">
            <img src="assets/fast-fashion-vs-slow-sustainable-fashion.jpg" alt="" style="height:700px;width:2000px;">
            <div class="image-text">
            <h1>About Us</h1>
            <p>Welcome to center point  your one-stop shop for high-quality, unique products sourced directly from the vibrant city of Aqaba, Jordan. Our mission is to support local store owners by providing them with a platform to showcase their products , while also collaborating with brokers of online marketplaces like Shein to offer a diverse range of products to our customers.</p>
            <p>We believe in the power of community and supporting small businesses, which is why we are passionate about connecting our customers with independent store owners in Aqaba. By doing so, we not only help promote local businesses but also provide our customers with access to fashion that they won't find anywhere else.</p>
            <p>At center point, we are committed to providing a seamless shopping experience that is both convenient and enjoyable. Our team is dedicated to ensuring that your shopping experience is hassle-free, from browsing our website to receiving your order.</p>
            </div>
            </div>

                <!-- <div class="wrapper">

                </div> -->
            <!-- </div> -->
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