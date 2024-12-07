<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit();
}

require_once 'includes/dbh.inc.php';

// Fetch current user data
$userID = $_SESSION["userid"];
$sqlUser = "SELECT name, email FROM users WHERE \"userID\" = $1";
$resultUser = pg_query_params($conn, $sqlUser, array($userID));

if (!$resultUser) {
    echo "Error fetching user data: " . pg_last_error($conn);
    exit();
}

$user = pg_fetch_assoc($resultUser);

// Fetch analytics data
$sqlAnalytics = "SELECT completedtasks, pendingtasks, overduetasks, lastupdated FROM analytics WHERE userid = $1";
$resultAnalytics = pg_query_params($conn, $sqlAnalytics, array($userID));

if (!$resultAnalytics || pg_num_rows($resultAnalytics) === 0) {
    echo "No analytics data found for this user.";
    exit();
}

$analytics = pg_fetch_assoc($resultAnalytics);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Task Management System</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>
        function showSection(section) {
            document.getElementById('editProfileSection').style.display = section === 'edit' ? 'block' : 'none';
            document.getElementById('analyticsSection').style.display = section === 'analytics' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <div class="index-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile-text">
                <h1><a href="index.php">&larr; Back to home</a></h1>
            </div>
            <button onclick="showSection('edit')" class="view-btn">Edit Profile</button>
            <button onclick="showSection('analytics')" class="view-btn">Analytics</button>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Edit Profile Section -->
            <div id="editProfileSection" style="display: block;">
                <h2>Edit Profile</h2>
                <form action="includes/updateProfile.inc.php" method="POST">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" placeholder="Enter new name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" placeholder="Enter new email">
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

            <!-- Analytics Section -->
            <div id="analyticsSection" style="display: none;">
                <h2>Analytics</h2>
                <p>Completed Tasks: <?php echo htmlspecialchars($analytics['completedtasks']); ?></p>
                <p>Pending Tasks: <?php echo htmlspecialchars($analytics['pendingtasks']); ?></p>
                <p>Overdue Tasks: <?php echo htmlspecialchars($analytics['overduetasks']); ?></p>
                <p>Last Updated: <?php echo htmlspecialchars($analytics['lastupdated']); ?></p>
            </div>
        </div>
    </div>
</body>
</html>