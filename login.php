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
                // IMPORTANT: You should use password_verify() here, not direct comparison ($pwd === $db_hashed_pwd)
                // if (password_verify($pwd, $db_hashed_pwd)) { 
                if ($pwd === $db_hashed_pwd){ // This line is insecure if $db_hashed_pwd is a hash
                    // Password is correct
                    $_SESSION['name'] = $row['first_name'];
                    
                    // --- Handle Remember Me Logic (Add this section) ---
                    if (isset($_POST['remember_me']) && $_POST['remember_me'] == 'on') {
                        // Set a cookie for 30 days (adjust as needed)
                        $cookie_name = "user_remember_me";
                        $cookie_value = $username; // Store username or a unique token
                        $expiration = time() + (86400 * 30); // 86400 = 1 day, so 30 days

                        // Set the cookie
                        setcookie($cookie_name, $cookie_value, $expiration, "/"); 
                        // You would typically set a more secure, hashed token here, not just the username
                    }
                    // --- End Remember Me Logic ---

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
    <title>Habnest - Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .wrapper-login {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .wrapper-login h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1.5rem;
        }
        .wrapper-login h1 span {
            color: #DC5641;
        }
        .input-field {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .input-field input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .input-field input:focus {
            border-color: #DC5641;
            outline: none;
        }
        .input-field label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1rem;
            transition: all 0.3s;
            pointer-events: none;
        }
        .input-field input:focus + label,
        .input-field input:not(:placeholder-shown) + label {
            top: -10px;
            left: 10px;
            font-size: 0.8rem;
            color: #DC5641;
            background: #fff;
            padding: 0 5px;
        }
        .input-field .show-pwd {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
        .input-field .error-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #DC5641;
            display: none;
        }
        .form-check {
            text-align: left;
            margin-bottom: 1rem;
        }
        .form-check-label {
            color: #333;
        }
        button.text-white {
            background: #DC5641;
            border: none;
            padding: 0.75rem;
            width: 100%;
            border-radius: 5px;
            font-size: 1rem;
            transition: background 0.3s;
        }
        button.text-white:hover {
            background: #DC5641;
        }
        .alert {
            margin-bottom: 1rem;
        }
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