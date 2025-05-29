<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../CSS/login.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="text-center mb-4">Login</h2>
            <form action="main.php" method="post">
                <!-- Email Input -->
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" placeholder="name@example.com">
                    <label for="email">Email address</label>
                </div>
                
                <!-- Password Input -->
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 py-2">Sign In</button>
                
            
            </form>
        </div>
    </div>

</body>
</html>