<?php
$host = "localhost";
$port = "5432";
$dbname = "finalProject";
$user = "admin";
$password = "password";

// Connect to database
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Error connecting to the database: " . pg_last_error());
} else {
    echo "Connection successful!";
}
?>