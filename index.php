<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'config.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/DashboardController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/MateriController.php';

function getTitle($route)
{
    $titles = [
        'dashboard' => 'Dashboard Page',
        'login' => 'Login Page',
        'master-user' => 'User Page',
        'master-materi' => 'Materi Page',
    ];

    return isset($titles[$route]) ? $titles[$route] : 'Default Title';
}

$route = isset($_GET['route']) ? $_GET['route'] : 'home';

include "app/view/partials/head.php";

switch ($route) {
    case '':
    case 'dashboard':
        DashboardController::dashboardView();
        break;
    case 'master-user':
        UserController::userView();
        break;
    case 'master-materi':
        MateriController::materiView();
        break;
    case 'login':
        AuthController::loginView();
        break;
    default:
        include __DIR__ . '/app/view/NotFound.php';
        break;
}

include "app/view/partials/footer.php";
