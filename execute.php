<?php
session_start();

include("config/dbcon.php");

if(isset($_POST['addUser'])) 
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $user_query = "INSERT INTO users (name,email,phone,password) VALUES ('$name','$email','$phone','$password')";
    $user_query_run = mysqli_query($conn, $user_query);

    if ($user_query_run) 
    {
        $_SESSION['status'] = "User added successfully";
        header("Location: admin.php");
    }
    else 
    {
        $_SESSION['status'] = "User registration failed";
        header("Location: admin.php");
    }
}

// Adding Products

if(isset($_POST['addProduct'])) {
    $product_name = $_POST['product_name'];
    $qty = $_POST['qty'];
    $qty_type = $_POST['qty_type'];
    $added_by_user = $_SESSION['name'];

    $query = "INSERT INTO products (product_name, qty, qty_type, added_by_user) VALUES ('$product_name', '$qty', '$qty_type', '$added_by_user')";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        echo "<script>alert('Product Added successfully'); window.location.href='product.php';</script>";

    } else {
        echo "<script>alert('Product Not Added'); window.location.href='product.php';</script>";
    }
}


if(isset($_POST['registerUser'])) 
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $user_query = "INSERT INTO users (name,email,phone,password) VALUES ('$name','$email','$phone','$password')";
    $user_query_run = mysqli_query($conn, $user_query);

    if ($user_query) 
    {
        echo "<script>alert('User registered successfully'); window.location.href='registered.php';</script>";
    }
    else 
    {
        echo "<script>alert('User registration failed'); window.location.href='registered.php';</script>";
    }
}


// Updating Users
if (isset($_POST['updateUser'])) 
{
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $query = "UPDATE users SET name='$name', email='$email', phone='$phone', password='$password' WHERE id='$user_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) 
    {
        echo "<script>alert('User updated successfully'); window.location.href='admin.php';</script>";
    }
    else 
    {
        echo "<script>alert('User updating failed'); window.location.href='admin.php';</script>";
    }
}

// Updating Products
if(isset($_POST['updateProduct'])) {
    $product_id = $_POST['product_id'];
    // $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $qty = $_POST['qty'];
    $qty_type = $_POST['qty_type'];

    $query = "UPDATE products SET product_name='$product_name', qty='$qty', qty_type='$qty_type' WHERE id='$product_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        echo "<script>alert('Product updated successfully'); window.location.href='product.php';</script>";
    } else {
        echo "<script>alert('Product updated Failed'); window.location.href='product.php';</script>";  
    }
}

// Deleting the users
if (isset($_POST['deleteBtn'])) {
    $user_id = $_POST['delete_id'];

    $query = "UPDATE users SET del_flag = '1' WHERE id = '$user_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['status'] = "User deleted successfully";
        header("Location: admin.php");
    } else {
        $_SESSION['status'] = "User deletion failed";
        header("Location: admin.php");
    }
}


// Deleting the products
if(isset($_POST['deleteProduct'])) {
    $product_id = $_POST['delete_id'];

    $query = "UPDATE products SET del_flag = '1' WHERE id = '$product_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        $_SESSION['status'] = "Product deleted successfully";
        header("Location: product.php");
    } else {
        $_SESSION['status'] = "Product deletion failed";
        header("Location: product.php");
    }
}


// Deleting the daily products
if(isset($_POST['DelDailyProduct'])) {
    $product_id = $_POST['delete_id'];

    $query = "UPDATE dailyproducts SET del_flag = '1' WHERE id = '$product_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        $_SESSION['status'] = "Daily Product deleted successfully";
        header("Location: daily.php");
    } else {
        $_SESSION['status'] = "Daily Product deletion failed";
        header("Location: daily.php");
    }
}

if (isset($_POST['changePassword'])) 
{
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    $query = "UPDATE users SET password='$password' WHERE id='$user_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) 
    {
        echo "<script>alert('Password Changed successfully'); window.location.href='admin.php';</script>";
    }
    else 
    {
        echo "<script>alert('Change Password failed'); window.location.href='admin.php';</script>";
    }
}

