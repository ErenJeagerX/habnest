<?php


$host = 'localhost';
$user = 'root';
$pwd = '';
$db_name = 'habnest';

try {
    $conn = new mysqli($host, $user, $pwd, $db_name);
} catch(mysqli_sql_exception $e) {
    die('Connection failed: ' . $e->getMessage());

}

if (isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $pwd = trim($_POST['pwd']);

    if (username($empty)){
        $usr_error = "Please enter Username";
    }elseif (pwd($empty)){
        $pwd_error = "Please enter Password";
    }
    else{

        $sql = "SELECT * FROM users WHERE $username = ? && $pwd = ?";
        $stmt = $conn->prepare($sql);
        $stmt = bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0){
            //username is correct
            $row = $result->fetch_assoc();
            $db_pwd = $row['pwd'];
            if (password_verify($pwd, $db_pwd)){
                //password is correct
                //use session here
                $_SESSION['name'] = ['first_name'];
                header['location: ./landlord/dashboard.php'];
                
            }

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
                <input type="text" name="username" id="username" placeholder="">
                <label for="username">Username</label>
                <i class="fas fa-warning error-icon"></i>
            </div>
            <div class="input-field">
                <input type="password" name="pwd" id="pwd" placeholder="">
                <label for="pwd">Password</label>
                <i class="fas fa-eye-slash show-pwd hidden" id="showPwd"></i>
                <i class="fas fa-warning error-icon"></i>
            </div>

            

            <button type="submit" name="submit">Login</button>
        </form>
    </div>
</body>
</html>