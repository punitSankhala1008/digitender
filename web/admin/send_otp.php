<?php
session_start();
include "dbconfig.php";

if (isset($_POST['send_otp'])) {
    $aadhaar = $_POST['aadhaar'];
    $mobile = $_POST['mobile'];

    if (strlen($aadhaar) != 12 || !ctype_digit($aadhaar)) {
        echo "Invalid Aadhaar Number. It must be 12 digits.";
        exit();
    }

    $_SESSION['otp'] = rand(100000, 999999);
    $_SESSION['mobile'] = $mobile;

    $otp = $_SESSION['otp'];
    $api_key = "VesMCpAnibI8rwgQqOBj2NLDdoyGKXczYuJfWm39HathTFvSR40iYrafZXA4927cWBguzsDRlS8MKPTh"; // Replace with actual API key
    $sender_id = "SENDER_ID";  // Replace with your sender ID

    $message = "Your OTP for DigiTender registration is $otp.";
    $url = "https://www.fast2sms.com/dev/bulkV2?authorization=$api_key&message=" . urlencode($message) . "&language=english&route=q&numbers=$mobile";

    $response = file_get_contents($url);

    if ($response) {
        echo "OTP sent successfully.";
    } else {
        echo "Failed to send OTP. Try again.";
    }
}
?>
