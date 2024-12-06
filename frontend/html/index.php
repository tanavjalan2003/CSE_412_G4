<?php
session_start();

if (!isset($_SESSION["userid"])) {
    header("Location: login.php?=NoUserLoggedIn");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="index-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile-text">
                <h1>Hello, <a href="profile.php"> <?php echo htmlspecialchars($_SESSION["username"]); ?></a></h1>
            </div>
            <button id="calendarViewBtn" class="view-btn">Calendar View</button>
            <button id="listViewBtn" class="view-btn">List View</button>
            <div class="filters">
                <input type="text" id="searchBar" placeholder="Search task name...">
            </div>
        </aside>
 
        <!-- Logout Button -->
        <form action="includes/logout.inc.php" method="POST">
            <button type="submit" id="logoutBtn" class="logout-btn">Logout</button>
        </form>

        <!-- Main Content -->
        <m class="main-content">
            <div id="calendarView" class="view active">
                <p>Calendar view will appear here.</p>
            </div>
            <div id="listView" class="view">
                <table>
                    <thead>
                        <tr>
                            <th data-column="TaskName" data-order="asc">Task Name &#x25B2;</th>
                            <th data-column="DueDate">Due Date</th>
                            <th data-column="Status">Status</th>
                            <th data-column="Category">Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="taskList">
                        
                    </tbody>
                </table>
            </div>
        </m>
    </div>

    <!-- Switch between views -->
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', () => {
        const calendarView = document.getElementById('calendarView');
        const calendarViewBtn = document.getElementById('calendarViewBtn');
        const listView = document.getElementById('listView');
        const listViewBtn = document.getElementById('listViewBtn');

        calendarViewBtn.addEventListener('click', () => {
            calendarView.classList.add('active');
            listView.classList.remove('active');
        });

        listViewBtn.addEventListener('click', () => {
            listView.classList.add('active');
            calendarView.classList.remove('active');
        });
    });
    </script>

    <!-- Allows a search bar for tasks -->
    <script type="text/javascript">
        searchBar.addEventListener("input", function () {
            const filter = searchBar.value.toLowerCase();
            const rows = taskList.getElementsByTagName("tr");

            for (let i = 0; i < rows.length; i++) {
                // Grab task name from first cell in a row
                const taskName = rows[i].cells[0].textContent.toLowerCase();

                // Either show the row or don't depending on if it has filter as a substring
                if (taskName.includes(filter))
                    rows[i].style.display = "";
                else 
                    rows[i].style.display = "none";    
            }
        });
    </script>

    <!-- This generates the tables -->
    <script type='text/javascript'>
        const taskListElement = document.getElementById("taskList");

        fetch("includes/fetchTasks.inc.php")
            .then(response => response.json())
            .then(data => {

                console.log(data);

                if (data.error) {
                    taskListElement.innerHTML = "<tr><td colspan = '5'> ERROR LOADING TASKS: " + data.error + "</td></tr>";
                } else if (data.length === 0) {
                    taskListElement.innerHTML = "<tr><td colspan = '5'> No tasks found.</td></tr>";
                } 
                else {
                    // Convert the array given from the fetchTasks.php and map each task to a specific table row
                    taskListElement.innerHTML = data.map(task =>
                       `<tr data-taskid="${task.taskid}">
                            <td>${task.title}</td>
                            <td>${task.duedate}</td>
                            <td>${task.status}</td>
                            <td>${task.categoryid}</td>
                            <td>
                                <button>Edit</button>
                                <button class="deleteBtn" data-taskid="${task.taskid}">Delete</button>
                            </td>
                        </tr>`).join(""); /* Must have this to combine table rows generated by array without ',' between rows. */
                        addDelete();
                    }
            })
    </script>

    <!-- Delete Task Button -->
    <script>
        function addDelete() {
            const deleteButtons = document.querySelectorAll(".deleteBtn");
            deleteButtons.forEach(button => {
                button.addEventListener("click", e=> {
                    const taskID = e.target.getAttribute("data-taskid");
                    console.log(taskID);

                    
                    if (!confirm("Are you sure you want to permanently delete this task?")) {
                        return;
                    }

                    // Update db
                    fetch("includes/deleteTask.inc.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "applications/json",
                        },
                        body: JSON.stringify({taskid: taskID}),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert("Error deleting task: " + data.error)
                        }
                        else {
                            // Remove html after we confirm removing from db.
                            const row = document.querySelector(`[data-taskid='${taskID}']`);

                            if (row) {
                                row.remove();

                                // Just in case user deletes all their tasks.
                                if (taskListElement.innerHTML.trim() == "")
                                    taskListElement.innerHTML = "<tr><td colspan = '5'> No tasks found. Good job!</td></tr>";
                            }
                        }
                    })
                })
            })
        }   
    </script>

</body>
</html>