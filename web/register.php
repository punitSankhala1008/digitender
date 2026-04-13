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
    <title>Register | Digitender</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.min.js"></script>
</head>
<body>

<h2 style="text-align:center;background-color:#F35761;color:white;font-weight:bold">REGISTER</h2>

<div class="container">
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <div class="chart-area">
                <form method="post" action="register.php" id="registerForm">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="aadhaar" id="aadhaar" placeholder="Aadhaar Number" required>
                        <button type="button" id="sendOtpBtn" class="btn btn-secondary btn-block">Send OTP</button>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="otp" placeholder="Enter OTP" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <input type="submit" value="Register" name="register" class="btn btn-primary btn-block">
                </form>
            </div>
        </div>
        <div class="col-lg-4"></div>
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
