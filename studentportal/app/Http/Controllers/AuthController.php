<?php

namespace App\Http\Controllers;

class AuthController
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function renderView($view, $data = [])
    {
        extract($data);
        ob_start();
        $viewFile = __DIR__ . "/../../../resources/views/{$view}.php";
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            $bladeFile = __DIR__ . "/../../../resources/views/{$view}.blade.php";
            if (file_exists($bladeFile)) {
                include $bladeFile;
            } else {
                echo "<h1>View not found: {$view}</h1>";
            }
        }
        return ob_get_clean();
    }

    public function login()
    {
        // Simple login page
        echo $this->renderView('auth.login');
    }

    public function authenticate()
    {
        // In a real application, this would validate credentials against database
        // For demo purposes, we'll simulate authentication
        
        $student_id = $_POST['student_id'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Demo validation (in real app, check against database)
        if ($student_id === '2023-00123' && $password === 'demo123') {
            // Start session
            session_start();
            $_SESSION['student_id'] = $student_id;
            $_SESSION['logged_in'] = true;
            $_SESSION['user_name'] = 'Reynante Dela Cruz';
            
            // Set session timeout (2 hours)
            $_SESSION['last_activity'] = time();
            
            // Redirect to dashboard
            header('Location: /');
            exit;
        } else {
            // Show error
            echo $this->renderView('auth.login', ['error' => 'Invalid student ID or password']);
        }
    }

    public function logout()
    {
        session_start();
        
        // Clear session
        $_SESSION = [];
        
        // Destroy session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        
        // Redirect to login
        header('Location: /login');
        exit;
    }

    public function checkSession()
    {
        session_start();
        
        // Check if user is logged in
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            return false;
        }
        
        // Check session timeout (2 hours)
        $timeout = 2 * 60 * 60; // 2 hours in seconds
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
            // Session expired
            session_unset();
            session_destroy();
            return false;
        }
        
        // Update last activity
        $_SESSION['last_activity'] = time();
        
        return true;
    }

    public function getCurrentUser()
    {
        if ($this->checkSession()) {
            return [
                'student_id' => $_SESSION['student_id'] ?? '',
                'name' => $_SESSION['user_name'] ?? '',
                'logged_in' => true
            ];
        }
        
        return null;
    }
}