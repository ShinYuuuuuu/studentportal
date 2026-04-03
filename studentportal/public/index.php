<?php

require_once __DIR__ . '/../app/Http/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Http/Controllers/AuthController.php';

$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/';

// Remove query string
$request_uri = strtok($request_uri, '?');

// Simple routing
$routes = [
    '/' => ['controller' => 'HomeController', 'method' => 'index', 'auth' => true],
    '/grades' => ['controller' => 'HomeController', 'method' => 'grades', 'auth' => true],
    '/schedule' => ['controller' => 'HomeController', 'method' => 'schedule', 'auth' => true],
    '/enrollment' => ['controller' => 'HomeController', 'method' => 'enrollment', 'auth' => true],
    '/services' => ['controller' => 'HomeController', 'method' => 'services', 'auth' => true],
    '/profile' => ['controller' => 'HomeController', 'method' => 'profile', 'auth' => true],
    '/downloads' => ['controller' => 'HomeController', 'method' => 'downloads', 'auth' => true],
    '/login' => ['controller' => 'AuthController', 'method' => 'login', 'auth' => false],
    '/authenticate' => ['controller' => 'AuthController', 'method' => 'authenticate', 'auth' => false],
    '/logout' => ['controller' => 'AuthController', 'method' => 'logout', 'auth' => true],
];

// Check authentication for protected routes
$auth = new App\Http\Controllers\AuthController();
$current_user = $auth->getCurrentUser();

// Find matching route
foreach ($routes as $route => $config) {
    if ($request_uri === $route || $request_uri === $base_path . $route) {
        
        // Check authentication for protected routes
        if ($config['auth'] && !$current_user) {
            header('Location: /login');
            exit;
        }
        
        // Instantiate controller and call method
        $controller_class = 'App\\Http\\Controllers\\' . $config['controller'];
        $controller = new $controller_class();
        
        if (method_exists($controller, $config['method'])) {
            $controller->{$config['method']}();
            exit;
        }
    }
}

// Default to login if no route matches and not authenticated
if (!$current_user) {
    header('Location: /login');
    exit;
} else {
    // Default to dashboard if authenticated
    $controller = new App\Http\Controllers\HomeController();
    $controller->index();
    exit;
}