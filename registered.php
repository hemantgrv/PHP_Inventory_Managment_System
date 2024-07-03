<?php
  session_start();

  include("config/dbcon.php");

  // PHPMailer
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';


  if(isset($_POST['registerUser'])) 
  {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $user_query = "INSERT INTO users (name,email,phone,password) VALUES ('$name','$email','$phone','$password')";
    $user_query_run = mysqli_query($conn, $user_query);

    if ($user_query_run) 
    {
       // Create an instance of PHPMailer
       $mail = new PHPMailer(true);

       try {
           // Server settings
          //  $mail->SMTPDebug = SMTP::DEBUG_OFF;                     // Disable verbose debug output
           $mail->isSMTP();                                        // Send using SMTP
           $mail->Host       = 'smtp.gmail.com';                   // Set the SMTP server to send through
           $mail->SMTPAuth   = true;                               // Enable SMTP authentication
           $mail->Username   = 'learninggeeks48@gmail.com';        // SMTP username
           $mail->Password   = 'lgbaarofsgifpisz';                 // SMTP password
           $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable TLS encryption
           $mail->Port       = 587;                                // TCP port to connect to

           // Recipients
           $mail->setFrom('learninggeeks48@gmail.com', 'Learning Geeks');
           $mail->addAddress($email, $name);                       // Add recipient

           // Content
           $mail->isHTML(true);                                    // Set email format to HTML
           $mail->Subject = 'Thanks for Registering';
           $mail->Body    = 'Hi ' . $name . ',<br>Thank you for registering with us.';

           // Send the email
           $mail->send();
           echo "<script>alert('User registered successfully and email sent'); window.location.href='registered.php';</script>";
       } catch (Exception $e) {
           echo "User registered, but the email could not be sent. Mailer Error: {$mail->ErrorInfo}";
       }
   } else {
      echo "<script>alert('User registration failed'); window.location.href = 'register.php';</script>";
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form method="post">
        <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="phone" class="form-control" placeholder="Phone Number">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
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
          <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div> -->
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="registerUser" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>

      <a href="login.php" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
</body>

</html>