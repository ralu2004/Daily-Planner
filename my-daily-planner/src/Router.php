<?php
namespace RalucaAdam\MyDailyPlanner;

use RalucaAdam\MyDailyPlanner\controllers\HomeController;
use RalucaAdam\MyDailyPlanner\controllers\LogInSignUpController;
use RalucaAdam\MyDailyPlanner\controllers\TaskController;
use RalucaAdam\MyDailyPlanner\controllers\UserController;

class Router
{
    public function route()
    {
        // Normalize URI
        $uri = $_SERVER['REQUEST_URI'] ?? $_SERVER['PHP_SELF'];
        $uri = rtrim(parse_url($uri, PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];

        // Routing Logic
        switch ($uri) {
            case '':
            case '/':
                $controller = new LogInSignUpController();
                if ($method === 'POST') {
                    $controller->handleFormSubmission();
                } else {
                    $controller->showForm();
                }
                break;

            case '/home':
                $controller = new HomeController();
                echo $controller->index();
                break;

            case '/tasks/create':
                $controller = new TaskController();
                echo $controller->create(); 
                break;

            case '/delete-task':
                if ($method === 'POST') {
                    $controller = new TaskController();
                    echo $controller->delete(); 
                }
                break;

            case preg_match('/^\/task\/edit\/(\d+)$/', $uri, $matches) ? true : false:
                $controller = new TaskController();
                $controller->edit($matches[1]); // The task ID will be in $matches[1]
                break;

            case '/password':
                $controller = new UserController();
                $controller->resetPassword();
                break;

            case '/reset-password':
                $controller = new UserController();
                if ($method === 'POST') {
                    $controller->handleResetPassword();
                }
                break;

            case '/logout':
                $controller = new UserController();
                $controller->logout();
                break;
                
            default:
                http_response_code(404);
                echo "404 Not Found";
                break;
        }
    }
}
?>