<?php
include("config/dbcon.php");

if (isset($_GET['token']) && isset($_GET['email'])) {
    $token = $_GET['token'];
    $email = $_GET['email'];
    $token_hash = hash("sha256", $token);

    $sql = "SELECT * FROM users WHERE email = ? AND reset_token_hash = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $email, $token_hash);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("Invalid token or email.");
    }

    if (strtotime($user['reset_token_expires_at']) <= time()) {
        die("Token has expired.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Reset your password.</p>
      <form action="execute.php" method="post">
      <div class="input-group mb-3">
          <input type="hidden" name="password_token" value="<?php if (isset($_GET['token'])) { echo $_GET['token'];} ?>" class="form-control">
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" value="<?php if (isset($_GET['email'])) { echo $_GET['email'];} ?>" class="form-control" placeholder="Enter your email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Create new password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="cpassword" class="form-control" placeholder="Confirm your password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="passwordUpdate" class="btn btn-primary btn-block">Change password</button>
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