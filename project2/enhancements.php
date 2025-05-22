<?php
session_start();
require_once("settings.php");

$username = $password = "";
$error = "";

// Initialize login attempt tracking
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if (!isset($_SESSION['lockout_time'])) {
    $_SESSION['lockout_time'] = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if account is locked
    if ($_SESSION['login_attempts'] >= 3 && time() < $_SESSION['lockout_time']) {
        $remaining_time = ceil(($_SESSION['lockout_time'] - time()) / 60);
        $error = "Account locked due to multiple failed attempts. Please try again in $remaining_time minutes.";
    } else {
        // Reset lockout if time has passed
        if ($_SESSION['login_attempts'] >= 3 && time() >= $_SESSION['lockout_time']) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['lockout_time'] = 0;
        }

        // Validate input
        if (empty(trim($_POST["username"])) || empty(trim($_POST["password"]))) {
            $error = "Please enter both username and password.";
        } else {
            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);

            $conn = @mysqli_connect($host, $username, $password, $database);
            if ($conn) {
                // Prepare query to get user data including role if you have one
                $sql = "SELECT id, username, password FROM hr_users WHERE username = ?";
                $stmt = mysqli_prepare($conn, $sql);
                
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "s", $username);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $user_id, $db_username, $hashed_password);
                        mysqli_stmt_fetch($stmt);
                        
                        // Verify password against the hashed version from register_hr.php
                        if (password_verify($password, $hashed_password)) {
                            // Successful login - set session variables
                            $_SESSION['admin_logged_in'] = true;
                            $_SESSION['user_id'] = $user_id;
                            $_SESSION['username'] = $db_username;
                            $_SESSION['login_attempts'] = 0;
                            $_SESSION['lockout_time'] = 0;
                            
                            // Regenerate session ID for security
                            session_regenerate_id(true);
                            
                            // Redirect to manage page
                            header("Location: manage.php");
                            exit();
                        } else {
                            // Invalid password
                            $_SESSION['login_attempts'] += 1;
                            $error = "Invalid username or password.";
                        }
                    } else {
                        // User not found
                        $_SESSION['login_attempts'] += 1;
                        $error = "Invalid username or password.";
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $error = "Database error. Please try again.";
                }
                mysqli_close($conn);
            } else {
                $error = "Database connection failed. Please try again later.";
            }

            // Implement lockout after 3 failed attempts
            if ($_SESSION['login_attempts'] >= 3) {
                $_SESSION['lockout_time'] = time() + 300; // 5 minutes lockout
                $error = "Account locked due to multiple failed attempts. Please try again in 5 minutes.";
            }
        }
    }
}

include_once('header.inc'); 
createHeader('Admin Login');
?>

<h2>Admin Login</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>

<?php if (!empty($error)): ?>
    <div style="color:red;"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<p>Don't have an account? <a href="register_hr.php">Register here</a></p>

<?php include_once('footer.inc'); ?>