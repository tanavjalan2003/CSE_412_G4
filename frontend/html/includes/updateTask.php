<?php
session_start();
require 'dbh.inc.php';

if (!isset($_SESSION['userid'])) {
    echo json_encode(["error" => "Unauthorized Access"]);
    exit();
}

$taskid = $_POST['taskid'] ?? null;
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$duedate = $_POST['duedate'] ?? '';
$status = $_POST['status'] ?? '';
$categoryid = $_POST['category'] ?? null;

if (!$taskid || !$title || !$duedate || !$status || !$categoryid) {
    echo json_encode(["error" => "All fields are required."]);
    exit();
}

$userID = $_SESSION['userid'];

$sql = "UPDATE task SET title = $1, description = $2, duedate = $3, status = $4, categoryid = $5 WHERE taskid = $6 AND userid = $7";
$result = pg_query_params($conn, $sql, [$title, $description, $duedate, $status, $categoryid, $taskid, $userID]);

if($result) {
    echo json_encode(["success" => true]);
}
else {
    echo json_encode(["error" => "Failed to update task. (stmt)"]);
}
?>