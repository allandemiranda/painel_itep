<?php

$servername = "localhost";
$username = "allandemiranda";
$password = "senha1234";
$dbname = "sistema_itep";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
