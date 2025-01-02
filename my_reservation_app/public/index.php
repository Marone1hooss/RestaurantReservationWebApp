<?php
// public/index.php

session_start();

// Include the database config
require_once __DIR__ . '/../config/database.php';

// Autoload or manually include the Controllers/Models
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/MenuController.php';
require_once __DIR__ . '/../app/Controllers/ReservationController.php';

use App\Controllers\AuthController;
use App\Controllers\MenuController;
use App\Controllers\ReservationController;

// Determine which controller and action to call
$controller = $_GET['controller'] ?? 'auth';   // default = auth
$action     = $_GET['action']     ?? 'login';  // default = login

// Instantiate the right controller
switch ($controller) {
    case 'auth':
        $ctrl = new AuthController($pdo);
        break;
    case 'menu':
        $ctrl = new MenuController($pdo);
        break;
    case 'reservation':
        $ctrl = new ReservationController($pdo);
        break;
    default:
        $ctrl = new AuthController($pdo);
        break;
}

// Call the action method if it exists
if (method_exists($ctrl, $action)) {
    $ctrl->$action();
} else {
    echo "Action <strong>$action</strong> not found in controller <strong>$controller</strong>.";
}
