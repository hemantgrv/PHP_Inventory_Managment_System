<?php
session_start();

require 'config/dbcon.php';

$email = $password = $err_msg = "";
$remember = "";

    if(isset($_POST['loginUser'])) 
    {    
        $email = $_POST["email"];
        $password = $_POST["password"];
        if (isset($_POST['remember'])) {
          $remember = $_POST['remember'];
        }

        $sql = "SELECT * FROM users WHERE email = '$email' and password = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) 
        {
          $row = mysqli_fetch_array($result);
          $_SESSION['name'] = $row['name'];
          $_SESSION['email'] = $email;
            if (isset($_POST['remember'])) 
            {
              $remember = $_POST['remember'];
              setcookie ("remember_email",$email,time() + 3600*24*365);
              setcookie ("remember",$remember,time() + 3600*24*365);
            } 
            else { 
              setcookie ("remember_email","",time() - 36000);
              setcookie ("remember","",time() - 3600);
            }
            // header("Location: admin.php");
            echo "<script>window.location.href='admin.php'; alert('User Login successfully');</script>";
        } 
        else 
        { 
          $err_msg = "Incorrect Email ID / Password";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form method="post" autocomplete="off">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" id="email" 
          value="<?php if (!empty($email)) { echo $email; } elseif(isset($_COOKIE["remember_email"])){ echo $_COOKIE["remember_email"];}?>" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <input type="checkbox" name="remember" class="check" <?php if(!empty($remember)) {?> checked <?php } elseif(isset($_COOKIE["remember"])) { ?> checked <?php } ?>>
              <label for="remember">
                Remember Me
              </label>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="loginUser" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-username.php">I forgot my username</a>
      </p>
      <p class="mb-1">
        <a href="forgot-password.php">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="registered.php" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>

