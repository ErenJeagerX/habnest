<?php
session_start();
// database connection
include('db.php');


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