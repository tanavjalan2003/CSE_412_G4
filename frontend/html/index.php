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
            <button id="addTaskBtn" class="view-btn">Add Task</button>
            <button id="addCategoryBtn" class="view-btn">Add Category</button>
            <div class="filters">
                <input type="text" id="searchBar" placeholder="Search task name...">

                <h3>Filter Tasks:</h3>
                <div class="filter-group">
                    <h4>Categories</h4>
                    <div id="filterCategories">
                        <!-- Grab user categories and fill this -->
                    </div>
                </div>
                <div class="filter-group">
                    <h4>Status</h4>
                    <div id="filterStatus">
                        <label><input type="checkbox" class="filter-status" value="Pending">Pending</label>
                        <br>
                        <label><input type="checkbox" class="filter-status" value="Completed">Completed</label>
                        <br>
                        <label><input type="checkbox" class="filter-status" value="Overdue">Overdue</label>
                    </div>
                </div>
                <button id="applyFilters" class="view-btn">Apply Filters</button>
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

    <!-- Edit Task Modal(popup)-->
    <div id="taskEditingModal" class="modal">
        <div class="modal-wrapepr">
            <span id="edit-closeModal">&times;</span>
            <h2>Edit task</h2>

            <form id="editTaskForm">
                <input type="hidden" id="edit-taskid" name="taskid">

                <label for="title">Title</label>
                <input type="text" id="edit-title" name="title" required>

                <label for="description">Description</label>
                <input type="textarea" id="edit-description" name="description" row="3" required>

                <label for="duedate">Due Date</label>
                <input type="date" id="edit-duedate" name="duedate" required>

                <label for="status">Status</label>
                <select id="edit-status" name="status">
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                    <option value="Overdue">Overdue</option>
                </select>

                <label for="category">Category</label>
                <!-- This will be filled like the task table except we pull user categories -->
                <select id="category" name="category"></select>

                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- TODO ADD TASK MODAL -->
    <div id="addTaskModal" class="modal">
        <div class="modal-wrapepr">
            <span id="addTask-closeModal">&times;</span>
            <h2>Add a new task</h2>

            <form id="addTaskForm">
                <label for="title">Title</label>
                <input type="text" id="addTask-title" name="title" required>

                <label for="description">Description</label>
                <input type="textarea" id="addTask-description" name="description" row="3">

                <label for="duedate">Due Date</label>
                <input type="date" id="addTask-duedate" name="duedate" required>

                <label for="status">Status</label>
                <select id="addTask-status" name="status">
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                    <option value="Overdue">Overdue</option>
                </select>

                <label for="category">Category</label>
                <!-- This will be filled like the task table except we pull user categories -->
                <select id="addTask-category" name="categoryid"></select>

                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>
    <!-- TODO ADD CATEGORY MODAL -->

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

    <!-- This generates the tables based on filtering-->
    <script type='text/javascript'>
        document.getElementById("applyFilters").addEventListener("click", applyFilters);

        function applyFilters() {
            const selectedStatuses = Array.from(document.querySelectorAll(".filter-status:checked")).map(ele => ele.value);
            const selectedCategories = Array.from(document.querySelectorAll(".filter-category:checked")).map(ele => ele.value);

            fetch("includes/fetchTasks.inc.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "applications/json",
                        },
                    body: JSON.stringify({statuses: selectedStatuses, categories: selectedCategories,}),
                    })
                    .then(response => response.json())
                    .then(tasks => {
                        renderTaskList(tasks);
                    })
        }

        function renderTaskList(tasks) {
            const taskListElement = document.getElementById("taskList");

            if (!tasks || tasks.length === 0) {
                taskListElement.innerHTML = "<tr><td colspan = '5'> No tasks found.</td></tr>";
                return;
            }

            taskListElement.innerHTML = tasks.map(task =>
                        `<tr">
                                <td>${task.title}</td>
                                <td>${task.duedate}</td>
                                <td>${task.status}</td>
                                <td data-categoryid="${task.categoryid}">${task.categoryname}</td>
                                <td>
                                    <button class="editBtn" data-taskid="${task.taskid}">Edit</button>
                                    <button class="deleteBtn" data-taskid="${task.taskid}">Delete</button>
                                </td>
                            </tr>`).join(""); /* Must have this to combine table rows generated by array without ',' between rows. */

                            /* Add functions to buttons since javascript doesn't want to play nice with DOM loading */
                            addDelete();
                            addEdit();
        }

        document.addEventListener("DOMContentLoaded", applyFilters);
    </script>

    <!-- Delete Task Button -->
    <script type='text/javascript'>
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

    <!-- Edit Task Button -->
    <script>
        document.getElementById("editTaskForm").addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            fetch("includes/updateTask.php", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                document.getElementById("taskEditingModal").style.display = "none";
                alert("Task updated successfully!");
                applyFilters();
                })
        });

        function addEdit() {
            const editButtons = document.querySelectorAll(".editBtn");
            const editTaskModal = document.getElementById("taskEditingModal");
            const closeModal =  document.getElementById("edit-closeModal");
            const editTaskForm = document.getElementById("editTaskForm");

            editButtons.forEach(button => {
                button.addEventListener("click", e=> {
                    const taskID = e.target.getAttribute("data-taskid");
                    
                    // Get the task data
                    fetch(`includes/getTask.php?taskid=${taskID}`)
                    .then(response => response.json())
                    .then(data => {

                        if (data.error) {
                            alert(data.error);
                            return;
                        }
                        
                        // Fill selector fields
                        document.getElementById("edit-taskid").value = data.taskid;
                        document.getElementById("edit-title").value = data.title;
                        document.getElementById("edit-description").value = data.description;
                        document.getElementById("edit-duedate").value = data.duedate;
                        document.getElementById("edit-status").value = data.status;

                        // Dynamically fill the category dropdown
                        const categorySelector = document.getElementById("category");
                        categorySelector.innerHTML = "";

                        data.categories.forEach(category => {
                            const optionElement = document.createElement("option");
                            optionElement.value = category.categoryid;
                            optionElement.textContent = category.name;
                            categorySelector.appendChild(optionElement);

                            // Set the task's current category as default selected option.
                            if (category.categoryid == data.categoryid)
                                optionElement.selected = true;
                        });
                        editTaskModal.style.display = "flex";
                    });
                });
            });

            closeModal.addEventListener("click", () => {
                editTaskModal.style.display = "none";
            });

            window.addEventListener("click", (e) => {
                if (e.target === editTaskModal)
                    editTaskModal.style.display = "none";
            });
        }
    </script>

    <!-- Category filter fill -->
    <script text='text/javascript'>
        function fillCategoryFilter() {
            fetch("includes/getCategories.php")
            .then(response => response.json())
            .then(categories => {
                const categoryFilter = document.getElementById("filterCategories");
                filterCategories.innerHTML = "";

                categories.forEach(category => {
                    const checkbox = document.createElement("label");
                    checkbox.innerHTML = `<input type="checkbox" class ="filter-category" value="${category.categoryid}"> ${category.name}`

                    categoryFilter.appendChild(checkbox);
                })
            })
        }
        document.addEventListener("DOMContentLoaded", fillCategoryFilter);
    </script>

    <!-- Add Task Modal -->
    <script text="text/javascript">
        function addTask() {
            const addTaskModal = document.getElementById("addTaskModal");
            const closeModal =  document.getElementById("addTask-closeModal");
            const addTaskForm = document.getElementById("addTaskForm");
            const addTaskButton = document.getElementById("addTaskBtn");

            fetch("includes/getCategories.php")
            .then(response => response.json())
            .then(categories => {
                const addTaskCategorySelector = document.getElementById("addTask-category");
                addTaskCategorySelector.innerHTML = "";

                categories.forEach(category => {
                    const option = document.createElement("option");
                    option.value = category.categoryid;
                    option.textContent = category.name;
                    addTaskCategorySelector.appendChild(option);
                });
            })


            document.getElementById("addTaskForm").addEventListener("submit", function (e) {
                e.preventDefault();

                const formData = new FormData(this);

                console.log(formData);

                fetch("includes/addTask.php", {
                    method: "POST",
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    document.getElementById("addTaskModal").style.display = "none";
                    alert("Task added successfully!");
                    applyFilters();
                    })
            });


            addTaskButton.addEventListener("click", () => {
                addTaskModal.style.display = "flex";
            });

            closeModal.addEventListener("click", () => {
                addTaskModal.style.display = "none";
            });

            window.addEventListener("click", (e) => {
                if (e.target === addTaskModal)
                    addTaskModal.style.display = "none";
            });
        }

        document.addEventListener("DOMContentLoaded", addTask);
    </script>

</body>
</html>