// Password Update
if (isset($_POST['passwordUpdate'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $token = mysqli_real_escape_string($conn, $_POST['password_token']);
    $token_hash = hash("sha256", $token);

    if (!empty($token) && !empty($email) && !empty($new_password) && !empty($confirm_password)) {
        // Checking if the token is valid
        $check_token = "SELECT reset_token_hash, reset_token_expires_at FROM users WHERE email = ? AND reset_token_hash = ? LIMIT 1";
        $stmt = $conn->prepare($check_token);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("ss", $email, $token_hash);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && strtotime($user['reset_token_expires_at']) > time()) {
            if ($new_password == $confirm_password) {
                $update_password = "UPDATE users SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE email = ? AND reset_token_hash = ? LIMIT 1";
                $stmt = $conn->prepare($update_password);
                if ($stmt === false) {
                    die("Error preparing statement: " . $conn->error);
                }
                $stmt->bind_param("sss", $new_password, $email, $token_hash);
                $update_password_run = $stmt->execute();

                if ($update_password_run) {
                    echo "<script>alert('New Password Successfully Updated!'); window.location.href='login.php';</script>";
                } else {
                    echo "<script>alert('Did Not Update the Password. Something Went Wrong!'); window.location.href='reset-password.php?token=$token&email=$email';</script>";
                }
            } else {
                echo "<script>alert('Password and Confirm Password do not match'); window.location.href='reset-password.php?token=$token&email=$email';</script>";
            }
        } else {
            echo "<script>alert('Invalid or expired token'); window.location.href='reset-password.php?token=$token&email=$email';</script>";
        }
    } else {
        echo "<script>alert('All fields are mandatory'); window.location.href='reset-password.php?token=$token&email=$email';</script>";
    }
}


// Daily ADD OR UPDATE Products
// if (isset($_POST['id'])) {
//     $product_id = $_POST['product_id'];
//     $qty = $_POST['qty'];

//     // Check if the product already exists in the DailyProducts table
//     $check_query = "SELECT * FROM dailyproducts WHERE id = ?";
//     $stmt = $conn->prepare($check_query);
//     $stmt->bind_param("i", $product_id);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         // Product already exists, update the quantity
//         $update_query = "UPDATE dailyproducts SET qty = ?, del_flag = 0, modified_at = NOW() WHERE id = ?";
//         $update_stmt = $conn->prepare($update_query);
//         $update_stmt->bind_param("ii", $qty, $product_id);
//         $update_stmt->execute();
//     } else {
//         // Product does not exist, insert it
//         $select_query = "SELECT * FROM products WHERE id = ?";
//         $select_stmt = $conn->prepare($select_query);
//         $select_stmt->bind_param("i", $product_id);
//         $select_stmt->execute();
//         $product = $select_stmt->get_result()->fetch_assoc();

//         $insert_query = "INSERT INTO dailyproducts (id, product_name, qty, qty_type, created_at, modified_at, added_by_user) VALUES (?, ?, ?, ?, NOW(), NOW(), ?)";
//         $insert_stmt = $conn->prepare($insert_query);
//         $insert_stmt->bind_param(
//             "isiss",
//             $product['id'],
//             $product['product_name'],
//             $qty,
//             $product['qty_type'],
//             $product['added_by_user']
//         );
//         $insert_stmt->execute();
//     }

//     echo "Product added/updated successfully.";
// } else {
//     echo "Product ID not provided.";
// }


// // Del flag 
// if (isset($_POST['id']) && isset($_POST['del_flag'])) {
//     $product_id = $_POST['product_id'];
//     $del_flag = $_POST['del_flag'];

//     $update_query = "UPDATE DailyProducts SET del_flag = ? WHERE id = ?";
//     $stmt = $conn->prepare($update_query);
//     $stmt->bind_param("ii", $del_flag, $product_id);
//     $stmt->execute();

//     echo "Delete flag updated successfully.";
// } else {
//     echo "Product ID or delete flag not provided.";
// }

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Get current date and time
     
//     $current_datetime = date('j F Y');

//     // Loop through selected products
//     if (isset($_POST['selected_products']) && !empty($_POST['selected_products'])) {
//         foreach ($_POST['selected_products'] as $product_id) {
//             // Assuming qty inputs are named as 'qty_<product_id>'
//             $qty = $_POST['qty_' . $product_id];

//             // Check if the product entry already exists in dailyproducts
//             $check_query = "SELECT * FROM dailyproducts WHERE daily_id = $product_id";
//             $check_result = mysqli_query($conn, $check_query);

//             if (mysqli_num_rows($check_result) > 0) {
//                 // Update existing record
//                 $update_query = "UPDATE dailyproducts SET qty = $qty, modified_at = '$current_datetime' WHERE daily_id = $product_id";
//                 mysqli_query($conn, $update_query);
//             } else {
//                 // Insert new record
//                 $insert_query = "INSERT INTO dailyproducts (daily_id, product_name, qty, qty_type, created_at, modified_at, added_by_user) 
//                                 SELECT id, product_name, $qty, qty_type, '$current_datetime', '$current_datetime', added_by_user FROM products WHERE id = $product_id";
//                 mysqli_query($conn, $insert_query);
//             }
//         }

//         echo "Products updated successfully!";
//     } else {
//         echo "No products selected!";
//     }
// } else {
//     echo "Invalid request!";
// }

?>