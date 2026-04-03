<?php
// Simple Student Portal - Basic Version
session_start();

// Basic page router
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Check login (simplified)
$loggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Handle login
if ($page === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'] ?? '';
    $password = $_POST['password'] ?? '';

    // Simple demo login (no database required)
    if ($student_id === '2023-00123' && $password === 'demo123') {
        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = [
            'id' => 1,
            'student_id' => '2023-00123',
            'first_name' => 'Reynante',
            'last_name' => 'Dela Cruz',
            'program' => 'BS Computer Science',
            'year_level' => '3rd Year',
            'section' => 'CS-3A'
        ];
        header('Location: ?page=dashboard');
        exit;
    } else {
        $loginError = "Invalid credentials";
    }
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: ?page=login');
    exit;
}

// If not logged in and not on login page, redirect to login
if (!$loggedIn && $page !== 'login') {
    header('Location: ?page=login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8fafc; }
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<?php if ($loggedIn): ?>
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="?page=dashboard">
            <i class="bi bi-mortarboard-fill me-2"></i>Student Portal
        </a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="?page=dashboard">Dashboard</a>
            <a class="nav-link" href="?page=grades">Grades</a>
            <a class="nav-link" href="?page=schedule">Schedule</a>
            <a class="nav-link text-danger" href="?action=logout">Logout</a>
        </div>
    </div>
</nav>

<main class="container py-4 mt-5">

<?php if ($page === 'dashboard'): ?>
    <div class="card mb-4" style="background: linear-gradient(135deg, #10b981, #3b82f6);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center text-white">
                <div>
                    <h2>Good morning, <?php echo $_SESSION['user']['first_name']; ?> 👋</h2>
                    <p class="mb-0" style="opacity:0.75"><?php echo $_SESSION['user']['program']; ?> • <?php echo $_SESSION['user']['year_level']; ?> • <?php echo $_SESSION['user']['section']; ?></p>
                </div>
                <div class="badge bg-white text-primary fs-6">ID: <?php echo $_SESSION['user']['student_id']; ?></div>
            </div>
        </div>
    </div>

    <div class="alert alert-info">
        <h4>✅ Portal is Working!</h4>
        <p>Your Student Portal is successfully deployed on Heroku.</p>
        <p><strong>Next steps:</strong></p>
        <ul>
            <li>Run database setup: <a href="/setup_db.php" class="alert-link">/setup_db.php</a></li>
            <li>Check debug info: <a href="/debug.php" class="alert-link">/debug.php</a></li>
            <li>View this test page: <a href="/test.php" class="alert-link">/test.php</a></li>
        </ul>
    </div>

<?php elseif ($page === 'grades'): ?>
    <h2>My Grades</h2>
    <div class="alert alert-warning">
        <p>Grades will be displayed here once the database is set up.</p>
        <p>Run <a href="/setup_db.php">database setup</a> first.</p>
    </div>

<?php elseif ($page === 'schedule'): ?>
    <h2>My Schedule</h2>
    <div class="alert alert-warning">
        <p>Schedule will be displayed here once the database is set up.</p>
        <p>Run <a href="/setup_db.php">database setup</a> first.</p>
    </div>

<?php endif; ?>

</main>

<?php else: ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3><i class="bi bi-mortarboard-fill me-2"></i>Student Portal</h3>
                    <p class="mb-0">Sign in to your account</p>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($loginError)): ?>
                    <div class="alert alert-danger"><?php echo $loginError; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Student ID</label>
                            <input type="text" name="student_id" class="form-control" placeholder="Enter Student ID" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Sign In</button>
                    </form>
                    <div class="mt-4 p-3 bg-light rounded">
                        <small><strong>Demo:</strong> ID: 2023-00123 | Password: demo123</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>