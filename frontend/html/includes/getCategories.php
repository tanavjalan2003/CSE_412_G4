<?php

session_start();
require 'dbh.inc.php';

if(!isset($_SESSION['userid'])) {
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}

$userID = $_SESSION['userid'];

$sql = "SELECT * FROM category WHERE userid = $1";
$result = pg_query_params($conn, $sql, array($userID));

if(!$result) {
    echo json_encode(["error" => "User has no categories"]);
    exit();
}

$userCategories = pg_fetch_all($result);

echo json_encode($userCategories);
