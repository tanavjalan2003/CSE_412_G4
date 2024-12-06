<?php

session_start();
require_once 'dbh.inc.php';

if (!isset($_SESSION['userid'])) {
    echo json_encode(["error" => "Access Denied"]);
}

$userID = $_SESSION['userid'];

$name = $_POST["name"] ?? null;
$description = $_POST["description"] ?? null;

if (!$name) {
    echo json_encode(["error" => "Name is required"]);
    exit();
}

$sql = "INSERT INTO category(name, description, userid) VALUES ($1, $2, $3);";
$params = [$name, $description, $userID];

$result = pg_query_params($conn, $sql, $params);

if(!$result) {
    echo json_encode(["error" => "Failed to add task. (stmt)"]);
}
else {
    echo json_encode(["success" => true]);
}
