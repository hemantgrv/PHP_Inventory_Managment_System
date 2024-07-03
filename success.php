<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Page</title>
</head>
<body>

<h1>Success Page</h1>
<?php 
if (isset($_SESSION['name'], $_SESSION['email'])) {
    echo "<h2>Welcome " . htmlspecialchars($_SESSION['name']) . ". Your email id is " . htmlspecialchars($_SESSION['email']) . "</h2>";
?>
    <h3><a href="logout.php">Logout</a></h3>
<?php 
} else {
?>
    <h3>Click here to <a href="login.php">Login</a></h3>
<?php 
}
?>

</body>
</html>
