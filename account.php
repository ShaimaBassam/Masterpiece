<?php

include './components/connect.php';

// session_start();

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
    <link rel="stylesheet" href="./account.css">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
    <link rel="icon" type="image/x-icon" href="./assets/logo.png">

</head>
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
                </div>
            </div>
            <!-- header-top  -->

            <?php include './components/user_header.php'?>
           
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
  

  <!-- Main -->
  <div class="main">
    <div class="card">
      <div class="card-body">
        <i class="fa fa-pen fa-xs edit"></i>
        <table>
          <tbody>
            <tr>
              <td>Name:</td>
              <td><?php echo($_SESSION['name']); ?></td>
            </tr>
            <tr>
              <td>Email:</td>
              <td><?php echo($_SESSION['email']); ?></td>
            </tr>
            <tr>
              <td>Phone:</td>
              <td><?php echo($_SESSION['mobile']); ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <a class="primary-button" href="./userUpdate.php">Update</a>

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