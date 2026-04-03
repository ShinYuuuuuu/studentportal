<?php
session_start();

// Database connection (using MySQL)
function getDB() {
    // Check if Heroku JawsDB URL is available
    if (getenv('JAWSDB_URL')) {
        $url = parse_url(getenv('JAWSDB_URL'));
        $host = $url['host'];
        $dbname = substr($url['path'], 1);
        $username = $url['user'];
        $password = $url['pass'];
    } else {
        // Local development fallback
        $host = 'localhost';
        $dbname = 'student_portal';
        $username = 'root';
        $password = '';
    }

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

// Database initialization is handled by setup_db.php script

// Simple router
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Check login
$loggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// Initialize database connection for logged-in users
$db = null;
if ($loggedIn) {
    try {
        $db = getDB();
        // Test the connection with a simple query
        $stmt = $db->query("SELECT 1");
        if (!$stmt) {
            throw new Exception("Database query failed");
        }
    } catch (Exception $e) {
        // For debugging - remove this in production
        error_log("Database connection error: " . $e->getMessage());
        die("Database connection failed. Please run the setup script at /setup_db.php first.");
    }
}

// Handle login
if ($page === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'] ?? '';
    $password = $_POST['password'] ?? '';

    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM users WHERE student_id = ?");
    $stmt->execute([$student_id]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // For demo purposes, check plain text password
    if ($userData && $password === 'demo123') {
        // Valid login
    } else {
        $userData = false;
    }

    if ($userData) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = $userData;
        header('Location: ?page=dashboard');
        exit;
    } else {
        $loginError = "Invalid credentials";
    }
}

// Handle logout
if ($action === 'logout') {
    session_destroy();
    header('Location: ?page=login');
    exit;
}

// If not logged in, show login (except for login page)
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #10b981;
            --secondary: #3b82f6;
            --dark: #1e293b;
            --light: #f8fafc;
        }
        body { font-family: 'Segoe UI', sans-serif; background: var(--light); }
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .nav-link { color: var(--dark) !important; }
        .nav-link.active { color: var(--primary) !important; font-weight: 600; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .card:hover { transform: translateY(-2px); }
        .btn-primary { background: var(--primary); border: none; }
        .btn-primary:hover { background: #059669; }
        .quick-action-btn {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            display: block;
            transition: transform 0.2s;
        }
        .quick-action-btn:hover { transform: translateY(-4px); color: white; }
        .grade-excellent { border-left: 4px solid #10b981; background: rgba(16,185,129,0.05); }
        .grade-good { border-left: 4px solid #3b82f6; background: rgba(59,130,246,0.05); }
        .grade-average { border-left: 4px solid #f59e0b; background: rgba(245,158,11,0.05); }
        .grade-poor { border-left: 4px solid #ef4444; background: rgba(239,68,68,0.05); }
        .mobile-nav { display: none; }
        @media (max-width: 768px) {
            .mobile-nav { display: flex; position: fixed; bottom: 0; left: 0; right: 0; background: white; box-shadow: 0 -2px 10px rgba(0,0,0,0.1); z-index: 1000; }
            .mobile-nav a { flex: 1; text-align: center; padding: 10px; color: var(--dark); text-decoration: none; font-size: 12px; }
            .mobile-nav a.active { color: var(--primary); }
            body { padding-bottom: 70px; }
        }
    </style>
</head>
<body>
<?php if ($loggedIn && $page !== 'login'): ?>
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="?page=dashboard">
            <i class="bi bi-mortarboard-fill me-2"></i>Student Portal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link <?= $page=='dashboard'?'active':'' ?>" href="?page=dashboard"><i class="bi bi-house-door me-1"></i>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link <?= $page=='grades'?'active':'' ?>" href="?page=grades"><i class="bi bi-bar-chart me-1"></i>Grades</a></li>
                <li class="nav-item"><a class="nav-link <?= $page=='schedule'?'active':'' ?>" href="?page=schedule"><i class="bi bi-calendar me-1"></i>Schedule</a></li>
                <li class="nav-item"><a class="nav-link <?= $page=='enrollment'?'active':'' ?>" href="?page=enrollment"><i class="bi bi-clipboard-check me-1"></i>Enrollment</a></li>
                <li class="nav-item"><a class="nav-link <?= $page=='services'?'active':'' ?>" href="?page=services"><i class="bi bi-gear me-1"></i>Services</a></li>
                <li class="nav-item"><a class="nav-link <?= $page=='downloads'?'active':'' ?>" href="?page=downloads"><i class="bi bi-download me-1"></i>Downloads</a></li>
                <li class="nav-item"><a class="nav-link <?= $page=='profile'?'active':'' ?>" href="?page=profile"><i class="bi bi-person me-1"></i>Profile</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="?action=logout"><i class="bi bi-box-arrow-right me-1"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Mobile Navigation -->
<div class="mobile-nav d-md-none">
    <a href="?page=dashboard" class="<?= $page=='dashboard'?'active':'' ?>"><i class="bi bi-house-door d-block fs-5"></i>Home</a>
    <a href="?page=grades" class="<?= $page=='grades'?'active':'' ?>"><i class="bi bi-bar-chart d-block fs-5"></i>Grades</a>
    <a href="?page=schedule" class="<?= $page=='schedule'?'active':'' ?>"><i class="bi bi-calendar d-block fs-5"></i>Schedule</a>
    <a href="?page=services" class="<?= $page=='services'?'active':'' ?>"><i class="bi bi-gear d-block fs-5"></i>Services</a>
    <a href="?page=profile" class="<?= $page=='profile'?'active':'' ?>"><i class="bi bi-person d-block fs-5"></i>Profile</a>
</div>

<main class="container py-4 mt-5">
<?php endif; ?>

<?php if ($page === 'login'): ?>
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
                    <div class="alert alert-danger"><?= $loginError ?></div>
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

<?php elseif ($page === 'dashboard'): ?>
    <!-- Dashboard -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #10b981, #3b82f6);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-white">
                    <h2>Good morning, <?= $user['first_name'] ?> 👋</h2>
                    <p class="mb-0" style="opacity:0.75"><?= $user['program'] ?> • <?= $user['year_level'] ?> • <?= $user['section'] ?></p>
                </div>
                <div class="badge bg-white text-primary fs-6">ID: <?= $user['student_id'] ?></div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up fs-1 text-success"></i>
                    <h4 class="mt-2">1.85</h4>
                    <small class="text-muted">Current GPA</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-clock fs-1 text-primary"></i>
                    <h4 class="mt-2">Web Dev</h4>
                    <small class="text-muted">Next Class</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-megaphone fs-1 text-warning"></i>
                    <h4 class="mt-2">2</h4>
                    <small class="text-muted">Announcements</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-list-check fs-1 text-danger"></i>
                    <h4 class="mt-2">3</h4>
                    <small class="text-muted">Pending Tasks</small>
                </div>
            </div>
        </div>
    </div>
    
    <h5 class="mb-3">Quick Actions</h5>
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <a href="?page=grades" class="quick-action-btn text-center py-4">
                <i class="bi bi-bar-chart fs-2 d-block mb-2"></i>View Grades
            </a>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <a href="?page=schedule" class="quick-action-btn text-center py-4">
                <i class="bi bi-calendar fs-2 d-block mb-2"></i>View Schedule
            </a>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <a href="?page=enrollment" class="quick-action-btn text-center py-4">
                <i class="bi bi-clipboard-check fs-2 d-block mb-2"></i>Enroll Now
            </a>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <a href="?page=downloads" class="quick-action-btn text-center py-4">
                <i class="bi bi-download fs-2 d-block mb-2"></i>Downloads
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Recent Activity</h5></div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-bar-chart text-primary me-3"></i>
                        <div><h6 class="mb-0">Viewed Math 101 Grades</h6><small class="text-muted">2 hours ago</small></div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-download text-success me-3"></i>
                        <div><h6 class="mb-0">Downloaded Clearance Form</h6><small class="text-muted">1 day ago</small></div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clipboard-check text-warning me-3"></i>
                        <div><h6 class="mb-0">Completed Enrollment</h6><small class="text-muted">2 days ago</small></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Pending Tasks</h5></div>
                <div class="card-body">
                    <div class="mb-2"><span class="badge bg-danger me-2">!</span>Submit thesis proposal</div>
                    <div class="mb-2"><span class="badge bg-warning me-2">!</span>Pay tuition fee</div>
                    <div><span class="badge bg-info me-2">!</span>Complete clearance</div>
                </div>
            </div>
        </div>
    </div>

<?php elseif ($page === 'grades'): ?>
    <!-- Grades -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #10b981, #3b82f6);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center text-white">
                <div>
                    <h2>My Grades</h2>
                    <p class="mb-0" style="opacity:0.75">2nd Semester AY 2023-2024</p>
                </div>
                <div class="text-end">
                    <h1 class="display-4 fw-bold">1.85</h1>
                    <p class="mb-0">Overall GPA</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <?php
        if ($db) {
            $stmt = $db->prepare("
                SELECT g.*, c.course_name as subject, c.course_code as code, c.units
                FROM grades g
                JOIN courses c ON g.course_id = c.id
                WHERE g.student_id = ?
                ORDER BY g.created_at DESC
            ");
            $stmt->execute([$user['id']]);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                $gradeClass = $row['grade'] <= 1.5 ? 'grade-excellent' : ($row['grade'] <= 2.0 ? 'grade-good' : ($row['grade'] <= 2.5 ? 'grade-average' : 'grade-poor'));
        ?>
        <div class="col-md-6 mb-3">
            <div class="card <?= $gradeClass ?>">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5><?= $row['subject'] ?></h5>
                            <small class="text-muted"><?= $row['code'] ?> • <?= $row['units'] ?> units</small>
                        </div>
                        <div class="text-end">
                            <h3 class="mb-0"><?= $row['grade'] ?></h3>
                            <small><?= $row['equivalent'] ?></small>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="badge bg-success"><?= $row['remarks'] ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php
            endwhile;
        } else {
            // No database connection
            echo "<div class='alert alert-warning'>Database not available. Please run the setup script at <a href='/setup_db.php'>/setup_db.php</a> first.</div>";
        }
        ?>
    </div>
    
    <div class="card mt-4">
        <div class="card-header"><h5 class="mb-0">Grade Summary</h5></div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-4"><h4>1.85</h4><small>GPA</small></div>
                <div class="col-4"><h4>18</h4><small>Total Units</small></div>
                <div class="col-4"><h4>100%</h4><small>Pass Rate</small></div>
            </div>
        </div>
    </div>

<?php elseif ($page === 'schedule'): ?>
    <!-- Schedule -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #10b981, #3b82f6);">
        <div class="card-body p-4 text-white">
            <h2>My Schedule</h2>
            <p class="mb-0" style="opacity:0.75">2nd Semester AY 2023-2024</p>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Weekly Schedule</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Subject</th>
                            <th>Room</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $db->prepare("
                            SELECT s.*, c.course_name as subject, c.course_code
                            FROM schedule s
                            JOIN courses c ON s.course_id = c.id
                            ORDER BY
                                CASE s.day_of_week
                                    WHEN 'monday' THEN 1
                                    WHEN 'tuesday' THEN 2
                                    WHEN 'wednesday' THEN 3
                                    WHEN 'thursday' THEN 4
                                    WHEN 'friday' THEN 5
                                    WHEN 'saturday' THEN 6
                                    WHEN 'sunday' THEN 7
                                END, s.start_time
                        ");
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                            // Format the data to match the old structure
                            $row['day'] = ucfirst($row['day_of_week']);
                            $row['time'] = date('H:i', strtotime($row['start_time'])) . '-' . date('H:i', strtotime($row['end_time']));
                            $row['type'] = ucfirst($row['schedule_type']);
                        ?>
                        <tr>
                            <td><?= $row['day'] ?></td>
                            <td><?= $row['time'] ?></td>
                            <td><?= $row['subject'] ?></td>
                            <td><?= $row['room'] ?></td>
                            <td><span class="badge bg-primary"><?= $row['type'] ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header"><h5 class="mb-0">Today's Classes</h5></div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="bi bi-clock me-2"></i>
                <strong>Next class:</strong> Web Development at 10:00 AM in Lab 204
            </div>
        </div>
    </div>

<?php elseif ($page === 'enrollment'): ?>
    <!-- Enrollment -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #10b981, #3b82f6);">
        <div class="card-body p-4 text-white">
            <h2>Enrollment</h2>
            <p class="mb-0" style="opacity:0.75">2nd Semester AY 2023-2024</p>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Available Subjects</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Subject</th>
                            <th>Units</th>
                            <th>Schedule</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $db->query("SELECT * FROM courses ORDER BY course_code");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                            // Map fields to match old structure
                            $row['code'] = $row['course_code'];
                            $row['name'] = $row['course_name'];
                            $row['schedule'] = 'TBD'; // Placeholder since schedule is in separate table
                        ?>
                        <tr>
                            <td><?= $row['code'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['units'] ?></td>
                            <td><?= $row['schedule'] ?></td>
                            <td><button class="btn btn-sm btn-primary">Add</button></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="alert alert-warning">
        <i class="bi bi-clock me-2"></i>
        <strong>Enrollment Deadline:</strong> March 20, 2024
    </div>

<?php elseif ($page === 'services'): ?>
    <!-- Services -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #10b981, #3b82f6);">
        <div class="card-body p-4 text-white">
            <h2>Online Services</h2>
            <p class="mb-0" style="opacity:0.75">Request documents, pay fees, and more</p>
        </div>
    </div>
    
    <?php
    $categories = ['Academic', 'Financial', 'Documents'];
    foreach ($categories as $cat):
    ?>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?= $cat ?></h5>
        </div>
        <div class="card-body">
            <?php
            // Static services data (since services table doesn't exist in new schema)
            $services = [
                ['Academic', 'Request TOR', 'Transcript of Records', '3-5 days'],
                ['Academic', 'Request Diploma', 'Official Diploma', '5-7 days'],
                ['Academic', 'Request Certificate', 'Various Certificates', '2-3 days'],
                ['Financial', 'Pay Tuition', 'Online Payment', 'Immediate'],
                ['Financial', 'View Balance', 'Check Account', 'Immediate'],
                ['Documents', 'Apply Clearance', 'Student Clearance', '2-3 days'],
                ['Documents', 'Request ID', 'ID Replacement', '3-5 days']
            ];
            foreach ($services as $row):
                if ($row[0] === $cat):
            ?>
            <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                <div>
                    <h6 class="mb-1"><?= $row[1] ?></h6>
                    <small class="text-muted"><?= $row[2] ?></small>
                </div>
                <div class="text-end">
                    <small class="text-muted"><?= $row[3] ?></small>
                    <button class="btn btn-sm btn-primary ms-2">Request</button>
                </div>
            </div>
            <?php
                endif;
            endforeach;
            ?>
        </div>
    </div>
    <?php endforeach; ?>

<?php elseif ($page === 'downloads'): ?>
    <!-- Downloads -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #10b981, #3b82f6);">
        <div class="card-body p-4 text-white">
            <h2>Downloads</h2>
            <p class="mb-0" style="opacity:0.75">Forms, documents, and resources</p>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header"><h5 class="mb-0">Available Documents</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Document</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $db->query("SELECT * FROM documents ORDER BY created_at DESC");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                            // Map fields to match old structure
                            $row['name'] = $row['document_name'];
                            $row['type'] = strtoupper($row['document_type']);
                            $row['size'] = $row['file_size'];
                            $row['date'] = date('Y-m-d', strtotime($row['created_at']));
                        ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <td><span class="badge bg-<?= $row['type']=='PDF'?'danger':'success' ?>"><?= $row['type'] ?></span></td>
                            <td><?= $row['size'] ?></td>
                            <td><?= $row['date'] ?></td>
                            <td><button class="btn btn-sm btn-primary"><i class="bi bi-download"></i></button></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php elseif ($page === 'profile'): ?>
    <!-- Profile -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #10b981, #3b82f6);">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-white p-3 me-4">
                    <i class="bi bi-person-circle fs-1 text-primary"></i>
                </div>
                <div class="text-white">
                    <h2><?= $user['first_name'] ?> <?= $user['last_name'] ?></h2>
                    <p class="mb-0" style="opacity:0.75"><?= $user['program'] ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Personal Information</h5></div>
                <div class="card-body">
                    <p><strong>Student ID:</strong> <?= $user['student_id'] ?></p>
                    <p><strong>Email:</strong> <?= $user['email'] ?></p>
                    <p><strong>Phone:</strong> <?= $user['phone'] ?></p>
                    <p><strong>Section:</strong> <?= $user['section'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Academic Info</h5></div>
                <div class="card-body">
                    <p><strong>Program:</strong> <?= $user['program'] ?></p>
                    <p><strong>Year Level:</strong> <?= $user['year_level'] ?></p>
                    <p><strong>Current GPA:</strong> 1.85</p>
                    <p><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <button class="btn btn-primary me-2">Edit Profile</button>
            <button class="btn btn-outline-primary me-2">Change Password</button>
            <button class="btn btn-outline-danger">Logout</button>
        </div>
    </div>
<?php endif; ?>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>