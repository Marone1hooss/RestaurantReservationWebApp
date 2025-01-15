<?php
// app/Controllers/MenuController.php
namespace App\Controllers;

use App\Models\MenuModel;
use PDO;

class MenuController {
    private $pdo;
    private $menuModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->menuModel = new MenuModel($pdo);
    }

    // Admin manages the weekly menu
    public function adminManage() {
        if ($_SESSION['user_type'] !== 'admin') {
            header('Location: index.php');
            exit;
        }

        // Handle add/edit/delete
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            if ($action === 'add') {
                $dayOfWeek = $_POST['day_of_week'];
                $mealType  = $_POST['meal_type'];
                $itemName  = $_POST['item_name'];
                $price     = $_POST['price'];
                $this->menuModel->createItem($dayOfWeek, $mealType, $itemName, $price);
            } elseif ($action === 'edit') {
                $id        = $_POST['id'];
                $dayOfWeek = $_POST['day_of_week'];
                $mealType  = $_POST['meal_type'];
                $itemName  = $_POST['item_name'];
                $price     = $_POST['price'];
                $this->menuModel->updateItem($id, $dayOfWeek, $mealType, $itemName, $price);
            } elseif ($action === 'delete') {
                $id = $_POST['id'];
                $this->menuModel->deleteItem($id);
            }
            header('Location: index.php?controller=menu&action=adminManage');
            exit;
        }

        // Retrieve current menu
        $allMenuItems = $this->menuModel->getAll();
        require_once __DIR__ . '/../Views/menu/admin_manage.php';
    }
    
    public function selectDay() {
        // Display a form where the user can pick the weekday
        require_once __DIR__ . '/../Views/menu/select_day.php';
    }
    

   
    public function showDay() {
        // Look for 'day' in $_POST (or $_GET, if you prefer GET for some reason)
        $day = $_POST['day'] ?? 'Monday';
    
        // Retrieve menu items for that day
        $menuItems = $this->menuModel->getByDay($day);
    
        // Display the result in show_day.php
        require_once __DIR__ . '/../Views/menu/show_day.php';
    }
    
}
