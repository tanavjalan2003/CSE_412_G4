<?php
session_start();
require 'dbh.inc.php';

if (!isset($_SESSION['userid']) || !isset($_GET['taskid'])) {
    echo json_encode(["error" => "Invalid or unauthorized request."]);
    exit();
}

$taskid = $_GET['taskid'];
$userID = $_SESSION['userid'];

$sql = "SELECT taskid, title, description, duedate, status, categoryid FROM task WHERE taskid = $1 AND userid = $2";
$result = pg_query_params($conn, $sql, [$taskid, $userID]);

if (!$result) {
    echo json_encode(["error" => "Task not found in db."]);
    exit();
}

$task = pg_fetch_assoc($result);

$sql = "SELECT categoryid, name FROM category WHERE userid = $1";
$result = pg_query_params($conn, $sql, array($userID));

$userCategories = pg_fetch_all($result);
$task['categories'] = $userCategories;

echo json_encode($task);