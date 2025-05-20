<!--MAGGIE XIN YI LAW 103488683-->

<?php
// Start session to manage login and authentication state
session_start();
require_once("settings.php"); // Include database connection settings

// Database connection
// Check if the session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Connect to MySQL database using credentials from settings.php
$conn = @mysqli_connect($host, $user, $pswd, $dbnm) or die("Database connection failed");
// Initialize attempt tracking if not already set
if (!isset($SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}
$login_error = "";

// Handle login submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = trim($_POST['username']); // Sanitize input
    $password = $_POST['password'];
    // Retrieve HR user credentials from database
    $query = "SELECT * FROM hr_users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    // Check if the user exists & verify the password
    // Use password_verify to check the hashed password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['hr_logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['attempts'] = 0;
    } else {
        $_SESSION['attempts']++;
        $login_error = "Invalid username or password.";
    }
}

// Lockout after 3 failed attempts
if ($_SESSION['attempts'] >= 3) {
    die("<h3>Access denied. Too many failed login attempts.</h3>");
}

// Show login form if HR manager is not logged in
if (!isset($_SESSION['hr_logged_in'])) {
    echo "<h2>HR Manager Login</h2>";
    // Display login error if any
    // Use htmlspecialchars to prevent XSS attacks
    if ($login_error) echo "<p style='color:red;'>$login_error</p>";
    echo    '<form method="POST" action="manage.php">
                <label>Username:</label><input type="text" name="username" required><br>
                <label>Password:</label><input type="password" name="password" required><br>
                <input type="submit" name="login" value="Login">
            </form>';
    exit();
}

// Handle deletion of EOIs by job reference
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $delete_job_ref = mysqli_real_escape_string($conn, $_POST['delete_job_ref']); // Escapes dangerous characters in user input (like quotes, backslashes) to prevent SQL injection
    $query = "DELETE FROM eoi WHERE JobReferenceNumber = '$delete_job_ref'"; // Removes all rows in the eoi table where the job reference matches. Used when the HR manager wants to bulk delete submissions for a specific job.
    mysqli_query($conn, $query);
    // Check if the query was successful
    // Check if any rows were affected
    if (mysqli_affected_rows($conn) > 0) {
        echo "<p>Deleted EOIs with Job Reference: $delete_job_ref</p>";
    } else {
        // If no rows were affected, it means no EOIs were found with that Job Reference
        echo "<p>No EOIs found with Job Reference: $delete_job_ref</p>";
    }
}

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $eoi_number = mysqli_real_escape_string($conn, $_POST['eoi_number']);
    $new_status = mysqli_real_escape_string($conn, $_POST['new_status']);
    $query = "UPDATE eoi SET Status = '$new_status' WHERE EOI_Number = '$eoi_number'"; //Updates the Status field (e.g., from New → Final) of a specific EOI application.
    mysqli_query($conn, $query);
    echo "<p>Updated EOI Number: $eoi_number to Status: $new_status</p>";
}
?>


