<?php
session_start();
require_once 'app/controllers/AuthController.php';
AuthController::authLogin();
