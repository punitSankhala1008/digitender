<?php

session_start();
define("server", getenv("DB_HOST") ?: "localhost", true);
define("user", getenv("DB_USER") ?: "root", true);
define("password", getenv("DB_PASSWORD") !== false ? getenv("DB_PASSWORD") : "", true);
define("database", getenv("DB_NAME") ?: "test", true);

function iud($query)
{
    $port = getenv("DB_PORT") ?: 4000;
    $cid = mysqli_init();
    mysqli_real_connect($cid, server, user, password, database, $port, NULL, MYSQLI_CLIENT_SSL) or die("connection error");
    $result = mysqli_query($cid, $query);
    $n = mysqli_affected_rows($cid);
    mysqli_close($cid);
    return $n;
}

function select($query)
{
    $port = getenv("DB_PORT") ?: 4000;
    $cid = mysqli_init();
    mysqli_real_connect($cid, server, user, password, database, $port, NULL, MYSQLI_CLIENT_SSL) or die("connection error");
    $result = mysqli_query($cid, $query);
    mysqli_close($cid);
    return $result;
}
