<?php

$conn = mysqli_connect("localhost", "root", "", "dashboard") or die("Connection Failed");

if(!$conn)
{
    echo "Connection failed";
} 
// else {
//     echo "Connection success";
// }
?>