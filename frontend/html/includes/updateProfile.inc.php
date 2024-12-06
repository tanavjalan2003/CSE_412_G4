profile.inc.php
<?php
session_start();

if (!isset($_SESSION["userid"])) {
    header("Location: ../login.inc.php");
    exit();
}

if (isset($_POST["submit"])) {
    $userID = $_SESSION["userid"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // Hash the new password if provided
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET name = $1, email = $2, password = $3 WHERE \"userID\" = $4";
        $params = array($name, $email, $hashedPassword, $userID);
    } else {
        // If password is not changed, update only name and email
        $sql = "UPDATE users SET name = $1, email = $2 WHERE \"userID\" = $3";
        $params = array($name, $email, $userID);
    }

    $result = pg_query_params($conn, $sql, $params);

    if ($result) {
        header("Location: ../profile.php?update=success");
    } else {
        echo "Error updating profile: " . pg_last_error($conn);
    }
}
?>