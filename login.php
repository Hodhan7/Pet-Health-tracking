<?php
session_start();
require_once 'includes/db_connect.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Set page title
$page_title = "Login";

// Process login form
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($login) || empty($password)) {
        $error = "Please enter both username/email and password.";
    } else {
        // Check if user exists by username or email
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $login, $login);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_type'] = $user['user_type'];
                
                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid username/email or password.";
            }
        } else {
            $error = "Invalid username/email or password.";
        }
    }
}

// Include header
include 'includes/header.php';
?>

<main>
    <div class="container">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <div class="login-icon">
                        <i class="fas fa-paw"></i>
                    </div>
                    <h1 class="login-title">Welcome Back</h1>
                    <p class="login-subtitle">Sign in to your Pet Management account</p>
                </div>
                
                <?php if (!empty($error)): ?>
                    <div class="flash-message flash-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo $error; ?></span>
                    </div>
                <?php endif; ?>
                
                <form method="post" action="login.php" class="login-form">
                    <div class="form-group">
                        <label for="login" class="form-label">
                            <i class="fas fa-user"></i>
                            Username or Email
                        </label>
                        <input type="text" id="login" name="login" required class="form-input" placeholder="Enter your username or email">
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i>
                            Password
                        </label>
                        <div class="password-input-container">
                            <input type="password" id="password" name="password" required class="form-input" placeholder="Enter your password">
                            <span toggle="#password" class="password-toggle">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt"></i>
                        Sign In
                    </button>
                    
                    <div class="login-footer">
                        <p>Don't have an account? <a href="register.php">Create one here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<style>
/* Login Page Specific Styles */
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 70vh;
    padding: 2rem 0;
}

.login-card {
    background: var(--card-bg);
    border-radius: 1rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    padding: 2.5rem;
    width: 100%;
    max-width: 400px;
    position: relative;
    overflow: hidden;
}

.login-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
}

.login-header {
    text-align: center;
    margin-bottom: 2rem;
}

.login-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
}

.login-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
}

.login-subtitle {
    color: var(--secondary-color);
    font-size: 0.95rem;
    margin-bottom: 0;
}

.login-form .form-group {
    margin-bottom: 1.5rem;
}

.login-form .form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
}

.login-form .form-label i {
    color: var(--primary-color);
    width: 16px;
}

.password-input-container {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: var(--secondary-color);
    transition: color 0.2s ease;
}

.password-toggle:hover {
    color: var(--primary-color);
}

.login-form .btn {
    padding: 0.875rem 1.5rem;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.login-footer {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
}

.login-footer p {
    color: var(--secondary-color);
    margin-bottom: 0;
}

.login-footer a {
    color: var(--primary-color);
    font-weight: 600;
    text-decoration: none;
}

.login-footer a:hover {
    text-decoration: underline;
}

@media (max-width: 480px) {
    .login-card {
        margin: 1rem;
        padding: 1.5rem;
    }
    
    .login-container {
        min-height: 60vh;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    const togglePassword = document.querySelector('.password-toggle');
    
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const password = document.querySelector(this.getAttribute('toggle'));
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle the icon
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
});
</script>

<?php
// Include footer
include 'includes/footer.php';
?>
