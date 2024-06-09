<?php
session_start();
require_once 'app/controllers/MateriController.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'add':
            MateriController::createMateri();
            break;
        case 'update':
            MateriController::updateMateriById();
            break;
        case 'delete':
            MateriController::deleteMateriById();
            break;
        default:
            echo "Invalid action.";
            break;
    }
} else {
    echo "No action specified.";
}
