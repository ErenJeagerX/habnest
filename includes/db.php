<?php

$host = 'localhost';
$user = 'root';
$pwd = 'bini@12';
$db_name = 'habnest';

try {
    $conn = new mysqli($host, $user, $pwd, $db_name);
} catch(mysqli_sql_exception $e) {
    die('Connection failed: ' . $e->getMessage());
}
