<?php

include './components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email =  htmlspecialchars($email, ENT_QUOTES);
   $pass = sha1($_POST['pass']);
   $pass = htmlspecialchars($pass, ENT_QUOTES);


   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['name']= $row['name'];
      $_SESSION['mobile']= $row['mobile'];
      header('location:home.php');

   }else{
      $message[] = '<span style="color:red">Incorrect</span> Email Or Password!';
   }

}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="./assets/logo.png">

    <title>Login</title>
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

              <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
              <p class="text-white-50 mb-5">Please enter your Email and password!</p>

              <div class="form-outline form-white mb-4">
              <label class="form-label" for="typeEmailX">Email</label>
                <input type="email" id="typeEmailX" class="form-control form-control-lg" name="email" required placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')"/>
              </div>

              <div class="form-outline form-white mb-4">
              <label class="form-label" for="typePasswordX">Password</label>
                <input type="password" id="typePasswordX" class="form-control form-control-lg" name="pass" required placeholder="Enter your password" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')"/>
              </div>


              <button class="btn btn-outline-light btn-lg px-5" type="submit"  name="submit">Login</button>
            </div>

            <div>
              <p class="mb-0">Don't have an account? <a href="./register.php" class="text-white-50 fw-bold">Sign Up</a>
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