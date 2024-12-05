<?php
session_start();
require_once 'dbh.inc.php';

if (!isset($_SESSION["userid"])) {
    echo json_encode(["error" => "USER IS NOT LOGGED IN"]);
    exit();
}

session_unset();
session_destroy();

header("location: ../login.php?error=logoutsuccessful");
exit();