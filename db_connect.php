<?php
// Define database credentials
define('DB_SERVER', 'localhost'); // Database server address
define('DB_USERNAME', 'root'); // Database username
define('DB_PASSWORD', ''); // Database password
define('DB_NAME', 'simple_auth_db'); // The database we created

// Attempt to connect to MySQL database
// Note: Constants are used WITHOUT quotes here
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($conn === false){
    // If connection fails, stop execution and show the error
    die("ERROR: Could not connect. " . $conn->connect_error);
}
?>