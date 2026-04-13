<?php
session_Start();
 unset($_SESSION['admin_id']);
 unset($_SESSION['admin_email']);
 unset($_SESSION['admin_login']);
header("location:index.php");
?>