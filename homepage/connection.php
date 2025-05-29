<?php

// Database connection
$host = 'localhost';
$dbname = 'passwd_username';
$username = 'root';
$password = '';

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}else{
    echo "Connected successfully";
}

?>