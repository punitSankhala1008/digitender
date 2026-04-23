<?php
session_start();
include "dbconfig.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DigiTender</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<h2>Register for DigiTender</h2>

<form action="verify_otp.php" method="POST">
    <div class="form-group">
        <label for="name">Full Name:</label>
        <input type="text" name="name" id="name" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
    </div>

    <div class="form-group">
        <label for="mobile">Mobile Number:</label>
        <input type="text" name="mobile" id="mobile" required>
        <button type="button" id="sendOtpBtn">Send OTP</button>
    </div>

    <div class="form-group">
        <label for="otp">Enter OTP:</label>
        <input type="text" name="otp" id="otp" required>
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
    </div>

    <button type="submit" name="register">Register</button>
</form>

<script>
$(document).ready(function() {
    $("#sendOtpBtn").click(function() {
        var mobile = $("#mobile").val();
        
        if (mobile.length !== 10 || isNaN(mobile)) {
            alert("Please enter a valid 10-digit mobile number.");
            return;
        }

        $.ajax({
            url: "send_otp.php",
            type: "POST",
            data: { mobile: mobile },
            success: function(response) {
                alert(response);
            }
        });
    });
});
</script>

</body>
</html>

