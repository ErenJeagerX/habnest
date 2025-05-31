
<?php

$host = 'localhost';
$user = 'root';
$pwd = '';
$db_name = 'habnest';

$conn = mysqli_connect($host, $user, $pwd, $db_name);


if ($conn) {
   // echo "success";
}else{
    echo "failed ". mysqli_connect_error($conn);
}
?>