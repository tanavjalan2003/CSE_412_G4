# Task Managing System

Welcome to the **Task Managing System**, an intuitive web application designed to help you efficiently manage your tasks with ease and functionality.

---

## Table of Contents
- [Features](#features)
- [Technologies Used](#technologies-used)
- [File Structure](#file-structure)
- [How to Use](#how-to-use)
- [Customization Guide](#customization-guide)
- [Acknowledgments](#acknowledgments)
- [Contact](#contact)

---

## Features
- **User Authentication**: Secure sign-up and login functionality with password hashing.
- **Task Management**: Create, update, delete, and categorize tasks effortlessly.
- **Calendar View**: Visualize tasks based on dates.
- **Analytics Dashboard**: Track and analyze task completion trends.
- **Responsive Design**: Seamlessly accessible on various devices.
- **User Profile**: Update personal details quickly.

---

## Technologies Used
- **PHP**: Backend server logic and data handling.
- **MySQL**: Database management for user data and tasks.
- **HTML/CSS**: Webpage structure and styling.
- **JavaScript**: Dynamic and interactive elements.
- **AJAX**: Asynchronous updates for a smooth user experience.

---

## File Structure
```
project-root/
│
├── css/
│   └── styles.css                # Main stylesheet
│
├── includes/
│   ├── addCategory.php           # Adds new task categories
│   ├── addTask.php               # Handles new task creation
│   ├── dbh.inc.php               # Database connection setup
│   ├── deleteCategory.php        # Deletes a task category
│   ├── deleteTask.inc.php        # Deletes specific tasks
│   ├── fetchTasks.inc.php        # Retrieves tasks for display
│   ├── functions.inc.php         # Contains helper functions for analytics
│   ├── getCategories.php         # Retrieves task categories
│   ├── getTask.php               # Fetches data for task editing
│   ├── hashPasswords.php         # Password hashing logic
│   ├── login.inc.php             # Handles user login
│   ├── logout.inc.php            # Handles user logout
│   ├── signup.inc.php            # Handles user registration
│   ├── updateAnalytics.php       # Updates analytics data
│   ├── updateProfile.inc.php     # Handles profile updates
│   └── updateTask.php            # Updates task information
│
├── css/                          # Styles folder
│   └── styles.css                # Main CSS file
│
├── index.php                     # Main landing page
├── login.php                     # Login page
├── profile.php                   # Profile page
├── script.js                     # JavaScript functionality
├── signup.php                    # Signup page
└── README.md                     # This file
```

---

## How to Use
1. **Clone the Repository**  
   Clone the project repository to your local machine:  
   ```bash
   git clone <repository-url>
   ```
2. **Navigate to the Root Folder**  
   Change your working directory to the project's root folder:  
   ```bash
   cd project-folder
   ```
3. **Start the PHP Server**  
   Run the following command to start the server:  
   ```bash
   php -S 127.0.0.1:8000
   ```
4. **Open the Application**  
   Open your browser and visit:  
   [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Customization Guide
1. **Change Styles**  
   Update the `styles.css` file to modify the appearance.
2. **Modify PHP Logic**  
   Edit the PHP files in the `includes/` folder for new features or logic changes.
3. **Update Database Configuration**  
   Modify `dbh.inc.php` to change database credentials or structure.
4. **Add New Pages**  
   Create a new `.php` file and link it within the navigation structure.

---

## Acknowledgments
This project is built with inspiration from task management needs and collaboration tools. Thanks to contributors for their hard work and dedication.

---

## Contact
For any queries or suggestions, feel free to reach out
