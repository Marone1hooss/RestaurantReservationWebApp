<?php
// app/Controllers/ReservationController.php
namespace App\Controllers;

use App\Models\ReservationModel;
use App\Models\MenuModel;
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
        require_once __DIR__ . '/../Views/reservation/index.php';
    }

    // Show all reservations for the logged-in student
    public function manage() {
        if ($_SESSION['user_type'] !== 'student') {
            header('Location: index.php');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $reservations = $this->reservationModel->getByUser($userId);
        require_once __DIR__ . '/../Views/reservation/manage.php';
    }

    // Add a new reservation
    public function add() {
        if ($_SESSION['user_type'] !== 'student') {
            header('Location: index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId   = $_SESSION['user_id'];
            $date     = $_POST['reservation_date'] ?? date('Y-m-d');
            $mealType = $_POST['meal_type']        ?? 'breakfast';
            $quantity = $_POST['quantity']         ?? 1;

            // (Optional) For lunch/dinner, we might store item details in JSON:
            $contents = $_POST['contents'] ?? 'standard breakfast';

            // Time-based logic:
            $today = date('Y-m-d');
            if ($date === $today) {
                $hour = date('H'); // 24-hour format
                // cutoff checks
                if ($mealType === 'breakfast' && $hour >= 9) {
                    $error = "Cannot reserve breakfast after 09:00 AM today.";
                } elseif ($mealType === 'lunch' && $hour >= 15) {
                    $error = "Cannot reserve lunch after 15:00 (3 PM) today.";
                } elseif ($mealType === 'dinner' && $hour >= 22) {
                    $error = "Cannot reserve dinner after 22:00 (10 PM) today.";
                }
            }

            // Compute total_price if you have item prices, etc.
            $totalPrice = 0;
            if ($mealType === 'breakfast') {
                // Example default
                $totalPrice = 15 * $quantity;
            } elseif ($mealType === 'lunch') {
                $totalPrice = 25 * $quantity;
            } else {
                $totalPrice = 20 * $quantity;
            }

            if (!isset($error)) {
                // All good, create reservation
                $this->reservationModel->createReservation(
                    $userId, $date, $mealType, $contents, $quantity, $totalPrice
                );
                header('Location: index.php?controller=reservation&action=manage');
                exit;
            }
        }

        // If GET, or if we have an $error, show the form again
        require_once __DIR__ . '/../Views/reservation/add.php';
    }

    public function edit() {
        if ($_SESSION['user_type'] !== 'student') {
            header('Location: index.php');
            exit;
        }

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

            // Recalculate total price if needed
            // This is simplistic: we assume meal_type didn’t change
            $mealType = $reservation['meal_type'];
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
        if ($_SESSION['user_type'] !== 'student') {
            header('Location: index.php');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->reservationModel->deleteReservation($id);
        }
        header('Location: index.php?controller=reservation&action=manage');
    }
}
