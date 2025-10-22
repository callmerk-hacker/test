<?php
// Include the database connection file
require_once "db_connect.php";

// Define variables and initialize with empty values
$username = $email = $password = "";

// Check if the form was submitted via POST
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Get and sanitize input values
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]); // Will be hashed below

    // Check if the input fields are not empty
    if(!empty($username) && !empty($email) && !empty($password)){

        // Prepare an INSERT statement
        // The '?' are placeholders for security (prepared statements)
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            // 'sss' indicates three string parameters
            $stmt->bind_param("sss", $param_username, $param_email, $param_password);

            // Set parameters
            $param_username = $username;
            $param_email = $email;
            // Hash the password for security before storing it
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Default algorithm is currently recommended

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Registration successful, redirect to index with a success message
                echo "<script>alert('Registration successful! You can now log in.'); window.location.href='index.php';</script>";
                exit();
            } else{
                // Error during execution (e.g., username/email already exists)
                // Use a more generic message for security
                echo "Oops! Something went wrong. Please try again later. (Error: " . $stmt->error . ")";
            }

            // Close statement
            $stmt->close();
        }
    } else {
        echo "Please fill out all fields.";
    }

    // Close connection
    $conn->close();
} else {
    // If not a POST request, redirect back to the form
    header("location: index.php");
    exit;
}
?>