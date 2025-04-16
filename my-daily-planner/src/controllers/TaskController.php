<?php

namespace RalucaAdam\MyDailyPlanner\controllers;

use RalucaAdam\MyDailyPlanner\models\Task;
use RalucaAdam\MyDailyPlanner\models\Category;
use RalucaAdam\MyDailyPlanner\helpers\Database;

class TaskController
{
    public function index()
    {
        session_start();
        $user_id = $_SESSION['user_id'];
        $tasks = Task::getAllByUserId($user_id);  // Retrieve tasks from DB
        include 'views/tasks/index.php';  // Load task listing view
    }

    public function create()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            echo "You must be logged in to create a task.";
            exit();
        }

        $categoryModel = new Category();
        $categories = $categoryModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task = new Task();
            $task->title = $_POST['title'];
            $task->description = $_POST['description'];
            $task->due_date = $_POST['due_date'];
            $task->user_id = $_SESSION['user_id'];
            $task->category_id = $_POST['category']; 
            $task->priority = $_POST['priority'];    

            $task->save(); 

            header('Location: /home'); 
            exit();
        } else {
            include __DIR__ . '/../views/tasks/create.php';  
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task = new Task();
            $task = $task->findById($id);
    
            if (!$task) {
                echo "Task not found!";
                exit; 
            }
    
            if (isset($_POST['title']) && $_POST['title'] !== '') {
                $task->title = $_POST['title'];
            }
    
            if (isset($_POST['description']) && $_POST['description'] !== '') {
                $task->description = $_POST['description'];
            }
    
            if (isset($_POST['due_date']) && $_POST['due_date'] !== '') {
                $task->due_date = $_POST['due_date'];
            }
    
            if (isset($_POST['priority']) && $_POST['priority'] !== '') {
                $task->priority = $_POST['priority'];
            }
    
            $task->save();  
            header('Location: /home'); 
        } else {
            $task = new Task();
            $task = $task->findById($id);
    
            if (!$task) {
                echo "Task not found!";
                exit;
            }
            include __DIR__ . '/../views/tasks/edit.php'; 
        }
    }    

    public function delete()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id'])) {
            $taskId = $data['id'];
            try {
                $sql = 'DELETE FROM tasks WHERE id = :id';
                $params = ['id' => $taskId];
                Database::query($sql, $params);  

                echo json_encode(['status' => 'success', 'message' => 'Task deleted successfully']);
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete task: ' . $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Task ID is required']);
        }
    }
    
}
?>
