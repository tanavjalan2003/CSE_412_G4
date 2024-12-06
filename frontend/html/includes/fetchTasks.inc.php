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

$data = json_decode(file_get_contents("php://input"), true);
$statuses = isset($data['statuses']) ? $data['statuses'] : [];
$categories = isset($data['categories']) ? $data['categories'] : [];

$sql = "SELECT task.taskid, task.title, task.duedate, task.status, category.name AS categoryname FROM task WHERE userid = $1";

$sql = 'SELECT task.taskid, task.title, task.duedate, task.status, category.name AS categoryname
FROM task
INNER JOIN category
ON task.categoryid = category.categoryid
WHERE task.userid = $1 ';

$params = [$_SESSION['userid']];
$paramsCount = 2;

if(!empty($statuses)) {
    $statusFilters = [];

    foreach ($statuses as $status) {
        $statusFilters[] = '$' . $paramsCount;
        $params[] = $status;
        $paramsCount++;
    }

    $sql .= "AND task.status IN (" . implode(", ", $statusFilters) . ")";
}


if(!empty($categories)) {
    $categoryFilters = [];

    foreach ($categories as $category) {
        $categoryFilters[] = '$' . $paramsCount;
        $params[] = $category;
        $paramsCount++;
    }

    $sql .= "AND task.categoryid IN (" . implode(", ", $categoryFilters) . ")";
}

$result = pg_query_params($conn, $sql, $params);

if (!$result) {
    echo json_encode(["error" => "Error: Unable to fetch tasks"]);
    exit();
}

$tasks = pg_fetch_all($result);

// If query is nothing, we need to return an empty array.
if (!$tasks) {
    $tasks = [];
}

echo json_encode($tasks);
?>
