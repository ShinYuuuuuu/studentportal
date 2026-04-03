<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Portal - Login</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #10b981;
            --primary-dark: #059669;
            --secondary-color: #3b82f6;
            --border-radius: 12px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .login-header h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .login-body {
            padding: 2rem;
            background: white;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            width: 100%;
            transition: transform 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            color: white;
        }

        .input-group-text {
            background-color: #f8fafc;
            border: 1px solid #e5e7eb;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .demo-credentials {
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
            border-left: 4px solid var(--primary-color);
        }

        .demo-credentials h6 {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .demo-credentials p {
            font-size: 0.75rem;
            margin-bottom: 0.25rem;
            color: #64748b;
        }

        .footer-links {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #64748b;
        }

        .footer-links a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .security-notice {
            font-size: 0.75rem;
            color: #94a3b8;
            text-align: center;
            margin-top: 1rem;
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 0;
            }

            .login-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1><i class="bi bi-mortarboard-fill me-2"></i>Student Portal</h1>
                <p class="mb-0 opacity-75">Sign in to access your student account</p>
            </div>

            <div class="login-body">
                <?php if(isset($error) && $error): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="/authenticate">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person-badge"></i>
                            </span>
                            <input type="text" class="form-control" id="student_id" name="student_id"
                                   placeholder="Enter your student ID" required
                                   value="<?php echo isset($_POST['student_id']) ? $_POST['student_id'] : ''; ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Enter your password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                        <a href="#" class="float-end text-decoration-none" style="font-size: 0.875rem;">
                            Forgot password?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-login mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                    </button>

                    <!-- Demo credentials -->
                    <div class="demo-credentials">
                        <h6>Demo Credentials</h6>
                        <p><strong>Student ID:</strong> 2023-00123</p>
                        <p><strong>Password:</strong> demo123</p>
                    </div>
                </form>

                <div class="footer-links">
                    <p class="mb-2">
                        Need help? <a href="#">Contact Support</a>
                    </p>
                    <p class="mb-0">
                        Don't have an account? <a href="#">Register here</a>
                    </p>
                </div>

                <div class="security-notice">
                    <i class="bi bi-shield-check me-1"></i>
                    Your login is secured with HTTPS encryption
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle eye icon
                    const icon = this.querySelector('i');
                    if (type === 'password') {
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    } else {
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    }
                });
            }

            // Auto-focus student ID field
            const studentIdField = document.getElementById('student_id');
            if (studentIdField) {
                studentIdField.focus();
            }

            // Form validation
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const studentId = document.getElementById('student_id').value.trim();
                    const password = document.getElementById('password').value.trim();

                    if (!studentId || !password) {
                        e.preventDefault();
                        alert('Please fill in all required fields.');
                        return false;
                    }

                    // Show loading state
                    const submitButton = this.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i> Signing in...';
                    }

                    return true;
                });
            }
        });
    </script>
</body>
</html>