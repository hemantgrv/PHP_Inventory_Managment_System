<?php
include("config/dbcon.php"); // Ensure this file correctly sets up $conn

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['forgotPassword'])) {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        // Check if the email exists
        $stmt = $conn->prepare("SELECT id, name FROM users WHERE email = ?");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $name);
            $stmt->fetch();

            // Generate a unique token
            $token = md5(rand());
            $token_hash = hash("sha256", $token);

            $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

            $sql = "UPDATE users 
                    SET reset_token_hash = ?, reset_token_expires_at = ?
                    WHERE email = ?";

            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $conn->error);
            }
            $stmt->bind_param("sss", $token_hash, $expiry, $email);
            $stmt->execute();

            // Send the email
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'learninggeeks48@gmail.com';
                $mail->Password = 'lgbaarofsgifpisz';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('learninggeeks48@gmail.com', 'Learning Geeks');
                $mail->addAddress($email, $name);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "Hi $name,<br><br>Click the link below to reset your password:<br><a href='http://localhost/admin/reset-password.php?token=$token&email=$email'>Reset Password</a><br><br>This link will expire in 30 minutes.";

                $mail->send();
                echo "<script>alert('A password reset link has been sent to your email.'); window.location.href='forgot-password.php';</script>";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "<script>alert('No user found with this email.'); window.location.href = 'register.php';</script>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Email field is required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      <form method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="forgotPassword" class="btn btn-primary btn-block">Request new password</button>
          </div>
        </div>
      </form>
      <p class="mt-3 mb-1">
        <a href="login.php">Login</a>
      </p>
    </div>
  </div>
</div>
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
