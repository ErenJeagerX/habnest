<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habnest - Admin Login</title>
    <link rel="stylesheet" href="./assets/css/style.css?v=2">
    <link rel="stylesheet" href="./icons/fontawesome/css/all.css">
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
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>