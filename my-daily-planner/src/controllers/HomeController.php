<?php

namespace RalucaAdam\MyDailyPlanner\controllers;

use RalucaAdam\MyDailyPlanner\views\HomeView;
use RalucaAdam\MyDailyPlanner\models\User;
use RalucaAdam\MyDailyPlanner\models\Task;

class HomeController
{
    public function index()
    {
        $user = $this->getCurrentUser();
        if ($user) {
            $tasksThisWeek = Task::getTasksDueThisWeek($user->getId()); 
            $tasks = Task::getRemainingTasks($user->getId());
            $expiredTasks = Task::getExpiredTasks($user->getId());
            $view = new HomeView();
        return $view->render($user, $tasksThisWeek, $tasks, $expiredTasks);

            return $view->render($user);
        } else {
            header('Location: /');
            exit();
        }
    }

    private function getCurrentUser()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $user = new User();
            $user->setId($userId);
            $userData = $user->findById($userId);
            if ($userData) {
                $user->setName($userData['name']);
                $user->setEmail($userData['email']);
                return $user;
            }
        }
        return null;
    }
}
?>