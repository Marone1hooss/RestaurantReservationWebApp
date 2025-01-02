<?php
// app/Models/ReservationModel.php
namespace App\Models;

use PDO;

class ReservationModel {
    private $pdo;
    private $table = 'reservations';

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getByUser($userId) {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY reservation_date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createReservation($userId, $date, $mealType, $contents, $quantity, $totalPrice) {
        $sql = "INSERT INTO {$this->table} 
                (user_id, reservation_date, meal_type, contents, quantity, total_price) 
                VALUES (:user_id, :reservation_date, :meal_type, :contents, :quantity, :total_price)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'user_id'           => $userId,
            'reservation_date'  => $date,
            'meal_type'         => $mealType,
            'contents'          => $contents,
            'quantity'          => $quantity,
            'total_price'       => $totalPrice
        ]);
    }

    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateReservation($id, $contents, $quantity, $totalPrice) {
        $sql = "UPDATE {$this->table}
                SET contents = :contents, quantity = :quantity, total_price = :total_price
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'contents'     => $contents,
            'quantity'     => $quantity,
            'total_price'  => $totalPrice,
            'id'           => $id
        ]);
    }

    public function deleteReservation($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
