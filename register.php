<?php

include './components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = htmlspecialchars($name, ENT_QUOTES);
   $email = $_POST['email'];
   $email = htmlspecialchars($email, ENT_QUOTES);
   $pass = sha1($_POST['pass']);
   $pass =htmlspecialchars($pass, ENT_QUOTES);
   $cpass = sha1($_POST['cpass']);
   $cpass = htmlspecialchars($cpass, ENT_QUOTES);
   $mobile = $_POST['mobile'];

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'Email <span style="color:red">Already</span> Exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'Confirm Password <span style="color:red">Not Matched</span>!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password, mobile) VALUES(?,?,?,?)");
         $insert_user->execute([$name, $email, $cpass, $mobile]);
         $message[] = 'Registered <span style="color:green">Successfully</span>, Login Now Please!';
         header("Location: http://localhost/masterpiece/login.php");
      }
   }

//    $select_user_for_cart = $conn->prepare("SELECT * FROM `users` ORDER BY user_id DESC LIMIT 1");
//    $select_user_for_cart->execute();
//    if($select_user_for_cart->rowCount()>0){
//       while($fetch_select_user_for_cart = $select_user_for_cart->fetch(PDO::FETCH_ASSOC)){
//          $user_id = $fetch_select_user_for_cart['user_id'];
//          $cart_array = $_SESSION['cart'];
//          for( $i = 0 ; $i < count($cart_array) ; $i++){
//             $sql = $conn->prepare("INSERT INTO cart (user_id , product_id , name , price , image , quantity)
//                                     VALUES (?,?,?,?,?,?)");
//             $sql->execute([$user_id , $cart_array[$i][0],$cart_array[$i][1],$cart_array[$i][2],$cart_array[$i][3],$cart_array[$i][4]]);
//          }
//          $fav_array = $_SESSION['cart'];
//          for( $i = 0 ; $i < count($fav_array) ; $i++){
//             $stm = $conn->prepare("INSERT INTO favorite (user_id , product_id)
//                                     VALUES (?,?)");
//             $stm->execute([$user_id , $fav_array[$i][0]]);
//          }
//       }
//    }

//    $_SESSION['cart']=[];
//    $_SESSION['fav']=[];

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    
<!-- Section: Design Block -->
<section class="">
  <!-- Jumbotron -->
  <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
    <div class="container">
      <div class="row gx-lg-5 align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h1 class="my-5 display-3 fw-bold ls-tight">
            The best offer <br />
            <span class="text-primary">for your business</span>
          </h1>
          <p style="color: hsl(217, 10%, 50.8%)">
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Eveniet, itaque accusantium odio, soluta, corrupti aliquam
            quibusdam tempora at cupiditate quis eum maiores libero
            veritatis? Dicta facilis sint aliquid ipsum atque?
          </p>
        </div>

        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="card">
            <div class="card-body py-5 px-md-5">

              <form action="" method="post">
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row">
                  <div class="form-outline mb-4">
                    <div class="form-outline">

                    <label class="form-label" for="form3Example1">Name:</label>
                      <input type="text" id="form3Example1" class="form-control" name="name" required placeholder="Enter your name" maxlength="20"/>
                    </div>
                  </div>
                

                <!-- Email input -->
                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example2" >Email:</label>
                  <input type="email" id="form3Example2" class="form-control" name="email" required placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" />
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example3" >Password:</label>
                  <input type="password" id="form3Example3" class="form-control" name="pass" required placeholder="Enter your password" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')" />
                </div>

                 <!-- Confirm Password input -->
                 <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example4" >Confirm Password:</label>
                  <input type="password" id="form3Example4" class="form-control" name="cpass" required placeholder="Confirm your password" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')" />
                </div>

                <!-- Mobile input -->
                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example5">Phone Number:</label>
                  <input type="text" id="form3Example5" class="form-control" name="mobile" required placeholder="Enter your number" maxlength="20"/>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-4 " name="submit">
                  Sign Up
                </button>

                <!-- Register buttons -->
                <div class="text-center">
                 <a href="./login.php"><p>Do You Have Account?Login.</p></a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Jumbotron -->
</section>
<!-- Section: Design Block -->
</body>
</html>