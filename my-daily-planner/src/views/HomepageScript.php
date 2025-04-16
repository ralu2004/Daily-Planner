<?php
include_once 'Task.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        // Create new task logic
        $task = new Task();
        $task->title = $_POST['title'];
        $task->description = $_POST['description'];
        $task->due_date = $_POST['due_date'];
        $task->priority = $_POST['priority'];
        $task->category_id = $_POST['category_id'];
        $task->user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session
        $task->created_at = date("Y-m-d H:i:s");
        $task->create();  // Save task to DB
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'edit') {
        // Edit task logic
        $task = Task::findById($_POST['task_id']);
        $task->title = $_POST['title'];
        $task->description = $_POST['description'];
        $task->due_date = $_POST['due_date'];
        $task->priority = $_POST['priority'];
        $task->category_id = $_POST['category_id'];
        $task->save();  // Update task
        echo json_encode(['success' => true]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] === 'list') {
        // Fetch and return list of tasks
        $tasks = Task::getAllByUserId($_SESSION['user_id']);
        echo json_encode(['tasks' => $tasks]);
        exit;
    }
}

?>
