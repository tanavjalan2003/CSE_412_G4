<?php
session_start();
require_once 'dbh.inc.php';

if (!isset($_SESSION["userid"])) {
    echo json_encode(["error" => "Unauthorized: User is not logged in"]);
    exit();
}

// We are not submitting a standard form, so we have to manually decode the body from POST request.
// Do not remove the true since it makes an array based on the information in the POST json.
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['taskid'])) {
    echo json_encode(["error" => "No task ID provided or found."]);
    exit();
}

$taskID = $data['taskid'];
$userID = $_SESSION['userid'];

$params = array($taskID, $userID);

$sql = "DELETE FROM task WHERE taskid = $1 AND userid = $2";
$result = pg_query_params($conn, $sql, $params);

if (!$result) {
    echo json_encode(["error" => "Failed to delete task. (stmt)"]);
    exit();
}

echo json_encode(["success" => "Task deleted successfully."]);