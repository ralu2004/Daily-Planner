<?php

namespace RalucaAdam\MyDailyPlanner\controllers;

use RalucaAdam\MyDailyPlanner\models\User;

class LogInSignUpController
{
    public function showForm()
    {
        $view = new \RalucaAdam\MyDailyPlanner\views\LogInSignUpView();
        $view->render();
    }

    public function handleFormSubmission()
    {
        header('Content-Type: application/json'); // Force JSON response for all AJAX requests

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            exit();
        }

        if (isset($_POST['email'], $_POST['password']) && !isset($_POST['name'])) {
            $this->logIn();
        } elseif (isset($_POST['name'], $_POST['email'], $_POST['password'])) {
            $this->signUp();
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
            exit();
        }
    }

    private function logIn()
    {
        $user = new User();
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);

        $foundUser = $user->findByEmail();
        if ($foundUser && password_verify($_POST['password'], $foundUser['password'])) {
            session_start();
            $_SESSION['user_id'] = $foundUser['id'];
            echo json_encode(['success' => true, 'message' => 'Login successful.']);
        } else {
            http_response_code(401); // Unauthorized
            echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
        }
        exit();
    }

    private function signUp()
    {
        $user = new User();
        $user->setName($_POST['name']);
        $user->setEmail($_POST['email']);
        $user->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT));
        $user->setCreatedAt(date('Y-m-d H:i:s'));

        if ($user->register()) {
            session_start();
            $_SESSION['user_id'] = $user->getId();
            echo json_encode(['success' => true, 'message' => 'Registration successful.']);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Failed to register user.']);
        }
        exit();
    }

    public function logOut()
    {
        session_start();
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'User logged out successfully!']);
    }
}
