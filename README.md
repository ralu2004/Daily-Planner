# 🗓️ Daily Planner Web Application

A simple yet powerful Daily Planner web app designed to help users efficiently manage their daily tasks. Built with the **MVC architecture**, this app cleanly separates data handling, business logic, and user interface — ensuring maintainability and scalability.

---

## 🎯 Features

- Full **CRUD** operations: Create, Read, Update, and Delete tasks effortlessly  
- Organize tasks by **date and time** for effective daily planning  
- Clean, **responsive UI** that works seamlessly across devices  
- Smooth user experience with dynamic, interactive elements  

---

## 🛠️ Tech Stack

- **PHP** – Backend logic and MVC framework structure  
- **PostgreSQL** – Robust database for persistent task storage  
- **HTML5 & CSS3** – Responsive and modern frontend design  
- **JavaScript** – Dynamic behavior and UI interactivity  

---

## 🧩 Architecture

This application follows the **Model-View-Controller (MVC)** pattern to keep the code modular and maintainable:

- **Model:** Handles data and business logic (task management, database interactions)  
- **View:** Responsible for displaying the UI to the user (HTML/CSS templates)  
- **Controller:** Processes user input and interacts with the Model to update Views accordingly  

---

## 🚀 Getting Started

1. **Clone the repository:**  
   ```bash
   git clone https://github.com/your-username/daily-planner.git
   cd daily-planner
   ```
2. **Set up the PostgreSQL database:**
   Create a database named daily_planner:
   ```sql
   CREATE DATABASE daily_planner;
   ```
   Import the provided schema (replace path/to/schema.sql with the actual path):
   ```bash
   psql -U your_username -d daily_planner -f path/to/schema.sql
   ```
   3. **Configure the database connection:**
   ```php
   <?php
    $db_host = 'localhost';
    $db_name = 'daily_planner';
    $db_user = 'your_username';
    $db_pass = 'your_password';
    
    $dsn = "pgsql:host=$db_host;dbname=$db_name";
    try {
        $pdo = new PDO($dsn, $db_user, $db_pass);
        // Set error mode
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    ?>
    ```
   4. **Run the application:**
   Host the project on a local server with PHP support (e.g., Apache, Nginx) and open it in your browser.

## License
This project is licensed under the MIT License.

## Author
Raluca Adam  
GitHub: [@ralu2004](https://github.com/ralu2004)


  
