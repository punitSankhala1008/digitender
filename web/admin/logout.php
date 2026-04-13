<?php
session_Start();
 unset($_SESSION['id']);
 unset($_SESSION['login']);
header("location:index.php");
?>