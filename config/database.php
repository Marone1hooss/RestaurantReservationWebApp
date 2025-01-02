<?php
// config/database.php

$dsn = 'mysql:host=127.0.0.1;dbname=my_reservation_db;charset=utf8mb4';
$dbUser = 'root';
$dbPass = 'secret';

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo 'Database connection failed: ' . $e->getMessage();
    exit;
}
