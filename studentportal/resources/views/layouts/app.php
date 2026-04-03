<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo isset($title) ? $title : 'Student Portal'; ?></title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="css/app.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="/">
                <i class="bi bi-mortarboard-fill me-2"></i>
                Student Portal
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/' ? 'active' : ''; ?>" href="/">
                            <i class="bi bi-house-door me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/grades') === 0 ? 'active' : ''; ?>" href="/grades">
                            <i class="bi bi-bar-chart me-1"></i> My Grades
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/schedule') === 0 ? 'active' : ''; ?>" href="/schedule">
                            <i class="bi bi-calendar-week me-1"></i> Schedule
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/enrollment') === 0 ? 'active' : ''; ?>" href="/enrollment">
                            <i class="bi bi-clipboard-check me-1"></i> Enrollment
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/services') === 0 ? 'active' : ''; ?>" href="/services">
                            <i class="bi bi-gear me-1"></i> Services
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> Profile
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i> My Profile</a></li>
                            <li><a class="dropdown-item" href="/downloads"><i class="bi bi-download me-2"></i> Downloads</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4" style="margin-top: 80px;">
        <?php echo $content; ?>
    </main>

    <!-- Mobile Bottom Navigation -->
    <div class="d-block d-lg-none fixed-bottom bg-white shadow-lg">
        <div class="container">
            <div class="row text-center py-2">
                <div class="col">
                    <a href="/" class="text-decoration-none text-dark <?php echo $_SERVER['REQUEST_URI'] === '/' ? 'text-primary' : ''; ?>">
                        <i class="bi bi-house-door fs-4 d-block"></i>
                        <small>Dashboard</small>
                    </a>
                </div>
                <div class="col">
                    <a href="/grades" class="text-decoration-none text-dark <?php echo strpos($_SERVER['REQUEST_URI'], '/grades') === 0 ? 'text-primary' : ''; ?>">
                        <i class="bi bi-bar-chart fs-4 d-block"></i>
                        <small>Grades</small>
                    </a>
                </div>
                <div class="col">
                    <a href="/schedule" class="text-decoration-none text-dark <?php echo strpos($_SERVER['REQUEST_URI'], '/schedule') === 0 ? 'text-primary' : ''; ?>">
                        <i class="bi bi-calendar-week fs-4 d-block"></i>
                        <small>Schedule</small>
                    </a>
                </div>
                <div class="col">
                    <a href="/services" class="text-decoration-none text-dark <?php echo strpos($_SERVER['REQUEST_URI'], '/services') === 0 ? 'text-primary' : ''; ?>">
                        <i class="bi bi-gear fs-4 d-block"></i>
                        <small>Services</small>
                    </a>
                </div>
                <div class="col">
                    <a href="/profile" class="text-decoration-none text-dark <?php echo strpos($_SERVER['REQUEST_URI'], '/profile') === 0 ? 'text-primary' : ''; ?>">
                        <i class="bi bi-person-circle fs-4 d-block"></i>
                        <small>Profile</small>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/app.js"></script>

    <?php echo isset($scripts) ? $scripts : ''; ?>
</body>
</html>