<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit();
}

require_once 'includes/dbh.inc.php';

// Fetch current user data
$userID = $_SESSION["userID"];
$sql = "SELECT name, email FROM users WHERE \"userID\" = $1";
$result = pg_query_params($conn, $sql, array($userID));

if (!$result) {
    echo "Error fetching user data: " . pg_last_error($conn);
    exit();
}

$user = pg_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Task Management System</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="index-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile-text">
                <h1>Welcome, <a href="profile.php"><?php echo htmlspecialchars($_SESSION["username"]); ?></a></h1>
            </div>
            <button id="calendarViewBtn" class="view-btn">Calendar View</button>
            <button id="listViewBtn" class="view-btn">List View</button>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <h2>Edit Profile</h2>
            <form action="includes/updateProfile.inc.php" method="POST">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Enter new name">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Enter new email">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter new password">
                </div>
                <div class="form-group">
                    <button type="submit" name="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>