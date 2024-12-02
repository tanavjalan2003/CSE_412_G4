<?php

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $userPassword = $_POST["userPassword"];


    require_once 'dbh.inc.php';
    require_once "functions.inc.php";
    if(emptyInputLogin($email, $userPassword) !== false) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $email, $userPassword);
}
else {
    header("location: ../login.php?error=POSTFail");
    exit();
}