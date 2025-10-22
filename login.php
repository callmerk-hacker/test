<?php
// Start a session
session_start();

// Check if the user is already logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    // If logged in, show the success message and exit script
    echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Welcome</title>
            <style>
                /* CSS to center the message */
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh; /* Full viewport height */
                    margin: 0;
                    font-family: Arial, sans-serif;
                    background-color: #f0f0f0;
                }
                .message-box {
                    font-size: 3em;
                    color: #333;
                    padding: 30px;
                    background-color: white;
                    border-radius: 15px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    text-align: center;
                }
                .logout-link {
                    display: block;
                    margin-top: 20px;
                    font-size: 0.5em;
                    color: #007bff;
                    text-decoration: none;
                }
                .logout-link:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class="message-box">
                <p>keep silent 😧</p>
                <a href="login.php?logout=true" class="logout-link">Logout</a>
            </div>
        </body>
        </html>
    ';

    // Handle Logout
    if (isset($_GET['logout'])) {
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to the login page (index.php)
        header("location: index.php");
        exit;
    }

    exit; // Stop execution after showing the message
}


// --- LOGIN LOGIC (executed only if the user is NOT already logged in) ---

// Include the database connection file
require_once "db_connect.php";

// Define variables and initialize with empty values
$username = $password = "";

// Check if the form was submitted via POST
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Get input values
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Validate credentials
    if(!empty($username) && !empty($password)){
        // Prepare a SELECT statement to fetch the user by username
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = $conn->prepare($sql)){
            // Bind parameter
            $stmt->bind_param("s", $param_username);
            $param_username = $username;

            // Execute the statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);

                    if($stmt->fetch()){
                        // Verify the input password against the stored hash
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect to the success message page (this same file)
                            header("location: login.php");
                        } else{
                            // Password is not valid
                            echo "<script>alert('The password you entered was not valid.'); window.location.href='index.php';</script>";
                        }
                    }
                } else{
                    // Username doesn't exist
                    echo "<script>alert('No account found with that username.'); window.location.href='index.php';</script>";
                }
            } else{
                echo "Oops! Something went wrong with the query execution.";
            }

            // Close statement
            $stmt->close();
        }
    } else {
        // If fields are empty, redirect to the form
        header("location: index.php");
    }

    // Close connection
    $conn->close();
} else {
    // If not a POST request, but no session is active, redirect to index
    header("location: index.php");
    exit;
}
?>