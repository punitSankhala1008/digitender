<?php
session_start();

if (!isset($_POST['send_otp'])) {
    echo "Invalid request.";
    exit();
}

$mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : "";
$aadhaar = isset($_POST['aadhaar']) ? trim($_POST['aadhaar']) : "";

if (!preg_match('/^[0-9]{10}$/', $mobile)) {
    echo "Invalid mobile number. It must be 10 digits.";
    exit();
}

if (!preg_match('/^[0-9]{12}$/', $aadhaar)) {
    echo "Invalid Aadhaar number. It must be 12 digits.";
    exit();
}

$otp = (string)rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_mobile'] = $mobile;

$apiKey = getenv('FAST2SMS_API_KEY') ?: '';

if ($apiKey === '') {
    // Local dev fallback so registration can proceed without SMS gateway setup.
    echo "OTP generated successfully. Use this OTP: " . $otp;
    exit();
}

$message = "Your OTP for Digitender registration is " . $otp . ".";
$url = "https://www.fast2sms.com/dev/bulkV2?authorization=" . urlencode($apiKey)
    . "&message=" . urlencode($message)
    . "&language=english&route=q&numbers=" . urlencode($mobile);

$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'timeout' => 15,
    ],
]);

$response = @file_get_contents($url, false, $context);

if ($response === false) {
    echo "OTP generated, but SMS delivery failed. Use this OTP: " . $otp;
    exit();
}

echo "OTP sent successfully.";
