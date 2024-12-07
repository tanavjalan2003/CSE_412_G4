<?php
session_start();
require_once 'dbh.inc.php';

if (!isset($_SESSION['userid'])) {
    echo json_encode(["error" => "Access denied"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$categoryId = $data['categoryid'] ?? null;

if (!$categoryId) {
    echo json_encode(["error" => "Invalid category ID"]);
    exit();
}

$userId = $_SESSION['userid'];

// Check how many categories the user has
$sql = "SELECT categoryid FROM category WHERE userid = $1 ORDER BY categoryid ASC";
$result = pg_query_params($conn, $sql, [$userId]);
$categories = pg_fetch_all($result);

if (count($categories) <= 1) {
    echo json_encode(["error" => "You must have at least one category."]);
    exit();
}

$nextCategoryId = null;
foreach ($categories as $category) {
    if ($category['categoryid'] != $categoryId) {
        $nextCategoryId = $category['categoryid'];
        break;
    }
}

// Transactions lol...
pg_query($conn, "BEGIN");

try {
    // Reassign tasks to the next available category
    $updateTasksSql = "UPDATE task SET categoryid = $1 WHERE categoryid = $2 AND userid = $3";
    $updateTasksResult = pg_query_params($conn, $updateTasksSql, [$nextCategoryId, $categoryId, $userId]);

    if (!$updateTasksResult) {
        throw new Exception("Failed to reassign tasks.");
    }

    // Delete the category
    $deleteCategorySql = "DELETE FROM category WHERE categoryid = $1 AND userid = $2";
    $deleteCategoryResult = pg_query_params($conn, $deleteCategorySql, [$categoryId, $userId]);

    if (!$deleteCategoryResult) {
        throw new Exception("Failed to delete category.");
    }

    // Commit the transaction
    pg_query($conn, "COMMIT");
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    // Rollback the transaction in case of error
    pg_query($conn, "ROLLBACK");
    echo json_encode(["error" => $e->getMessage()]);
}
?>