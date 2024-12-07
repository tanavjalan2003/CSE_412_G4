<?php
session_start();
require_once 'dbh.inc.php';

if (!isset($_SESSION['userid'])) {
    echo json_encode(["error" => "Access Denied"]);
    exit();
}

$userid = $_SESSION['userid'];

// Count tasks by status
$query = "SELECT 
    SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) AS completedtasks,
    SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) AS pendingtasks,
    SUM(CASE WHEN status = 'Overdue' THEN 1 ELSE 0 END) AS overduetasks
FROM task WHERE userid = $1";

$result = pg_query_params($conn, $query, [$userid]);

if (!$result) {
    echo json_encode(["error" => "Couldn't retrieve task data"]);
    exit();
}

$row = pg_fetch_assoc($result);
$completedTasks = $row['completedtasks'] ?? 0;
$pendingTasks = $row['pendingtasks'] ?? 0;
$overdueTasks = $row['overduetasks'] ?? 0;

// Update the analytics table
$updateQuery = "UPDATE analytics
    SET completedtasks = $1, pendingtasks = $2, overduetasks = $3, lastupdated = NOW()
    WHERE userid = $4";
$updateResult = pg_query_params($conn, $updateQuery, [$completedTasks, $pendingTasks, $overdueTasks, $userid]);

if ($updateResult) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Failed to update analytics"]);
}
?>