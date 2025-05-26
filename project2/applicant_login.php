<!-- JAY KSHIRSAGAR 105912265 -->
<!-- Pujan Kukadiya 105920242 -->
<!-- Part of Enhancements -->

<?php
// Start session at the very beginning
session_start();
require_once("settings.php");

// Initialize login attempt tracking
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if (!isset($_SESSION['lockout_time'])) {
    $_SESSION['lockout_time'] = 0;
}

$error = "";
$lockout = false;
$remaining_time = 0;

// Check if user is in lockout period
if ($_SESSION['login_attempts'] >= 3 && (time() - $_SESSION['lockout_time']) < 60) {
    $lockout = true;
    $remaining_time = 60 - (time() - $_SESSION['lockout_time']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !$lockout) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // User exists, verify password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct - reset attempts
            $_SESSION['login_attempts'] = 0;
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $stmt->close();
            $conn->close();
            header("Location: index.php");
            exit;
        } else {
            // Password is incorrect
            $_SESSION['login_attempts']++;
            if ($_SESSION['login_attempts'] >= 3) {
                $_SESSION['lockout_time'] = time();
                $error = "Too many failed attempts. Please try again in 60 seconds.";
            } else {
                $error = "Invalid username or password";
            }
        }
    } else {
        // User doesn't exist
        $_SESSION['login_attempts']++;
        if ($_SESSION['login_attempts'] >= 3) {
            $_SESSION['lockout_time'] = time();
            $error = "Too many failed attempts. Please try again in 60 seconds.";
        } else {
            $error = "Invalid username or password";
        }
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="JAY KSHIRSAGAR 105912265, Pujan Kukadiya 105920242">
    <meta name="keywords" content="EOI, Job Application, Management, Terrible Software Inc., HTML, CSS, Javascript">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Terrible Software Inc - Applicant Login</title>
</head>

<body class="manage">
    <?php include "header.inc"; ?>
    
    <div class="container">
        <div class="glass-container">
            <?php createHeader("Manage"); ?>
            
            <div class="content">
                <div class="main">
                    <h2>Login</h2>
                    <?php if ($lockout): ?>
                        <div class="error-message">
                            Account locked. Please try again in <?php echo htmlspecialchars($remaining_time); ?> seconds.
                        </div>
                    <?php elseif (!empty($error)): ?>
                        <div class="error-message">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!$lockout): ?>
                        <form method="POST" action="applicant_login.php" class="login-form">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" id="username" name="username" required>
                            </div><br>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" required>
                            </div><br>
                            <div class="form-group">
                                <input type="submit" name="login" value="Login" class="login-btn">
                            </div><br>
                        </form>
                    <?php endif; ?>
                    
                    <div class="register-link">
                        <a href='create_account.php'>No account yet? <strong>Register Here</strong></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include "footer.inc"; ?>
</body>
</html>