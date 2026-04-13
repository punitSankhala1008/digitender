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
    <title>Login | Digitender</title>
</head>
<body>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>
