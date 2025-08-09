<?php
include('./includes/login.php');

// if(isset($_SESSION['id']) && $_SESSION['role'] === 'landlord'){
//     header("Location: landlord/dashboard.php");
// }
// elseif(isset($_SESSION['id']) && $_SESSION['role'] === 'admin'){
//     header("Location: admin/dashboard.php");
// }

$passwd_error = $usr_error = $message = "";
// Check if the form has been submitted
if(isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $pwd = trim($_POST['pwd']);

    // check if the fields are empty or not...
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
                $db_hashed_pwd = $row['pwd']; 
                if (password_verify($pwd, $db_hashed_pwd)) { 
                    // Password is correct
                    $_SESSION['name'] = $row['first_name'];
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['role'] = $row['role'];
                    
                    //cookies
                    if(isset($_POST['remember_me'])){
                        $remr = $_POST['remember_me'];

                        setcookie("usr_cookie", $username, time() + 86400 * 30, '/');
                        setcookie("remr_cookie", $remr, time() + 86400 * 30, '/');

                    }else{
                        if(isset($_COOKIE['usr_cookie'])){
                            setcookie("usr_cookie", $username, time() - 86400 * 30, '/');
                        }
                        if(isset($_COOKIE['remr_cookie'])){
                            setcookie("remr_cookie", $remr, time() - 86400 * 30, '/');
                        }
                       
                }

                //cookies end here
                    // redirecting the user to the dashboard (successful login)
                    if($row['role'] == 'landlord'){
                        header("Location: ./landlord/dashboard.php");
                        exit();
                    } elseif($row['role'] == 'admin') {
                        header("Location: ./admin/dashboard.php");
                        exit();
                    }

                    // if there is an error ....
                } else {
                    $passwd_error = "Invalid Password";
                }
            } else {
                $usr_error = "Invalid Username";
            }

            $stmt->close(); 
        } else {
            $message = 'Database Failed.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habnest - Login</title>
    <link rel="shortcut icon" href="./assets/imgs/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/login.css">
    <style>
        
    </style>
    
</head>
<body>
    <div class="wrapper wrapper-login">
        <h1>Welcome <span>back</span>.</h1>
        <?php
        if (!empty($message)) {
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
        if (!empty($usr_error)) {
            echo '<div class="alert alert-danger" role="alert">' . $usr_error . '</div>';
        }
        if (!empty($passwd_error)) {
            echo '<div class="alert alert-danger" role="alert">' . $passwd_error . '</div>';
        }


        ?>
        <form action="login.php" method="post">
            <?php
            $prt_email = (!empty($email) ? $email : (isset($_COOKIE['usr_cookie']) ? $_COOKIE['usr_cookie'] : ""));
            $checked = (!empty($remr) ? $remr : (isset($_COOKIE['remr_cookie']) ? $_COOKIE['remr_cookie'] : ""));

            ?>
            <h2>Login</h2>
            <div class="input-field">
                <input type="text" name="username" id="username" placeholder=" " required>
                <label for="username">Username</label>
                <i class="fas fa-warning error-icon"></i>
            </div>
            <div class="input-field mb-4">
                <input type="password" name="pwd" id="pwd" placeholder=" " required>
                <label for="pwd">Password</label>
                <i class="fas fa-warning error-icon"></i> 
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                <label class="form-check-label" for="remember_me">Remember Me</label>
            </div>
            <button type="submit" name="submit" class="text-white">Login</button>
        </form>
    </div>
</body>
</html>