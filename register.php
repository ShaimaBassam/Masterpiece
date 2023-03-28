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
    <title>Register</title>
</head>
<body>
    
<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card text-white" style="border-radius: 1rem;background-color:#453c5c;">
          <div class="card-body p-5 text-center">
          <form action="" method="post">
            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Register</h2>

              <div class="form-outline form-white mb-4">
              <label class="form-label" for="typeNameX">Name</label>
                <input type="text" id="typeNameX" class="form-control form-control-lg" name="name" required placeholder="Enter your name" maxlength="20"/>
              </div>

              <div class="form-outline form-white mb-4">
              <label class="form-label" for="typeEmailX">Email</label>
                <input type="email" id="typeEmailX" class="form-control form-control-lg" name="email" required placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')"/>
              </div>

              <div class="form-outline form-white mb-4">
              <label class="form-label" for="typePasswordX">Password</label>
                <input type="password" id="typePasswordX" class="form-control form-control-lg" name="pass" required placeholder="Enter your password" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
              </div>

              <div class="form-outline form-white mb-4">
              <label class="form-label" for="typeCPasswordX">Confirm Password</label>
                <input type="password" id="typeCPasswordX" class="form-control form-control-lg"  name="cpass" required placeholder="Confirm your password" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
              </div>

              <div class="form-outline form-white mb-4">
              <label class="form-label" for="typePhoneX">Phone Number:</label>
                <input type="text" id="typePhoneX" class="form-control form-control-lg"  name="mobile" required placeholder="Enter your number" maxlength="20"/>
              </div>

              <button class="btn btn-outline-light btn-lg px-5" type="submit"  name="submit">Register</button>
            </div>

            <div>
              <p class="mb-0">Already registered?<a href="./login.php" class="text-white-50 fw-bold">Login</a>
              </p>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>