<?php
session_start(); 

// database connection
include('connection.php');


$passwd_error = $usr_error = $message = "";
// Check if the form has been submitted
if(isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $pwd = trim($_POST['pwd']);

    // Validate if fields are not empty
    if (empty($username)) {
        $message = '<div class="alert alert-warning" role="alert">Please enter your username.</div>';
    } elseif (empty($pwd)) {
        $message = '<div class="alert alert-warning" role="alert">Please enter your password.</div>';
    } else {
        $sql = "SELECT * FROM users WHERE username = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $username);

            $stmt->execute();

            // Get the result set
            $result = $stmt->get_result();

            // Check if a user with that username exists
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $db_hashed_pwd = $row['password']; 
                if ($pwd === $db_hashed_pwd){
               // if (password_verify($pwd, $db_hashed_pwd)) {
                    // Password is correct
                    $_SESSION['name'] = $row['first_name'];
                    header("Location: ./landlord/dashboard.php");
                    exit();
                } else {
                    $passwd_error = "Invalid Password";
                }
            } else {
                $usr_error = "Invalid Username";
            }

            $stmt->close(); 
        } else {
            $message = '<div class="alert alert-danger" role="alert">Database Failed.</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habnest - Admin Login</title>
    <link rel="stylesheet" href="./assets/css/style.css?v=2"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="module" src="./assets/JS/login-admin.js" defer></script>
</head>
<body>

    <div class="wrapper wrapper-login">
        <h1>Welcome <span>back</span>.</h1>
        <form action="login.php" method="post">
            <h2>Login</h2>
            <div class="input-field">
                <input type="text" name="username" id="username" placeholder="" required>
                <label for="username">Username</label>
                <i class="fas fa-warning error-icon"></i>
            </div>
            <div class="input-field">
                <input type="password" name="pwd" id="pwd" placeholder="" required>
                <label for="pwd">Password</label>
                <i class="fas fa-eye-slash show-pwd hidden" id="showPwd"></i>
                <i class="fas fa-warning error-icon"></i>
            </div>
            <button type="submit" name="submit">Login</button>
        </form>
    </div>
</body>
</html>