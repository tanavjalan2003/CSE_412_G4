<?php

session_start();
require_once 'dbh.inc.php';
require_once "functions.inc.php";

if (!isset($_SESSION["userid"])) {
    echo json_encode(["error" => "USER IS NOT LOGGED IN"]);
    exit();
}

# Grab logged in user
$userID = $_SESSION["userid"];

$sql = 'SELECT * FROM task WHERE userid = $1;';
$result = pg_query_params($conn, $sql, array($userID));

if (!$result) {
    $tasks = [];
    echo json_encode($tasks);
    exit();
}

$tasks = pg_fetch_all($result);

// If query is nothing, we need to return an empty array.
if (!$tasks) {
    $tasks = [];
}

echo json_encode($tasks);
?>
