<?php

$host     = "your_host";
$db_user  = "your-database-user";
$db_pass  = "your-database-password";
$db_name  = "your-database-name";
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// echo "Connected successfully";
?>