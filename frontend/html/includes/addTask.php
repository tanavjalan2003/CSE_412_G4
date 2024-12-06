<?php

session_start();
require_once 'dbh.inc.php';

if (!isset($_SESSION['userid'])) {
    echo json_encode(["error" => "Access Denied"]);
}

$userID = $_SESSION['userid'];

$title = $_POST["title"] ?? null;
$description = $_POST["description"] ?? null;
$duedate = $_POST["duedate"] ?? null;
$status = $_POST["status"] ?? null;
$categoryid = $_POST["categoryid"] ?? null;


if (!$title || !$duedate || !$status || !$categoryid) {
    echo json_encode(["error" => "All fields (except description) are required"]);
    exit();
}

$sql = "INSERT INTO task(title, description, duedate, status, categoryid, userid) VALUES ($1, $2, $3, $4, $5, $6);";
$params = [$title, $description, $duedate, $status, $categoryid, $userID];

$result = pg_query_params($conn, $sql, $params);

if(!$result) {
    echo json_encode(["error" => "Failed to add task. (stmt)"]);
}
else {
    echo json_encode(["success" => true]);
}