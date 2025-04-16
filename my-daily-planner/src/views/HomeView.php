<?php

namespace RalucaAdam\MyDailyPlanner\views;

use RalucaAdam\MyDailyPlanner\models\User;

class HomeView
{
    public function render(User $user, $tasksThisWeek, $tasks, $expiredTasks)
    {
        $tasksHtml = '';
        foreach ($tasksThisWeek as $task) {
            $priorityClass = match ($task['priority']) {
                'High' => 'high-priority',
                'Medium' => 'medium-priority',
                'Low' => 'low-priority',
                default => '',
            };

            $dueDate = date('Y-m-d', strtotime($task['due_date']));
            $tasksHtml .= "
            <div class='task' id='task-{$task['task_id']}'>  
                <h4>{$task['title']} <span class='due-date'>Due: {$dueDate}</span></h4>
                <p>{$task['description']}</p>
                <p><strong>Priority:</strong> <span class='{$priorityClass}'>{$task['priority']}</span></p>
                <p><strong>Category:</strong> {$task['category_name']}</p>
                <a href='/task/edit/{$task['task_id']}' class='edit-task'>Edit</a>
                <button class='delete-task' data-task-id='{$task['task_id']}'>Delete</button>
            </div>";
        }

        $tasksHtmlRemaining = '';
        foreach ($tasks as $task) {
            $priorityClass = match ($task['priority']) {
                'High' => 'high-priority',
                'Medium' => 'medium-priority',
                'Low' => 'low-priority',
                default => '',
            };

            $dueDate = date('Y-m-d', strtotime($task['due_date']));
            $tasksHtmlRemaining .= "
            <div class='task' id='task-{$task['task_id']}'>  
                <h4>{$task['title']} <span class='due-date'>due: {$dueDate}</span></h4>
                <p>{$task['description']}</p>
                <p><strong>Priority:</strong> <span class='{$priorityClass}'>{$task['priority']}</span></p>
                <p><strong>Category:</strong> {$task['category_name']}</p>
                <a href='/task/edit/{$task['task_id']}' class='edit-task'>Edit</a>
                <button class='delete-task' data-task-id='{$task['task_id']}'>Delete</button>
            </div>";
        }

        $tasksHtmlExpired = '';
        foreach ($expiredTasks as $task) {
            $priorityClass = match ($task['priority']) {
                'High' => 'high-priority',
                'Medium' => 'medium-priority',
                'Low' => 'low-priority',
                default => '',
            };

            $dueDate = date('Y-m-d', strtotime($task['due_date']));
            $tasksHtmlExpired .= "
            <div class='task' id='task-{$task['task_id']}'>  
                <h4>{$task['title']} <span class='due-date'>Due: {$dueDate}</span></h4>
                <p>{$task['description']}</p>
                <p><strong>Priority:</strong> <span class='{$priorityClass}'>{$task['priority']}</span></p>
                <p><strong>Category:</strong> {$task['category_name']}</p>
                <a href='/task/edit/{$task['task_id']}' class='edit-task'>Edit</a>
                <button class='delete-task' data-task-id='{$task['task_id']}'>Delete</button>
            </div>";
        }

        return "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>My Daily Planner</title>
            <link rel='stylesheet' href='/assets/css/Home.css?v=1.0.1'>
            <script src='/assets/js/home.js' defer></script>
            <script src='/assets/js/logout.js' defer></script>
        </head>
        <body>
            <div class='container'>
                <nav class='navbar'>
                    <ul>
                        <li><a href='#home'>Home</a></li>
                        <li><a href='#thisweek'>This Week</a></li>
                        <li><a href='#upcoming'>Upcoming Tasks</a></li>
                        <li><a href='#overdue'>Overdue</a></li>
                        <li><button id='logout-button'>Logout</button></li>
                    </ul>
                </nav>
                <section id='home'>
                    <div class='flex-container'>
                        <div>
                            <h1>Welcome, {$user->getName()}!</h1>
                        </div>
                        <div class='button-container'>
                            <button class='create-task-button' onclick=\"window.location.href='/tasks/create'\">Create New Task</button>
                        </div>
                    </div>
                </section>
                <section id='thisweek'>
                    <h2>This Week's Tasks</h2>
                    <div class='tasks'>
                        {$tasksHtml}
                    </div>
                </section>
                <section id='upcoming'>
                    <h2>Upcoming Tasks</h2>
                    <div class='tasks'>
                        {$tasksHtmlRemaining}
                    </div>
                </section>
                <section id='overdue'>
                    <h2>Overdue Tasks</h2>
                    <div class='tasks'>
                        {$tasksHtmlExpired}
                    </div>
                </section>
            </div>
        </body>
        </html>";
    }
}

?>
