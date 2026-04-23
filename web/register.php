<?php
include "dbconfig.php";

if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $aadhaar = trim($_POST['aadhaar']);
    $password = $_POST['password'];
    $otp_entered = trim($_POST['otp']);

    if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_mobile'])) {
        echo '<script>alert("Please click Send OTP first.");</script>';
    } elseif ($mobile !== $_SESSION['otp_mobile']) {
        echo '<script>alert("Mobile number was changed after OTP generation. Please request OTP again.");</script>';
    } elseif ($otp_entered !== (string)$_SESSION['otp']) {
        echo '<script>alert("Invalid OTP. Please try again.");</script>';
    } elseif (!preg_match('/^[0-9]{10}$/', $mobile)) {
        echo '<script>alert("Please enter a valid 10-digit mobile number.");</script>';
    } elseif (!preg_match('/^[0-9]{12}$/', $aadhaar)) {
        echo '<script>alert("Please enter a valid 12-digit Aadhaar number.");</script>';
    } elseif (strlen($password) < 6) {
        echo '<script>alert("Password must be at least 6 characters.");</script>';
    } else {
        $name = addslashes($name);
        $email = addslashes($email);
        $mobile = addslashes($mobile);
        $aadhaar = addslashes($aadhaar);
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $checkQuery = "SELECT id FROM registration WHERE email='$email' OR mobile='$mobile' OR aadhaar='$aadhaar' LIMIT 1";
        $exists = select($checkQuery);

        if ($exists && mysqli_num_rows($exists) > 0) {
            echo '<script>alert("User already exists with same Email, Mobile, or Aadhaar.");</script>';
        } else {
            $insertQuery = "INSERT INTO registration (`name`, `mobile`, `email`, `aadhaar`, `password`) 
                            VALUES ('$name', '$mobile', '$email', '$aadhaar', '$passwordHash')";
            $n = iud($insertQuery);

            if ($n == 1) {
                unset($_SESSION['otp']);
                unset($_SESSION['otp_mobile']);
                echo '<script>alert("Registration successful."); window.location="login.php";</script>';
            } else {
                echo '<script>alert("Registration failed. Please try again.");</script>';
            }
        }
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Register | DigiTender</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
        <style>
            body.auth-page { min-height: 100vh; margin: 0; padding: 48px 16px; font-family: 'Manrope', sans-serif; background: radial-gradient(circle at 10% 10%, #fff2f6 0%, #f5f8ff 42%, #eef3fb 100%); }
            .auth-wrap { max-width: 460px; margin: 0 auto; }
            .auth-brand { text-align: center; margin-bottom: 16px; }
            .auth-brand a { font-family: 'Space Grotesk', sans-serif; font-size: 34px; font-weight: 700; color: #223247; text-decoration: none; }
            .auth-brand p { color: #6f7d8c; margin-top: 4px; }
            .auth-card { background: #fff; border: 1px solid #e9edf4; border-radius: 16px; padding: 26px; box-shadow: 0 20px 45px rgba(36, 47, 74, 0.14); }
            .auth-title { margin: 0; font-family: 'Space Grotesk', sans-serif; font-size: 28px; color: #223247; }
            .auth-helper { margin: 8px 0 20px; color: #6f7d8c; font-size: 14px; }
            .auth-card .form-group { margin-bottom: 14px; }
            .auth-card .form-control { height: 46px; border-radius: 10px; border: 1px solid #d8dfea; }
            .auth-card .form-control:focus { border-color: #ef476f; box-shadow: 0 0 0 3px rgba(239, 71, 111, 0.16); }
            .auth-btn { width: 100%; height: 46px; border: 0; border-radius: 10px; background: linear-gradient(90deg, #ef476f, #ff5f87); color: #fff; font-weight: 700; }
            .auth-btn.alt { background: linear-gradient(90deg, #4f6ef7, #6282ff); }
            .auth-footer { margin-top: 16px; color: #6f7d8c; font-size: 14px; text-align: center; }
            .auth-footer a { font-weight: 700; color: #d93a60; text-decoration: none; }
        </style>
</head>
<body class="auth-page">

<div class="auth-wrap">
    <div class="auth-brand">
        <a href="index.php">DigiTender</a>
        <p>Create your account to start bidding</p>
    </div>

    <div class="auth-card">
        <h2 class="auth-title">Create Account</h2>
        <p class="auth-helper">Fill in your details and verify OTP to continue.</p>

        <form method="post" action="register.php" id="registerForm" autocomplete="off">
            <div class="form-group">
                <input type="text" class="form-control" name="name" id="name" placeholder="Full name" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email address" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile number" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="aadhaar" id="aadhaar" placeholder="Aadhaar number" required>
            </div>

            <div class="form-group">
                <button type="button" id="sendOtpBtn" class="auth-btn alt">Send OTP</button>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="otp" placeholder="Enter OTP" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="register" class="auth-btn">Register</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $("#sendOtpBtn").on("click", function () {
        var name = $("#name").val().trim();
        var email = $("#email").val().trim();
        var mobile = $("#mobile").val().trim();
        var aadhaar = $("#aadhaar").val().trim();

        if (!name || !email || !mobile || !aadhaar) {
            alert("Please fill Name, Email, Mobile, and Aadhaar before sending OTP.");
            return;
        }

        $.ajax({
            url: "send_otp.php",
            type: "POST",
            data: {
                send_otp: 1,
                mobile: mobile,
                aadhaar: aadhaar
            },
            success: function (response) {
                alert(response);
            },
            error: function () {
                alert("Unable to send OTP right now. Please try again.");
            }
        });
    });
});
</script>

</body>
</html>
