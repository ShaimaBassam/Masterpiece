<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}




if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
   $delete_admins->execute([$delete_id]);
   header('location:dashboard.php');
}




if(isset($_POST['new-admin']) && isset($_POST['password-newadmin'])){

    $name = $_POST['new-admin'];
    $name = htmlspecialchars($name, ENT_QUOTES);
    $pass = sha1($_POST['password-newadmin']);
    $pass = htmlspecialchars($pass, ENT_QUOTES);
    $cpass = sha1($_POST['co-password-newadmin']);
    $cpass = htmlspecialchars($cpass, ENT_QUOTES);
 
    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
    $select_admin->execute([$name]);
     
    if($select_admin->rowCount() > 0){
        $message[] = 'username already exist!';
    }else{
        if($pass != $cpass){
            $message[] = 'confirm password not matched!';
        }else{
            $insert_admin = $conn->prepare("INSERT INTO `admins`(name, password) VALUES(?,?)");
            $insert_admin->execute([$name, $cpass]);
            $message[] = 'new admin registered successfully!';
        }
    }
 
 }



 if(isset($_POST['name']) && isset($_POST['old_pass']) && isset($_POST['new_pass']) && isset($_POST['confirm_pass']) ){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
 
    $update_profile_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
    $update_profile_name->execute([$name, $admin_id]);
 
    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $prev_pass = $_POST['prev_pass'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
 
    if($old_pass == $empty_pass){
       $message[] = 'please enter old password!';
    }elseif($old_pass != $prev_pass){
       $message[] = 'old password not matched!';
    }elseif($new_pass != $confirm_pass){
       $message[] = 'confirm password not matched!';
    }else{
       if($new_pass != $empty_pass){
          $update_admin_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
          $update_admin_pass->execute([$confirm_pass, $admin_id]);
          $message[] = 'password updated successfully!';
       }else{
          $message[] = 'please enter a new password!';
       }
    }
    
 }




?>

<?php 



?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Center Point</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">


    <link rel="icon" type="image/x-icon" href="../assets/logo.png">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/dashboardstyle.css" rel="stylesheet">

    <style>
    <?php include("../css/dashboardstyle.css") ?>

    .fa-bars:before {
        content: "\f0c9";
    }

    .btn-primary {
        background-color: #42246C;
        border-color: #42246C;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 250px;
        height: 100vh;
        overflow-y: auto;
        transition: 0.5s;
        z-index: 999;
    }

    input {
        background-color: #fff !important;
    }

    .bg-secondary {
        background-color: #e8c91a !important;
    }

    .content {
        display: flex;
        flex-direction: row;
    }

    /* Style for category cards */
    .card-container {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
    }

    .card {
        display: flex;
        flex-direction: row;
        align-items: center;
        margin: 20px;
       
    }

    .card img {
        max-width: 100px;
        max-height: 100px;
    }
</style>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark" style="height: 100%;">
                <a href="index.html" class="navbar-brand mx-4 mb-3" style="color:black !important">
                    <img src="../assets/logo.png" style="border-radius: 50%;" width="100px" height="100px" alt="0">
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="ms-3">
                        <h4 class="mb-0">

                        <?php $select_accounts = $conn->prepare("SELECT * FROM `admins` WHERE id = '$admin_id'");
                                $select_accounts->execute();
                                $admin_name = $select_accounts->fetch();
                                echo strtoupper($admin_name['name']);
                        ?>
                        </h4>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="dashboard.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="products.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Products</a>
                    <a href="sold.php" class="nav-item nav-link"><i class="fa-sharp fa-solid fa-store-slash me-2"></i>Sold</a>
                    <a href="sales.php" class="nav-item nav-link"><i class="fa-brands fa-adversal me-2"></i>Sales</a>
                    <a href="category.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Category</a>
                    <a href="orders.php" class="nav-item nav-link"><i class="fa-solid fa-truck me-2"></i>Orders</a>
                    <a href="admin.php" class="nav-item nav-link"><i class="fa-sharp fa-solid fa-user-tie me-2"></i>Admins</a>
                    <a href="users.php" class="nav-item nav-link"><i class="fa-solid fa-user me-2"></i>Users</a>
                    <a href="../components/admin_logout.php" class="nav-item nav-link"><i class="fa-sharp fa-solid fa-right-from-bracket me-2"></i>Logout</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4" style="background-color: #fff !important;">
            <?php
            // Query the database to retrieve categories
            $stmt = $conn->query('SELECT * FROM category');
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Create HTML cards for each category
            $cards_html = '';
            foreach ($categories as $category) {
                $cards_html .= '<div class="card">';
                $cards_html .= '<img src="../uploaded_img/'.$category['image_01'] . '">';
                $cards_html .= '<h2 style="color:black !important;font-size:12px;">' .$category['category_name'] . '</h2>';
                $cards_html .= '</div>';
            }

            // Output the HTML cards
            echo '<div class="card-container">' . $cards_html . '</div>';

            // Display the total number of categories
            $total_categories = count($categories);
            echo 'Total categories: ' . $total_categories;
            ?>
        </div>
    </div>
</div>
<!-- Content End -->

 

<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>