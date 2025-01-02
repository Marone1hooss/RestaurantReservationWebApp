<?php
// app/Models/UserModel.php
namespace App\Models;

use PDO;

class UserModel {
    private $pdo;
    private $table = 'users';

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($username, $email, $hashedPassword, $userType = 'student') {
        $sql = "INSERT INTO {$this->table} (username, email, password, user_type) 
                VALUES (:username, :email, :password, :user_type)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'username' => $username,
            'email'    => $email,
            'password' => $hashedPassword,
            'user_type'=> $userType
        ]);
    }

    // ... add more methods if needed (e.g., update, delete)
}
