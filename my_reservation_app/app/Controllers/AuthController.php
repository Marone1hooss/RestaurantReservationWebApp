<?php
// app/Controllers/AuthController.php
namespace App\Controllers;

require_once __DIR__ . '/../Models/UserModel.php';
use PDO;

class AuthController {
    private $pdo;
    private $userModel;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->userModel = new \App\Models\UserModel($pdo);
    }

    public function login() {
        // If POST, attempt login
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                // Valid credentials
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['user_type'] = $user['user_type'];

                // Redirect based on user type
                if ($user['user_type'] === 'admin') {
                    header('Location: index.php?controller=menu&action=adminManage');
                } else {
                    header('Location: index.php?controller=reservation&action=index');
                }
                exit;
            } else {
                $error = "Invalid email or password!";
            }
        }

        // Render the login form
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    public function register() {
        // If your system allows open registration
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $hashed = password_hash($password, PASSWORD_BCRYPT);

            // Default to 'student' unless you have a separate mechanism
            $this->userModel->createUser($username, $email, $hashed, 'student');

            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        require_once __DIR__ . '/../Views/auth/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}
