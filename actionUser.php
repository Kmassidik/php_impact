<?php
session_start();
require_once 'app/controllers/UserController.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'add':
            UserController::createUser();
            break;
        case 'update':
            UserController::updateUserById();
            break;
        case 'delete':
            UserController::deleteUserById();
            break;
        default:
            echo "Invalid action.";
            break;
    }
} else {
    echo "No action specified.";
}
