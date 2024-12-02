<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $userPassword = $_POST['userPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    require_once 'dbh.inc.php';
    require_once "functions.inc.php";

    # Validation section
    if(emptyInputSignup($email,$name, $userPassword, $confirmPassword) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }

    if ($userPassword != $confirmPassword) {
        header("location: ../signup.php?error=passwordmismatch");
        exit();
    }

    if(emailExists($conn, $email)) {
        header("location: ../signup.php?error=emailtaken");
        exit();
    }

    $result = signupUser($conn, $email, $name, $userPassword);

    if ($result === true) {
        header("location: ../login.php?signup=sucess");
        exit();
    } else {
        header("location: ../signup.php?error=stmtfailed");
    }

}
else {
    header("location: ../signup.php?error=unknown");
    exit();
}


?>