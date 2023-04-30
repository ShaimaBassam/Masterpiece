<?php
include './components/connect.php';
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
                    <!-- <div class="wrapper flexitem">
                        <div class="left">
                            <ul class="flexitem main-links">
                                <li><a href="#"></a>Wishlist</li>
                                <li><a href="#"></a>Order Tracking</li>
                            </ul>
                        </div>
                        <div class="right">
                            <ul class="flexitem main-links">
                                <li><a href="#"></a>Sign Up</li>
                                <li><a href="#"></a>My Account</li>
                                <li><a href="#">English</a></li>
                                <li><a href="#">JOD</a></li>
                            </ul>
                        </div>
                    </div> -->
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
                            <form action="" class="form-cart">
                                <div class="item">
                                    <table id="cart-table">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Price</th>
                                                <th>QTY</th>
                                                <th>Subtotal</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="flexitem">
                                                    <div class="thumbnail object-cover">
                                                        <a href="#"><img src="assets/products/QUARTZ VEIL LIQUID EYESHADOW.png" alt=""></a>
                                                    </div>
                                                    <div class="content">
                                                        <strong><a href="#">QUARTZ VEIL LIQUID EYESHADOW</a></strong>
                                                        <p>Color: Pink</p>
                                                    </div>
                                                </td>
                                                <td>9.55 JD</td>
                                                <td>
                                                    <div class="qty-control flexitem">
                                                        <button class="minus">-</button>
                                                        <input type="text" value="2" min="1">
                                                        <button class="plus">+</button>
                                                    </div>
                                                </td>
                                                <td>19.10 JD</td>
                                                <td><a href="#" class="item-remove"><i class="ri-close-line"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td class="flexitem">
                                                    <div class="thumbnail object-cover">
                                                        <a href="#"><img src="assets/products/BEADED SHOULDER BAG.png" alt=""></a>
                                                    </div>
                                                    <div class="content">
                                                        <strong><a href="#">BEADED SHOULDER BAG</a></strong>
                                                        <p>Color: Black</p>
                                                    </div>
                                                </td>
                                                <td>25.99 JD</td>
                                                <td>
                                                    <div class="qty-control flexitem">
                                                        <button class="minus">-</button>
                                                        <input type="text" value="2" min="1">
                                                        <button class="plus">+</button>
                                                    </div>
                                                </td>
                                                <td>51.98 JD</td>
                                                <td><a href="#" class="item-remove"><i class="ri-close-line"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td class="flexitem">
                                                    <div class="thumbnail object-cover">
                                                        <a href="#"><img src="assets/products/EYE SHADOW PALETTE.png" alt=""></a>
                                                    </div>
                                                    <div class="content">
                                                        <strong><a href="#">EYE SHADOW PALETTE</a></strong>
                                                        <p>Color: Pink</p>
                                                    </div>
                                                </td>
                                                <td>9.55 JD</td>
                                                <td>
                                                    <div class="qty-control flexitem">
                                                        <button class="minus">-</button>
                                                        <input type="text" value="2" min="1">
                                                        <button class="plus">+</button>
                                                    </div>
                                                </td>
                                                <td>19.10 JD</td>
                                                <td><a href="#" class="item-remove"><i class="ri-close-line"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td class="flexitem">
                                                    <div class="thumbnail object-cover">
                                                        <a href="#"><img src="assets/products/EYEBROW PENCIL.png" alt=""></a>
                                                    </div>
                                                    <div class="content">
                                                        <strong><a href="#">EYEBROW PENCIL</a></strong>
                                                        <p>Color: Brown</p>
                                                    </div>
                                                </td>
                                                <td>5.20 JD</td>
                                                <td>
                                                    <div class="qty-control flexitem">
                                                        <button class="minus">-</button>
                                                        <input type="text" value="2" min="1">
                                                        <button class="plus">+</button>
                                                    </div>
                                                </td>
                                                <td>10.40 JD</td>
                                                <td><a href="#" class="item-remove"><i class="ri-close-line"></i></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                </div>

                            </form>
                            <div class="cart-summary styled">
                                    
                                    <div class="cart-total">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <th>Subtotal</th>
                                                        <td>105.35 JD</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Delivery </th>
                                                        <td>10.00 JD</td>
                                                    </tr>
                                                    <tr class="grand-totaal">
                                                        <th>Total</th>
                                                        <td><strong>110.35 JD</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <a href="./checkout.html" class="primary-button">Checkout</a>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>

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