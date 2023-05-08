
<?php

include './components/connect.php';


// header
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
    <div id="page" class="site page-home">
        
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
        <!-- main -->
        <div class="slider">
            <div class="container">
                <div class="wrapper">
                    <div class="myslider swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="item"> 
                                   <div class="image object-cover">
                                    <img src="assets/slider1/s6.png" alt="slide1">
                                   </div>  
                                   <div class="text-content flexcol">
                                    <!-- <h4>Women-Fashion</h4> -->
                                    <h2> 
                                        <span>Get ready for</span><br><span> summer with our latest collection </span> 
                                    </h2>
                                    <a href="./shop.php" class="primary-button">Shop Now</a>
                                   </div>       
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="item"> 
                                   <div class="image object-cover">
                                    <img src="./assets/slider1/s2.png" alt="">
                                   </div>  
                                   <div class="text-content flexcol">
                                    <!-- <h4>Men Fashion</h4> -->
                                    <h2> 
                                        <span>Dress to impress</span><br><span> with our formal wear collection</span> 
                                    </h2>
                                    <a href="./shop.php" class="primary-button">Shop Now</a>
                                   </div>       
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="item"> 
                                   <div class="image object-cover">
                                    <img src="./assets/slider1/61pBnu9VX+L._AC_SX679_.jpg" alt="">
                                   </div>  
                                   <div class="text-content flexcol">
                                    <!-- <h4>Shoes Fashion</h4> -->
                                    <h2> 
                                        <span>Entertain with</span><br><span> style with our collection</span> 
                                    </h2>
                                    <a href="./shop.php" class="primary-button">Shop Now</a>
                                   </div>       
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="item"> 
                                   <div class="image object-cover">
                                    <img src="assets/slider1/group-beautiful-girls-boys.jpg" alt="">
                                   </div>  
                                   <div class="text-content flexcol">
                                    <!-- <h4>Shoes Fashion</h4> -->
                                    <h2> 
                                        <span>Trendy styles</span><br><span> for fashionable kids</span> 
                                    </h2>
                                    <a href="./shop.php" class="primary-button">Shop Now</a>
                                   </div>       
                                </div>
                            </div>
                            

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slider -->
        <div class="brands">
            <div class="container">
                <div class="wrapper flexitem">
                <div class="item">
                        <a >
                            <img src="assets/brands/272217624_109698628282453_2453873482967426746_n-removebg-preview.png" alt="" width="300px" height="200px">
                        </a>
                    </div>
                    <div class="item">
                    <a >
                            <img src="./assets/brands/68948073_658269107989189_3892282883292790784_n-removebg-preview.png" alt="" width="300px" height="200px">
                     </a>
                    </div>
                    
                    <div class="item">
                        <a >
                            <img src="assets/brands/56997565_2493990500828639_4305479765327872000_n-removebg-preview.png" alt="" width="300px" height="200px">
                        </a>
                    </div>
                   
                </div>
            </div>
        </div>
        <!-- brands -->
        <!-- <div class="trending">
            <div class="container">
                <div class="wrapper">
                    <div class="sectop flexitem">
                        <h2><span class="circle"></span> <span>Trending Products</span></h2>
                    </div>
                    <div class="column">
                        <div class="flexwrap">
                            <div class="row products big">
                                <div class="item">
                                    <div class="offer">
                                        <p> Offer ends at</p>
                                        <ul class="flexcenter">
                                            <li>1</li>
                                            <li>15</li>
                                            <li>27</li>
                                            <li>60</li>
                                        </ul>
                                    </div>
                                    <div class="media">
                                        <div class="image">
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
                                        <div class="discount circle flexcenter"><span>31%</span></div>
                                    </div>
                                    <div class="content">
                                        <div class="rating">
                                            <div class="stars"></div>
                                            <span class="mini-text">(2,548)</span>
                                        </div>
                                        <h3 class="main-links">
                                            <a href="./page-offer.html">CONTRAST KNIT DRESS WITH CUTWORK EMBROIDERY</a>
                                        </h3>
                                        <div class="price">
                                            <span class="current"> 126.99 JD</span>
                                            <span class="normal mini-text"> 189 JD</span>
                                        </div>
                                        <div class="stock mini-text">
                                            <div class="qty">
                                                <span>Stock:<strong class="qty-available">107</strong></span>
                                                <span>Sold:<strong class="qty-sold">500</strong></span>
                                            </div>
                                            <div class="bar">
                                                <div class="available"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row products mini">
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
                                        <div class="discount circle flexcenter"><span>20%</span></div>
                                    </div>
                                    <div class="content">
                                        <h3 class="main-links"><a href="#">Men Slip On Shoes Casual with Arch Support Insoles</a></h3>
                                        <div class="rating">
                                            <div class="stars"></div>
                                            <span class="mini-text">(322)</span>
                                        </div>
                                        <div class="price">
                                            <span class="current"> 38 JD</span>
                                            <span class="normal mini-text"> 48 JD</span>
                                        </div>
                                        <div class="mini-text">
                                            <p>2900 Sold</p>
                                            <p>Free Shipping</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
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
                                        <div class="discount circle flexcenter"><span>10%</span></div>
                                    </div>
                                    <div class="content">
                                        <h3 class="main-links"><a href="#">Men Slip On Shoes Casual with Arch Support Insoles</a></h3>
                                        <div class="rating">
                                            <div class="stars"></div>
                                            <span class="mini-text">(1022)</span>
                                        </div>
                                        <div class="price">
                                            <span class="current"> 12.99 JD</span>
                                            <span class="normal mini-text"> 18 JD</span>
                                        </div>
                                        <div class="mini-text">
                                            <p>2900 Sold</p>
                                            <p>Free Shipping</p>
                                            <p class="stock-danger">Stock: 7 left!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row products mini">
                                <div class="item">
                                    <div class="media">
                                        <div class="thumbnail object-cover">
                                            <a href="#">
                                                <img src="assets/products/p5.png" alt="">
                                            </a>
                                        </div>
                                        <div class="hoverable">
                                            <ul>
                                                <li class="active"><a href="#"><i class="ri-heart-line"></i></a></li>
                                                <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                                <li><a href="#"><i class="ri-shuffle-line"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="discount circle flexcenter"><span>10%</span></div>
                                    </div>
                                    <div class="content ">
                                        <h3 class="main-links"><a href="./page-single.html">Black Woman's Caot Dress</a></h3>
                                        <div class="rating">
                                            <div class="stars"></div>
                                            <span class="mini-text">(992)</span>
                                        </div>
                                        <div class="price">
                                            <span class="current"> 100.99 JD</span>
                                            <span class="normal mini-text"> 110 JD</span>
                                        </div>
                                        <div class="mini-text">
                                            <p>2900 Sold</p>
                                            <p>Free Shipping</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="media">
                                        <div class="thumbnail object-cover">
                                            <a href="#">
                                                <img src="assets/products/p3.png" alt="">
                                            </a>
                                        </div>
                                        <div class="hoverable">
                                            <ul>
                                                <li class="active"><a href="#"><i class="ri-heart-line"></i></a></li>
                                                <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                                <li><a href="#"><i class="ri-shuffle-line"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="discount circle flexcenter"><span>33%</span></div>
                                    </div>
                                    <div class="content ">
                                        <h3 class="main-links"><a href="./page-single.html">Black Woman's Caot Dress</a></h3>
                                        <div class="rating">
                                            <div class="stars"></div>
                                            <span class="mini-text">(782)</span>
                                        </div>
                                        <div class="price">
                                            <span class="current"> 126.99 JD</span>
                                            <span class="normal mini-text"> 189 JD</span>
                                        </div>
                                        <div class="mini-text">
                                            <p class="mini-p">2900 Sold</p>
                                            <p class="mini-p">Free Shipping</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->


        <!-- trending  -->
        
        <div class="features">
    <div class="container">
        <div class="wrapper">
            <div class="column">
                <div class="sectop flexitem">
                    <h2><span class="circle"></span> <span>Sales Products</span></h2>
                    <!-- <div class="second-links">
                        <a href="#" class="view-all">View All<i class="ri-arrow-right-line"></i></a>
                    </div> -->
                </div>
                <div class="products main flexwrap">
                    <?php
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE is_sale='1'"); 
                        $select_products->execute();
                        if($select_products->rowCount() > 0){
                            while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
                                $i=0;
                                $is_product_in_store = ($fetch_product['store']-$fetch_product['sold']);
                                if ( $is_product_in_store <= 0 ){
                                    continue;
                                } else { 
                    ?>
                                    <input type="hidden" name="product_id" value="<?= $fetch_product['product_id']; ?>">
                                    <input type="hidden" name="id" value="<?= $fetch_product['name']; ?>">
                                    <?php 
                                        if ($fetch_product['is_sale'] == 1){
                                    ?>
                                        <input type="hidden" name="price" value="<?=$fetch_product['price_discount'];?>">
                                    <?php
                                        } else {
                                    ?>
                                        <input type="hidden" name="price" value="<?=$fetch_product['price'];?>">
                                    <?php
                                        }
                                    ?>
                                    <input type="hidden" name="image" value="<?= $fetch_product['image']; ?>">
                                    <div class="item">
                                        <div class="media">
                                            <div class="thumbnail object-cover">
                                                <a href="pageSingle.php?pid=<?= $fetch_product['product_id']; ?>">
                                                    <img src="uploaded_img/<?= $fetch_product['image']; ?>" alt="">
                                                </a>
                                            </div>
                                            <form  action="" method="post"  >
                                     <input type="hidden" name="product_id" value="<?= $fetch_product['product_id']; ?>">
                                    <input type="hidden" name="id" value="<?= $fetch_product['name']; ?>">
                                                <div class="hoverable">
                                                <ul>
                                                    <button type="submit" name="add_to_wishlist" class="active" style="  background-color: transparent;
  border: none;"><li ><a href="#"><i class="ri-heart-line"></i></a></li></button>
                                                    </ul>
                                            </form> 
                                                </div>
                                            <!-- <div class="discount circle flexcenter"><span>25%</span></div> -->
                                        </div>
                                        <div class="content">
                                            <h3 class="main-links"><a href="pageSingle.php?pid=<?= $fetch_product['product_id']; ?>"><?= $fetch_product['name']; ?></a></h3>
                                            <div class="price">
                                                <?php if ($fetch_product['is_sale'] == 1){ ?>
                                                    <div class="price"><span><del style="text-decoration:line-through; color:silver">JD<?=$fetch_product['price'];?></del><span style="color:red;  text-decoration: none;"> JD<?=$fetch_product['price_discount'];?></span> </span></div>
                                                <?php } else { ?>
                                                    <div class="name" style="color:#67022f; padding:20px 0px">JD<?=$fetch_product['price'];?></div> 
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                    <?php 
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


       <div class="banners">
            <div class="container">
                <div class="wrapper">
                    <div class="column">
                        <div class="banner flexwrap" >
                            <div class="row">
                                <div class="item">
                                    <div class="image" style="height:300px;!important">
                                        <img src="assets/slider1/s6.png" alt="" style="height:300px;width:600px;!important" >
                                    </div>
                                    <div class="text-content flexcol">
                                        <!-- <h4>Brutal Sale!</h4> -->
                                        <h3><br>Women Fashion</h3>
                                        <a href="category.php?category=1" class="primary-button">Shop Now</a>
                                    </div>
                                    <a href="category.php?category=1" class="over-link"></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="item get-gray" style="height:300px;!important">
                                    <div class="image">
                                        <img src="assets/slider1/s2.png" alt="" style="height:300px;width:600px;!important">
                                    </div>
                                    <div class="text-content flexcol">
                                        <!-- <h4>Brutal Sale!</h4> -->
                                        <h3><br>Men Fashion</h3>
                                        <a href="category.php?category=2" class="primary-button">Shop Now</a>
                                    </div>
                                    <a href="category.php?category=2" class="over-link"></a>
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

    <div class="overlay">
        
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>