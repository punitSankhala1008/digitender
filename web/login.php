<?php
include "dbconfig.php";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM registration WHERE email = '" . addslashes($email) . "' LIMIT 1";
    $result = select($query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $dbPassword = isset($row['password']) ? $row['password'] : '';
        $isValid = ($password === $dbPassword) || password_verify($password, $dbPassword);
        if ($isValid) {
            $_SESSION['user'] = $row['name'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['login'] = "yes";
            echo '<script>alert("Login successful."); window.location="index.php";</script>';
        } else {
            echo '<script>alert("Incorrect password.");</script>';
        }
    } else {
        echo '<script>alert("User not found.");</script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | DigiTender</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
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
            .auth-footer { margin-top: 16px; color: #6f7d8c; font-size: 14px; text-align: center; }
            .auth-footer a { font-weight: 700; color: #d93a60; text-decoration: none; }
        </style>
</head>
<body class="auth-page">
    <div class="auth-wrap">
        <div class="auth-brand">
            <a href="index.php">DigiTender</a>
            <p>Tender and bidding platform</p>
        </div>

        <div class="auth-card">
            <h2 class="auth-title">Welcome Back</h2>
            <p class="auth-helper">Login to browse tenders and manage your bids.</p>

            <form method="post" autocomplete="off">
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email address" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <button type="submit" name="login" class="auth-btn">Login</button>
            </form>

            <div class="auth-footer">
                New to DigiTender? <a href="register.php">Create account</a>
            </div>
        </div>
    </div>
</body>
</html>
