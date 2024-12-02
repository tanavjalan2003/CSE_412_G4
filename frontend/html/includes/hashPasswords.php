<?php
include 'dbh.inc.php';

// Retrieve all users with their current plain-text passwords
$sql = "SELECT \"userID\", password FROM users";
$result = pg_query($conn, $sql);

if (!$result) {
    die("Error retrieving users: " . pg_last_error($conn));
}

while ($row = pg_fetch_assoc($result)) {
    $userID = $row['userID'];
    $plainPassword = $row['password'];

    // Hash the plain-text password
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // Update the database with the hashed password
    $updateSql = "UPDATE users SET password = $1 WHERE \"userID\" = $2";
    $updateResult = pg_query_params($conn, $updateSql, array($hashedPassword, $userID));

    if (!$updateResult) {
        echo "Error updating userID $userID: " . pg_last_error($conn) . "<br>";
    } else {
        echo "Password for userID $userID has been hashed and updated.<br>";
    }
}

?>