<?php
// app/Controllers/ReservationController.php
namespace App\Controllers;
require_once __DIR__ . '/../Models/ReservationModel.php';
use App\Models\ReservationModel;
use App\Models\MenuModel;

require_once __DIR__ . '/../Models/MenuModel.php';
require_once __DIR__ . '/../Models/ReservationModel.php';

use PDO;

class ReservationController {
    private $pdo;
    private $reservationModel;
    private $menuModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->reservationModel = new ReservationModel($pdo);
        $this->menuModel        = new MenuModel($pdo);
    }

    // Student main page after login
    public function index() {
        // Simple check: Only allow if user is student
        if ($_SESSION['user_type'] !== 'student') {
            header('Location: index.php');
            exit;
        }
        require_once __DIR__ . '/../Views/restaurant-template/index.html';
    }

    // Show all reservations for the logged-in student
    public function manage() {
        $userId = $_SESSION['user_id'];
        $reservations = $this->reservationModel->getByUser($userId);
        require_once __DIR__ . '/../Views/reservation/manage.php';
    }

   // Add a new reservation
public function add() {
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId   = $_SESSION['user_id'];
        $date     = $_POST['reservation_date'] ?? date('Y-m-d');
        $mealType = $_POST['meal_type']        ?? 'breakfast';
        $quantity = $_POST['quantity']         ?? 1;
        $contents = $_POST['contents']        ?? 'standard breakfast';

        // Time-based logic
        $today = date('Y-m-d');
        if ($date === $today) {
            $hour = date('H'); // 24-hour format
            if ($mealType === 'breakfast' && $hour >= 9) {
                $error = "Cannot reserve breakfast after 09:00 AM today.";
            } elseif ($mealType === 'lunch' && $hour >= 15) {
                $error = "Cannot reserve lunch after 15:00 (3 PM) today.";
            } elseif ($mealType === 'dinner' && $hour >= 22) {
                $error = "Cannot reserve dinner after 10:00 PM today.";
            }
        }

        // Day of the week logic
        $dayOfWeek = date('l', strtotime($date));
        $validMenuItems = $this->menuModel->getItemsByDayAndMealType($dayOfWeek, $mealType);

        if (!in_array($contents, array_column($validMenuItems, 'item_name'))) {
            $error = "Invalid selection. The chosen content does not match the menu for $mealType on $dayOfWeek.Available items are:";
            foreach ($validMenuItems as $menuItem) {
                $error .= "- " . htmlspecialchars($menuItem['item_name']) ;
            }
        }
        
        // If there is an error, render the form again
        if (!empty($error)) {
            require_once __DIR__ . '/../Views/reservation/add.php';
            return;
        }

        // Compute total price
        $totalPrice = 0;
        if ($mealType === 'breakfast') {
            $totalPrice = 15 * $quantity;
        } elseif ($mealType === 'lunch') {
            $totalPrice = 25 * $quantity;
        } else {
            $totalPrice = 20 * $quantity;
        }

        // Create the reservation
        $this->reservationModel->createReservation(
            $userId, $date, $mealType, $contents, $quantity, $totalPrice
        );
        header('Location: index.php?controller=reservation&action=manage');
        exit;
    }

    // Render the form for GET requests
    require_once __DIR__ . '/../Views/reservation/add.php';
}


    public function edit() {
        
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=reservation&action=manage');
            exit;
        }

        $reservation = $this->reservationModel->findById($id);
        if (!$reservation) {
            header('Location: index.php?controller=reservation&action=manage');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contents   = $_POST['contents']  ?? $reservation['contents'];
            $quantity   = $_POST['quantity']  ?? $reservation['quantity'];
            // Determine meal type and day of the week from the reservation
            $mealType  = $reservation['meal_type'];
            $dayOfWeek = date('l', strtotime($reservation['reservation_date']));

            // Fetch valid items for the meal type and day of the week
            $validMenuItems = $this->menuModel->getItemsByDayAndMealType($dayOfWeek, $mealType);

            // Check if the chosen content is valid
            if (!in_array($contents, array_column($validMenuItems, 'item_name'))) {
                $error = "Invalid selection. The chosen content does not match the menu for $mealType on $dayOfWeek.Available items are:";

                // Append available items to the error message
                foreach ($validMenuItems as $menuItem) {
                    $error .= "- " . htmlspecialchars($menuItem['item_name']) ;
                }

                // Render the edit form again with the error message
                require_once __DIR__ . '/../Views/reservation/edit.php';
                return;}
            // Recalculate total price if needed
            // This is simplistic: we assume meal_type didn’t change
            $totalPrice = 0;
            if ($mealType === 'breakfast') {
                $totalPrice = 15 * $quantity;
            } elseif ($mealType === 'lunch') {
                $totalPrice = 25 * $quantity;
            } else {
                $totalPrice = 20 * $quantity;
            }

            $this->reservationModel->updateReservation($id, $contents, $quantity, $totalPrice);
            header('Location: index.php?controller=reservation&action=manage');
            exit;
        }

        require_once __DIR__ . '/../Views/reservation/edit.php';
    }

    public function delete() {
        
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->reservationModel->deleteReservation($id);
        }
        header('Location: index.php?controller=reservation&action=manage');
    }
}
