<?php
// app/Models/MenuModel.php
namespace App\Models;

use PDO;

class MenuModel {
    private $pdo;
    private $table = 'weekly_menu';

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY day_of_week, meal_type";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByDay($dayOfWeek) {
        $sql = "SELECT * FROM {$this->table} WHERE day_of_week = :day_of_week ORDER BY meal_type";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['day_of_week' => $dayOfWeek]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createItem($dayOfWeek, $mealType, $itemName, $price) {
        $sql = "INSERT INTO {$this->table} (day_of_week, meal_type, item_name, price)
                VALUES (:day_of_week, :meal_type, :item_name, :price)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'day_of_week' => $dayOfWeek,
            'meal_type'   => $mealType,
            'item_name'   => $itemName,
            'price'       => $price,
        ]);
    }

    public function updateItem($id, $dayOfWeek, $mealType, $itemName, $price) {
        $sql = "UPDATE {$this->table} 
                SET day_of_week = :day_of_week, meal_type = :meal_type, 
                    item_name = :item_name, price = :price
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'day_of_week' => $dayOfWeek,
            'meal_type'   => $mealType,
            'item_name'   => $itemName,
            'price'       => $price,
            'id'          => $id
        ]);
    }

    public function deleteItem($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
