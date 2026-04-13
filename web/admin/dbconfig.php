<?php
session_start();

$host = getenv("DB_HOST") ?: "localhost";
$user = getenv("DB_USER") ?: "root";
$pass = getenv("DB_PASSWORD") !== false ? getenv("DB_PASSWORD") : "";
$dbname = getenv("DB_NAME") ?: "test";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

function iud($query)
{
    global $conn;
    $result = $conn->query($query);
    return $result ? 1 : 0;
}

function select($query)
{
    global $conn;
    $result = $conn->query($query);
    return $result;
}
