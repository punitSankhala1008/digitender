<?php
session_start();
include "dbconfig.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $otp = $_POST['otp'];

    // Check if OTP matches
    if ($_SESSION['otp'] == $otp && $_SESSION['mobile'] == $mobile) {
        // Insert user data into database
        $query = "INSERT INTO users (`name`, `mobile`, `email`, `password`) VALUES ('$name', '$mobile', '$email', '$password')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo '<script>alert("Registration successful!"); window.location="login.php";</script>';
        } else {
            echo '<script>alert("Error in registration. Try again!");</script>';
        }
    } else {
        echo '<script>alert("Invalid OTP!"); window.location="register.php";</script>';
    }
}
?>
