<?php

namespace RalucaAdam\MyDailyPlanner\models;

use DateTime;

class Task extends Model
{
    public $id;
    public $user_id;
    public $title;
    public $description;
    public $due_date;
    public $priority;
    public $category_id;
    public $created_at;

    public function create()
    {
        $sql = "INSERT INTO tasks (user_id, title, description, due_date, priority, category_id, created_at) 
                VALUES (:user_id, :title, :description, :due_date, :priority, :category_id, :created_at)";
        $params = [
            ':user_id' => $this->user_id,
            ':title' => $this->title,
            ':description' => $this->description,
            ':due_date' => $this->due_date,
            ':priority' => $this->priority,
            ':category_id' => $this->category_id,
            ':created_at' => $this->created_at
        ];
        return $this->query($sql, $params);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM tasks WHERE id = :id LIMIT 1";
        $taskData = $this->fetchOne($sql, [':id' => $id]);

        if ($taskData) {
            $task = new Task();
            $task->id = $taskData['id'];
            $task->user_id = $taskData['user_id'];
            $task->title = $taskData['title'];
            $task->description = $taskData['description'];
            $task->due_date = $taskData['due_date'];
            $task->priority = $taskData['priority'];
            $task->category_id = $taskData['category_id'];
            $task->created_at = $taskData['created_at'];
    
            return $task;
        }

        return null;
    }

    public static function getTasksByUser($user_id)
    {
        $sql = "SELECT * FROM tasks WHERE user_id = :user_id";
        return self::fetchAll($sql, [':user_id' => $user_id]); 
    }

    public static function getTasksDueThisWeek($user_id)
    {
        $startOfWeek = new DateTime('monday this week');
        $endOfWeek = new DateTime('sunday this week');
        
        $startOfWeek = $startOfWeek->format('Y-m-d');
        $endOfWeek = $endOfWeek->format('Y-m-d');
        
        $sql = "SELECT * FROM tasks_with_categories
                WHERE user_id = :user_id 
                AND due_date BETWEEN :start_of_week AND :end_of_week";
        
        return self::fetchAll($sql, [
            ':user_id' => $user_id,
            ':start_of_week' => $startOfWeek,
            ':end_of_week' => $endOfWeek
        ]);
    }

    public static function getRemainingTasks($user_id)
    {
        $endOfWeek = new DateTime('sunday this week');
        $endOfWeek = $endOfWeek->format('Y-m-d');

        $sql = "SELECT * FROM tasks_with_categories
                WHERE user_id = :user_id 
                AND due_date > :end_of_week";
        
        return self::fetchAll($sql, [':user_id' => $user_id, ':end_of_week' => $endOfWeek]);
    }

    public static function getExpiredTasks($user_id)
    {
        $today = new DateTime();
        $today = $today->format('Y-m-d');

        $sql = "SELECT * FROM tasks_with_categories
                WHERE user_id = :user_id 
                AND due_date < :today";
        
        return self::fetchAll($sql, [':user_id' => $user_id, ':today' => $today]);
    }
    
    public function save()
    {
        if ($this->id) {
            $sql = "UPDATE tasks SET title = :title, description = :description, due_date = :due_date, category_id = :category_id, priority = :priority WHERE id = :id";
            $params = [
                ':id' => $this->id,
                ':title' => $this->title,
                ':description' => $this->description,
                ':due_date' => $this->due_date,
                ':category_id' => $this->category_id,
                ':priority' => $this->priority
            ];
            return $this->query($sql, $params);  
        } else {
            $sql = "INSERT INTO tasks (user_id, title, description, due_date, category_id, priority) VALUES (:user_id, :title, :description, :due_date, :category_id, :priority)";
            $params = [
                ':user_id' => $this->user_id,
                ':title' => $this->title,
                ':description' => $this->description,
                ':due_date' => $this->due_date,
                ':category_id' => $this->category_id,
                ':priority' => $this->priority
            ];
            return $this->query($sql, $params);  
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDueDate()
    {
        return $this->due_date;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setDueDate($due_date)
    {
        $this->due_date = $due_date;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
}
?>