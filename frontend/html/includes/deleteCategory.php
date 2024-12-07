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

// Ensure the category belongs to the logged-in user
$sql = "DELETE FROM category WHERE categoryid = $1 AND userid = $2";
$params = [$categoryId, $_SESSION['userid']];

$result = pg_query_params($conn, $sql, $params);

if ($result) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Failed to delete category"]);
}
?>