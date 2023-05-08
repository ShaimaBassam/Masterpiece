<?php
include './components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

 

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['addTOcart'])){
   $product_id = $_POST['product_id'];
   $product_name = $_POST['name'];
   $product_price = $_POST['price'];
   $product_image = $_POST['image'];
   $product_quantity = $_POST['quantity'];
//    $product_size = $_POST['size'];
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
      $array_cart = [$product_id , $product_name , $product_price, $product_image, $product_quantity ];
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
    <div id="page" class="site page-single">
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

        <div class="single-product">
            <div class="container">
                <div class="wrapper">
                    
                    <!-- breadcrumb -->
                    <div class="column">
                        <div class="products one">
                            <div class="flexwrap">
                                <div class="row">
                                    <div class="item is_sticky">
                                    <?php
    $pid = $_GET['pid'];
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE product_id = ?");
    $select_products->execute([$pid]);
    if ($select_products->rowCount() > 0) {
      while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
        $sizes = json_decode($fetch_product['size']);
    ?>
      <input type="hidden" name="product_id" value="<?= $fetch_product['product_id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image']; ?>">

      
                                        <div class="price">
                                        </div>
                                        <div class="big-image">
                                            <div class="big-image-wrapper swiper-wrapper">
                                                <div class="image-show swiper-slide">
                                                    <a data-fslightbox href="assets/products/p5.png"><img src="uploaded_img/<?= $fetch_product['image']; ?>" alt=""></a>
                                                </div>
                                               
                                            </div>
                                            
                                        </div>

                                       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="item">
                                        <h1><?= $fetch_product['name']; ?></h1>
                                        <div class="content">
                                           
                                           
                                            <div class="price">
                                            <?php if ($fetch_product['is_sale'] == 1){ ?>

<div class="price" style="padding:7px 0px"><span><del style="text-decoration:line-through; color:silver">JOD<?= $fetch_product['price']; ?></del><ins style="color:red;  text-decoration: none;"> JOD<?=$fetch_product['price_discount'];?></ins> </span></div>

<?php } else { ?>

<div class="name" style="color:rgb(0, 0, 69) !important; padding:20px 0px" >JOD<?= $fetch_product['price']; ?></div> <?php } ?>

<?php if (($fetch_product['store']-$fetch_product['sold']) != '1'){?>

                                            </div>
                                            
                                            <div class="sizes">
                                                <p>Size</p>
                                                <div class="variant">
                                                    <form action="" method="post" class="box">

                                                        
                                                    <p style="    display: flex;
    margin-top: 0.5em;
    flex-direction: row;
    padding: 10px;">
<?php
  // Check if the size filter input is set
  if(isset($_GET['size_filter'])) {
    $size_filter = $_GET['size_filter'];
  } else {
    $size_filter = '';
  }

  $pid = $_GET['pid'];
  $select_sizes = $conn->prepare("SELECT size FROM `products` WHERE product_id = ? AND size LIKE ?");
  $select_sizes->execute([$pid, "%$size_filter%"]);
  $sizes = $select_sizes->fetchAll(PDO::FETCH_COLUMN);

  // Separate sizes by spaces instead of commas
  $sizes = str_replace(',', ' ', implode(',', $sizes));

  if(!empty($sizes)){
    foreach (explode(' ', $sizes) as $index => $size) {
      $id = 'size-' . $index;
?>
      <p>
        <input type="radio"  name="size" id="<?php echo $id; ?>" value="<?php echo $size; ?>" <?php if($size_filter == $size) {echo 'checked';} ?>>
        <label for="<?php echo $id; ?>" class="circle"><span><?php echo $size; ?></span></label>
      </p>
<?php 
    }
  } else {
    echo "No sizes available";
  }
?>





                                                    </form>
                                                </div>
                                            </div>
                                            <form action="" method="post" class="box">
                                            <input type="hidden" name="product_id" value="<?= $fetch_product['product_id']; ?>">
                                            <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                                             <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                                              <input type="hidden" name="image" value="<?= $fetch_product['image']; ?>">

                                              <div class="sizes">
                                              <p>Quantity</p>
                                              <input style="width: 90px; height: 50px;margin:20px;" type="number" name="quantity" class="qty" min="1" max="<?= $fetch_product['store']-$fetch_product['sold'];?>" value="1">

<?php } else { ?>
<input type="hidden" name="quantity" value="1">
<?php } ?> 
                                            </div>

                                            <div class="sizes">
                                            <input type="submit" value="add to cart" class="btn" name="addTOcart" style="background-color: var(--primary-color);
    color: var(--white-color);margin:20px; border: none;">

                                            <input class="option-btn" type="submit" name="add_to_wishlist" value="add to wishlist" style="background-color: var(--primary-color);
    color: var(--white-color); border: none;">

                                            </div>
                                            
                                            
                                            <div class="description collapse">
                                                <ul>
                                                    
                                                    <li class="has-child">
                                                        <a href="#0" class="icon-small">Details</a>
                                                        <div class="content">
                                                            <p><?= $fetch_product['details']; ?></p>
                                                            
                                                        </div>
                                                    </li>
                                                    </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>
                                                    <li class="has-child">
                                                        <a href="#0" class="icon-small">Custom</a>
                                                        <div class="content">
                                                           <table>
                                                            <thead>
                                                                <tr>
                                                                    <th>Size</th>
                                                                    <th>Bust<span class="mini-text">(cm)</span></th>
                                                                    <th>Waist<span class="mini-text">(cm)</span></th>
                                                                    <th>Hip<span class="mini-text">(cm)</span></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>XS</td>
                                                                    <td>82,5</td>
                                                                    <td>62</td>
                                                                    <td>87,5</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>S</td>
                                                                    <td>85</td>
                                                                    <td>63,5</td>
                                                                    <td>89</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>M</td>
                                                                    <td>87,5</td>
                                                                    <td>67,5</td>
                                                                    <td>93</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>L</td>
                                                                    <td>90</td>
                                                                    <td>72,5</td>
                                                                    <td>98</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>XL</td>
                                                                    <td>93</td>
                                                                    <td>77,5</td>
                                                                    <td>103</td>
                                                                </tr>
                                                            </tbody>
                                                           </table>
                                                        </div>
                                                    </li>

                                                    
                                                

<?php
$query = "SELECT * FROM review INNER JOIN users ON (review.user_id = users.user_id) WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$pid]);
$comments = $stmt->fetchAll();
?>

<li class="has-child">
    <a href="#" class="icon-small">Reviews</a>
    <div class="content">
        <div class="reviews">
            <h4>Customers Reviews</h4>
            <div class="review-block">
                <div class="review-block-head">
                <a href="#review-form" class="secondary-button">Write Review</a>
                </div>
                <div class="review-block-body">
                    <?php foreach ($comments as $comment) {
                        $comment_id = $comment['review_id'];
                        $product_id = $comment['product_id'];
                        $comment_date = $comment['review_date'];
                        $comment_content = $comment['review_text'];
                        $user_name = $comment['name'];
                    ?>
                        <ul>
                            <li class="item">
                                <div class="review-form">
                                    <p class="person">Review by <?php echo $user_name ?></p>
                                    <p class="mini-text">On <?php echo $comment_date ?></p>
                                </div>
                                <div class="review-text">
                                    <p><?php echo  $comment_content; ?></p>
                                </div>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
                <div id="review-form" class="review-form">
                    <h4>Write a review</h4>
                    <?php
                    if (isset($_POST['comment_text'])) {
                        if (isset($_SESSION['user_id'])) {
                            $comment_text = $_POST['comment_text'];
                            $sqlInserComment = "INSERT INTO review (user_id, product_id, review_text, review_date) 
                            VALUES ('$user_id', '$pid', '" . addslashes($comment_text) . "', NOW())";
                            $stmt = $conn->query($sqlInserComment);
                            echo "<script>window.location='./pageSingle.php?pid=$pid'</script>";
                        }
                    }
                    ?>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <form action="" method="post">
                            <p>
                                <label>Review</label>
                                <textarea name="comment_text" cols="30" rows="10"></textarea>
                            </p>
                            <p><input type="submit" name="submit_comment" value="Submit " class="primary-button"></input></p>
                        </form>
                    <?php } ?>
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
                    <a href="#0" class="t-search">
                        <i class="ri-search-line"></i>
                        <span>Search</span>
                    </a>
                </li>
                <li>
                    <a href="#0">
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

    <div class="overlay">
        
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.3.1/index.js"></script>
    <script src="script.js"></script>
</body>
</html>