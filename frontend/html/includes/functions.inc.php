<?php

function emailExists($conn, $email) {
    $sql = 'SELECT * FROM users WHERE email = $1;';
    $result = pg_query_params($conn, $sql, array($email));

    if (!$result) {
        header("location: ../login.php?error=stmtfailed");
        exit();
    }

    $row = pg_fetch_assoc($result);
    return $row ?: false;
}

function emptyInputLogin($email, $password) {
    return empty($email) || empty($password);
}

function emptyInputSignup($email, $name, $password, $confirmPassword) {
    return empty($email) || empty($confirmPassword) || empty($password) || empty($name);
}

function loginUser($conn, $email, $password) {
    # Grab the row of the email attached to user
    $emailExists = emailExists($conn, $email);

    if ($emailExists === false) {
        header("location: ../login.php?error=emaildoesntexist");
        exit();
    }

    $pwdHashed = $emailExists["password"];

    # PHP has a built in function to verified hashed passwords that comes from 
    # the password_hash() function.
    $checkPassword = password_verify($password, $pwdHashed);

    if (!$checkPassword) {
        header(header: "location: ../login.php?error=wronglogin");
        exit();
    } else {
        session_start();
        $_SESSION["userid"] = $emailExists["userID"];
        $_SESSION["username"] = $emailExists["name"];
        header(header: "location: ../index.php");
        exit();
    }
}

function signupUser($conn, $email, $name, $userPassword) {
    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (\"email\", \"name\", \"password\") VALUES ($1, $2, $3)";
    $result = pg_query_params($conn, $sql, array($email, $name, $hashedPassword));

    if (!$result) {
        return false;
    }
    return true;
}