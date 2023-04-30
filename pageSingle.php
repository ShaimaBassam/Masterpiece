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
    <div id="page" class="site page-single">
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
                <!-- <div class="container">
                    <div class="wrapper flexitem">
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
                    </div>
                </div> -->
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
                                        <li class="has-child Seller">
                                            <a href="#">
                                                <div class="icon-large"><i class="ri-shield-star-line"></i></div>
                                                Best Seller
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
                    <div class="breadcrumb">
                        <ul class="flexitem">
                            <li><a href="./index.html">Home</a></li>
                            <li><a href="#">Women's</a></li>
                            <li><a href="#">Men Slip</a></li>
                        </ul>
                    </div>
                    <!-- breadcrumb -->
                    <div class="column">
                        <div class="products one">
                            <div class="flexwrap">
                                <div class="row">
                                    <div class="item is_sticky">
                                        <div class="price">
                                            <span class="discount">25%<br>OFF</span>
                                        </div>
                                        <div class="big-image">
                                            <div class="big-image-wrapper swiper-wrapper">
                                                <div class="image-show swiper-slide">
                                                    <a data-fslightbox href="assets/products/p5.png"><img src="assets/products/p5.png" alt=""></a>
                                                </div>
                                                <div class="image-show swiper-slide">
                                                    <a data-fslightbox href="assets/products/p5-1.png"><img src="assets/products/p5-1.png" alt=""></a>
                                                </div>
                                                <div class="image-show swiper-slide">
                                                    <a data-fslightbox href="assets/products/p5-2.png"><img src="assets/products/p5-2.png" alt=""></a>
                                                </div>
                                                <div class="image-show swiper-slide">
                                                    <a data-fslightbox href="assets/products/p5-3.png"><img src="assets/products/p5-3.png" alt=""></a>
                                                </div>
                                                <div class="image-show swiper-slide">
                                                    <a data-fslightbox href="assets/products/p5-4.png"><img src="assets/products/p5-4.png" alt=""></a>
                                                </div>
                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>

                                        <div thumbSlider="" class="small-image">
                                            <ul class="small-image-wrapper flexitem swiper-wrapper">
                                                 <li class="thumbnail-show swiper-slide">
                                                    <img src="assets/products/p5-1.png" alt="">
                                                 </li>
                                                 <li class="thumbnail-show swiper-slide">
                                                    <img src="assets/products/p5-2.png" alt="">
                                                 </li>
                                                 <li class="thumbnail-show swiper-slide">
                                                    <img src="assets/products/p5-3.png" alt="">
                                                 </li>
                                                 <li class="thumbnail-show swiper-slide">
                                                    <img src="assets/products/p5-4.png" alt="">
                                                 </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="item">
                                        <h1>OVERSIZE HOODIE</h1>
                                        <div class="content">
                                            <div class="rating">
                                                <div class="stars"></div>
                                                <a href="#" class="mini-text">2,524 reviews</a>
                                                <a href="" class="add-review mini-text">Add Your Review</a>
                                            </div>
                                            <div class="stock-sku">
                                                <span class="available">In Stock</span>
                                                <span class="sku mini-text">SKU-881</span>
                                            </div>
                                            <div class="price">
                                                <span class="current">19 JD</span>
                                                <span class="normal">29 JD</span>
                                            </div>
                                            <div class="colors">
                                                <p>Color</p>
                                                <div class="variant">
                                                    <form action="">
                                                        <P>
                                                            <input type="radio" name="color" id="cogrey">
                                                            <label for="cogrey" class="circle"></label>
                                                        </P>
                                                        <P>
                                                            <input type="radio" name="color" id="coblue">
                                                            <label for="coblue" class="circle"></label>
                                                        </P>
                                                        <P>
                                                            <input type="radio" name="color" id="cogreen">
                                                            <label for="cogreen" class="circle"></label>
                                                        </P>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="sizes">
                                                <p>Size</p>
                                                <div class="variant">
                                                    <form action="">
                                                        <P>
                                                            <input type="radio" name="size" id="size-40">
                                                            <label for="size-40" class="circle"><span>40</span></label>
                                                        </P>
                                                        <P>
                                                            <input type="radio" name="size" id="size-41">
                                                            <label for="size-41" class="circle"><span>41</span></label>
                                                        </P>
                                                        <P>
                                                            <input type="radio" name="size" id="size-42">
                                                            <label for="size-42" class="circle"><span>42</span></label>
                                                        </P>
                                                        <P>
                                                            <input type="radio" name="size" id="size-43">
                                                            <label for="size-43" class="circle"><span>43</span></label>
                                                        </P>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="actions">
                                                <div class="qty-control flexitem">
                                                    <button class="minus circle">-</button>
                                                    <input type="text" value="1">
                                                    <button class="plus circle">+</button>
                                                </div>
                                                <div class="button-cart">
                                                    <button class="primary-button">Add to cart</button>
                                                </div>
                                                <div class="wish-share">
                                                    <ul class="flexitem second-links">
                                                        <li><a href="#">
                                                            <span class="icon-large"><i class="ri-heart-line"></i></span>
                                                            <span>Wishlist</span>
                                                        </a></li>
                                                        <li><a href="#">
                                                            <span class="icon-large"><i class="ri-share-line"></i></span>
                                                            <span>Share</span>
                                                        </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="description collapse">
                                                <ul>
                                                    <li class="has-child expand">
                                                        <a href="#0" class="icon-small">Information</a>
                                                        <ul class="content">
                                                            <li><span>Brands</span>Zara</li>
                                                            <li><span>Activity</span>Running</li>
                                                            <li><span>Material</span>70% cotton · 30% polyester
                                                                SECONDARY FABRIC
                                                                97% cotton · 3% elastane</li>
                                                            <li><span>Gender</span>Woman</li>
                                                        </ul>
                                                    </li>
                                                    <li class="has-child">
                                                        <a href="#0" class="icon-small">Details</a>
                                                        <div class="content">
                                                            <p>To assess compliance, we have developed a programme of audits and continuous improvement plans.</p>
                                                            <p>Lower temperature washes and delicate spin cycles are gentler on garments and help to protect the colour, shape and structure of the fabric. Furthermore, they reduce the amount of energy used in care processes.</p>
                                                        </div>
                                                    </li>
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
                                                    <li class="has-child">
                                                        <a href="#" class="icon-small">Reviews<span class="mini-text">5.7k</span></a>
                                                        <div class="content">
                                                            <div class="reviews">
                                                                <h4>Customers Reviews</h4>
                                                                <div class="review-block">
                                                                    <div class="review-block-head">
                                                                        <div class="flexitem">
                                                                            <span class="rate-sum">4.9</span>
                                                                            <span>5,500 Reviews</span>
                                                                        </div>
                                                                        <a href="#review-form" class="secondary-button">Write Review</a>
                                                                    </div>
                                                                    <div class="review-block-body">
                                                                        <ul>
                                                                            <li class="item">
                                                                                <div class="review-form">
                                                                                    <p class="person">Review by Tala</p>
                                                                                    <p class="mini-text">On 3/3/23</p>
                                                                                </div>
                                                                                <div class="review-rating rating">
                                                                                    <div class="stars"></div>
                                                                                </div>
                                                                                <div class="review-title">
                                                                                    <p>Awesome product!</p>
                                                                                </div>
                                                                                <div class="review-text">
                                                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse error debitis asperiores minima tempora laborum soluta labore earum temporibus quod doloribus quia, modi saepe distinctio, sint nulla mollitia quaerat unde!                                                        </p>
                                                                                </div>
                                                                            </li>
                                                                            <li class="item">
                                                                                <div class="review-form">
                                                                                    <p class="person">Review by Tala</p>
                                                                                    <p class="mini-text">On 3/3/23</p>
                                                                                </div>
                                                                                <div class="review-rating rating">
                                                                                    <div class="stars"></div>
                                                                                </div>
                                                                                <div class="review-title">
                                                                                    <p>Awesome product!</p>
                                                                                </div>
                                                                                <div class="review-text">
                                                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse error debitis asperiores minima tempora laborum soluta labore earum temporibus quod doloribus quia, modi saepe distinctio, sint nulla mollitia quaerat unde!                                                        </p>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                        <div class="second-links">
                                                                            <a href="#" class="view-all">View all reviews 
                                                                                <i class="ri-arrow-right-line"></i> 
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div id="review-form" class="review-form">
                                                                        <h4>Write a review</h4>
                                                                        <div class="rating">
                                                                            <p>Are you satisfied enough?</p>
                                                                            <div class="rate-this">
                                                                                <input type="radio" name="rating" id="star5">
                                                                                <label for="star5"><i class="ri-star-fill"></i></label>

                                                                                <input type="radio" name="rating" id="star4">
                                                                                <label for="star4"><i class="ri-star-fill"></i></label>

                                                                                <input type="radio" name="rating" id="star3">
                                                                                <label for="star3"><i class="ri-star-fill"></i></label>

                                                                                <input type="radio" name="rating" id="star2">
                                                                                <label for="star2"><i class="ri-star-fill"></i></label>

                                                                                <input type="radio" name="rating" id="star1">
                                                                                <label for="star1"><i class="ri-star-fill"></i></label>
                                                                            </div>
                                                                        </div>
                                                                        <form action="">
                                                                            <p>
                                                                                <label>Name</label>
                                                                                <input type="text">
                                                                            </p>
                                                                            <p>
                                                                                <label>Summary</label>
                                                                                <input type="text">
                                                                            </p>
                                                                            <p>
                                                                                <label>Review</label>
                                                                                <textarea  cols="30" rows="10"></textarea>
                                                                            </p>
                                                                            <p><a href="#" class="primary-button">Submit Review</a></p>
                                                                        </form>
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

         <div class="features">
            <div class="container">
                <div class="wrapper">
                    <div class="column">
                        <div class="sectop flexitem">
                            <h2><span class="circle"></span> <span>Related Products</span></h2>
                            <div class="second-links">
                                <a href="#" class="view-all">View All<i class="ri-arrow-right-line"></i></a>
                            </div>
                        </div>
                        <div class="products main flexwrap">
                            <div class="item">
                                <div class="media">
                                    <div class="thumbnail object-cover">
                                        <a href="#">
                                            <img src="assets/products/EYE SHADOW PALETTE.png" alt="">
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
                                    <h3 class="main-links"><a href="#">EYE SHADOW PALETTE</a></h3>
                                    <div class="price">
                                        <span class="current"> 16.99 JD</span>
                                        <span class="normal mini-text"> 12 JD</span>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="media">
                                    <div class="thumbnail object-cover">
                                        <a href="#">
                                            <img src="assets/products/LUMINOUS CREAMY CONCEALER.png" alt="">
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
                                    <h3 class="main-links"><a href="#">LUMINOUS CREAMY CONCEALER</a></h3>
                                    <div class="price">
                                        <span class="current"> 126.99 JD</span>
                                        <span class="normal mini-text"> 189 JD</span>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="media">
                                    <div class="thumbnail object-cover">
                                        <a href="#">
                                            <img src="assets/products/ULTIMATTE MATTE LIQUID LIPSTICK.png" alt="">
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
                                    <h3 class="main-links"><a href="#">ULTIMATTE MATTE LIQUID LIPSTICK</a></h3>
                                    <div class="price">
                                        <span class="current"> 126.99 JD</span>
                                        <span class="normal mini-text"> 189 JD</span>
                                    </div>
                                    <div class="footer">
                                        <ul class="mini-text">
                                            <li>Polyster, Cotton</li>
                                            <li>Pull On Closure</li>
                                            <li>Fashion Personality</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="media">
                                    <div class="thumbnail object-cover">
                                        <a href="#">
                                            <img src="assets/products/QUARTZ VEIL LIQUID EYESHADOW.png" alt="">
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
                                    <h3 class="main-links"><a href="#">UARTZ VEIL LIQUID EYESHADOW</a></h3>
                                    <div class="price">
                                        <span class="current"> 126.99 JD</span>
                                        <span class="normal mini-text"> 189 JD</span>
                                    </div>
                                    <div class="footer">
                                        <ul class="mini-text">
                                            <li>Polyster, Cotton</li>
                                            <li>Pull On Closure</li>
                                            <li>Fashion Personality</li>
                                        </ul>
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
                                        <span class="mini-text">(2,548)</span>
                                    </div>
                                    <h3 class="main-links"><a href="#">UARTZ VEIL LIQUID EYESHADOW</a></h3>
                                    <div class="price">
                                        <span class="current"> 126.99 JD</span>
                                        <span class="normal mini-text"> 189 JD</span>
                                    </div>
                                    <div class="footer">
                                        <ul class="mini-text">
                                            <li>Polyster, Cotton</li>
                                            <li>Pull On Closure</li>
                                            <li>Fashion Personality</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="media">
                                    <div class="thumbnail object-cover">
                                        <a href="#">
                                            <img src="assets/products/spela.png" alt="">
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
                                    <h3 class="main-links"><a href="#">spela</a></h3>
                                    <div class="price">
                                        <span class="current"> 126.99 JD</span>
                                        <span class="normal mini-text"> 189 JD</span>
                                    </div>
                                    <div class="footer">
                                        <ul class="mini-text">
                                            <li>Polyster, Cotton</li>
                                            <li>Pull On Closure</li>
                                            <li>Fashion Personality</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="media">
                                    <div class="thumbnail object-cover">
                                        <a href="#">
                                            <img src="assets/products/THE LINE-UP REFILLABLE AUTOMATIC EYELINER.png" alt="">
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
                                    <h3 class="main-links"><a href="#">spela</a></h3>
                                    <div class="price">
                                        <span class="current"> 126.99 JD</span>
                                        <span class="normal mini-text"> 189 JD</span>
                                    </div>
                                    <div class="footer">
                                        <ul class="mini-text">
                                            <li>Polyster, Cotton</li>
                                            <li>Pull On Closure</li>
                                            <li>Fashion Personality</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Featured products  -->
        <div class="banners">
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
                        
                            <!-- banners -->
                            <div class="product-categories flexwrap">
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