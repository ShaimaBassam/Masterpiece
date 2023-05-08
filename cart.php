<?php

include './components/connect.php';


// header
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};




if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['quantity'];
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
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
                                        <?php }?>
                                    </a>
                                </li>

                                

                              

                                

                                <li class="iscart"><a href="./cart.php">
                                    <div class="icon-large">
                                        <i class="ri-shopping-cart-line"></i>
                                    </div>

                                </a>
                               


                            
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
                                        <i class="ri-close-line ri-xl"></i>
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
            <div class="container">
                <div class="wrapper">
                    <div class="breadcrumb">
                        <ul class="flexitem">
                            <li><a href="./home.php">Home</a></li>
                            <li>Cart</li>
                        </ul>
                    </div>
                    <div class="page-title">
                        <h1>Shopping Cart</h1>
                    </div>
                    <div class="products one cart">
                        <div class="flexwrap">
                            <form action="" class="form-cart" method="post">
                                <div class="item">
                                    
                                      <table id="cart-table">
    <thead>
        <tr>
            <th>Item</th>
            <th>Price</th>
            <th>QTY</th>
            <th>Delete Item</th>
            <th>Subtotal</th>


            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_price = 0;
        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $select_cart->execute([$user_id]);
        if ($select_cart->rowCount() > 0) {
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                $product_cart_id = $fetch_cart['product_id'];
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE product_id = ?");
                $select_product->execute([$product_cart_id]);
                if ($select_product->rowCount() > 0) {
                    $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);
                    $x = 0;
                    if ($fetch_product['is_sale'] == 1) {
                        $price = $fetch_product['price_discount'];
                    } else {
                        $price = $fetch_product['price'];
                    }
                    $subtotal = $price * $fetch_cart['quantity'];
                    $total_price += $subtotal;
        ?>
                   
                        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                        <tr>
                            <td class="flexitem">
                                <div class="thumbnail object-cover">
                                    <a href="./pageSingle.php?pid=<?= $fetch_cart['product_id']; ?>"><img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt=""></a>
                                </div>
                                
                                <div class="content">
                                    <strong><a href="./pageSingle.php?pid=<?= $fetch_cart['product_id']; ?>"><?= $fetch_cart['name']; ?></a></strong>
                                </div>
                            </td>
                            <td>
                                <div class="price">
                                    <span>
                                        <?php
                                        if ($fetch_product['is_sale'] == 1) {
                                        ?>
                                            <del style="text-decoration:line-through; color:silver">JD<?= $fetch_product['price']; ?></del>
                                            <ins style="color:red;text-decoration:none;"> JD<?= $fetch_product['price_discount']; ?></ins>
                                        <?php
                                            $x = $fetch_product['price_discount'];
                                        } else {
                                        ?>
                                            <div class="name" style="color:rgb(0, 0, 69) !important; padding:20px 0px">JD<?= $fetch_product['price']; ?></div>
                                        <?php
                                            $x = $fetch_product['price'];
                                        }
                                        ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="qty-control flexitem">
                                    <?php
                                    if ($fetch_product['category_id'] != '9') {
                                    ?>
                                        <input type="number" name="quantity" class="qty" min="1" max="<?= $fetch_product['store'] - $fetch_product['sold']; ?>" value="<?= $fetch_cart['quantity']; ?>">
                                        <button type="submit" class="fas fa-edit" name="update_qty"></button>
                                    <?php
                                    } else {
                                    ?>
                                        <input type="hidden" name="quantity" value="1">
                                    <?php
                                    }
                                    ?>
                            </td>

                            <td>

                                                 <input type="submit" value="delete item" onclick="return confirm('delete this from cart?');" class="primary-button" name="delete" style="border:none;">
                            </td>

                            <td>
                                <div class="price">
                                    <span>
                                    JD<?= $sub_total = ($x * $fetch_cart['quantity']); ?>
                                    </span>
                                </div>
                            </td>
<?php } } } ?>  


                                           
                                            
                                        </tbody>
                                    </table>
                                    
                                </div>

                            </form>

                            <div class="cart-summary styled">
                                    
                                    <div class="cart-total">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <th>Delivery In Aqaba </th>
                                                        <td>2.00 JD</td>
                                                    </tr>
                                                    <tr class="grand-totaal">
                                                        <th>Total</th>
                                                        <td><strong><?= $total_price+2; ?></strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <a href="./checkout.php" class="primary-button">Checkout</a>
                                        </div>
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
                    <a href="#0" class="t-search">
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