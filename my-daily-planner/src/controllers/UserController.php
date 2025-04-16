<?php

namespace RalucaAdam\MyDailyPlanner\controllers;

use RalucaAdam\MyDailyPlanner\models\User;
use RalucaAdam\MyDailyPlanner\views\ForgotPasswordView;

class UserController
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
            $user = new User();
            $user->setName($_POST['name']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $user->setCreatedAt(date('Y-m-d H:i:s'));

            if ($user->register()) {
                echo json_encode(['success' => true, 'message' => 'User registered successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to register user.']);
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
            $this->login();
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);

            $foundUser = $user->findByEmail();
            if ($foundUser && password_verify($_POST['password'], $foundUser['password'])) {
                echo json_encode(['success' => true, 'message' => 'User logged in successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
            }
        }
    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            session_destroy();
            echo json_encode(['success' => true, 'message' => 'User logged out successfully!']);
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            exit();
        }
    }



    public function resetPassword()
    {
        $view = new ForgotPasswordView();
        echo $view->render();
    }

    public function handleResetPassword()
    {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmNewPassword = $_POST['confirm_new_password'] ?? '';

        if ($newPassword !== $confirmNewPassword) {
            echo json_encode(['success' => false, 'message' => 'New passwords do not match.']);
            return;
        }

        $user = new User();
        $userData = $user->findByUsernameAndEmail($username, $email);

        if (!$userData) {
            echo json_encode(['success' => false, 'message' => 'User not found.']);
            return;
        }

        $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $user->setId($userData['id']);
        $user->setPassword($hashedNewPassword);
        if ($user->updatePassword()) {
            echo json_encode(['success' => true, 'message' => 'Password reset successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to reset password.']);
        }
    }
}
?>