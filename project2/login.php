<!-- JAY KSHIRSAGAR 105912265 -->
<!-- Part of Enhancements -->

<?php
session_start();

// Lockout settings
$max_attempts = 3;
$lockout_time = 300; // 5 minutes in seconds

// Initialize session tracking
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
    $_SESSION['last_attempt_time'] = 0;
}

// Check lockout status
if ($_SESSION['attempts'] >= $max_attempts) {
    $time_since_last = time() - $_SESSION['last_attempt_time'];
    if ($time_since_last < $lockout_time) {
        $remaining = $lockout_time - $time_since_last;
        $error = "Too many failed login attempts. Please try again in $remaining seconds.";
    } else {
        // Reset after lockout period
        $_SESSION['attempts'] = 0;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['attempts'] < $max_attempts) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "terrible_db";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        $error = "Connection failed: " . $conn->connect_error;
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Support plain or hashed password
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['attempts'] = 0; // reset attempts
                $stmt->close();
                $conn->close();
                header("Location: index.php");
                exit;
            } else {
                $_SESSION['attempts'] += 1;
                $_SESSION['last_attempt_time'] = time();

                if ($_SESSION['attempts'] >= $max_attempts) {
                    $error = "Too many failed login attempts. Please try again in 5 minutes.";
                } else {
                    $remaining = $max_attempts - $_SESSION['attempts'];
                    $error = "Invalid password. You have $remaining attempt(s) left.";
                }
            }
        } else {
            $_SESSION['attempts'] += 1;
            $_SESSION['last_attempt_time'] = time();
            $error = "User not found. You have " . ($max_attempts - $_SESSION['attempts']) . " attempt(s) left.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Jay Kshirsagar 105912265">
    <meta name="description" content="Login page for Terrible Software Inc.">
    <meta name="keywords" content="Login, Terrible Software Inc., Authentication, User Login">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Terrible Software Inc - Home</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <form method="post" action="">
        <div>
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <input type="submit" value="Login">
        </div>
    </form>
    <p><a href="create_account.php">Don't have an account? Create one here</a></p>
</body>
</html>
