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

    if (!empty($email) && emailExists($conn, $email)) {
        header("Location: ../profile.php?update=emailalreadyinuse");
        exit();
    }


    $sql = "UPDATE users SET";
    $params = [];
    $paramsCount = 0;

    if (!empty($name)) {
        if ($paramsCount > 0) {
            $sql .= ",";
        }
        $sql .= " name = $" . (count($params) + 1);
        $params[] = $name;
        $paramsCount++;
    }

    if (!empty($email)) {
        if ($paramsCount > 0) {
            $sql .= ",";
        }
        $sql .= " email = $" . (count($params) + 1);
        $params[] = $email;
        $paramsCount++;
    }

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($paramsCount > 0) {
            $sql .= ",";
        }
        $sql .= " password = $" . (count($params) + 1);
        $params[] = $hashedPassword;
        $paramsCount++;
    }

    if ($paramsCount > 0) {
        $sql .= " WHERE \"userID\" = $" . (count($params) + 1);
        $params[] = $userID;

        $result = pg_query_params($conn, $sql, $params);

        if ($result) {
            header("Location: ../profile.php?update=success");
        } else {
            echo "Error updating profile: " . pg_last_error($conn);
        }

    }
    else {
        header("Location: ../profile.php?update=none");
    }
}
?>