<?php
// Start a session to manage user login status
session_start();

// Check if the user is already logged in (session variable is set)
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    // If logged in, redirect them immediately to the login handler (which shows the success message)
    header("location: login.php");
    exit; // Stop script execution
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up & Login</title>
    <style>
        /* Simple CSS for a clean look and centered content */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { display: flex; gap: 40px; }
        .form-box { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
        h2 { text-align: center; color: #333; }
        input[type="text"], input[type="password"], input[type="email"] { width: 100%; padding: 10px; margin: 8px 0 15px 0; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        input[type="submit"] { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
        input[type="submit"]:hover { background-color: #45a049; }
        .error { color: red; margin-bottom: 15px; text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <div class="form-box">
        <h2>Sign Up</h2>
        <form action="signup.php" method="post">
            <label for="reg_username">Username</label>
            <input type="text" id="reg_username" name="username" required>

            <label for="reg_email">Email</label>
            <input type="email" id="reg_email" name="email" required>

            <label for="reg_password">Password</label>
            <input type="password" id="reg_password" name="password" required>

            <input type="submit" value="Register">
        </form>
    </div>

    <div class="form-box">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="log_username">Username</label>
            <input type="text" id="log_username" name="username" required>

            <label for="log_password">Password</label>
            <input type="password" id="log_password" name="password" required>

            <input type="submit" value="Login">
        </form>
    </div>
</div>

</body>
</html>