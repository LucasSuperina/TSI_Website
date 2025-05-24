<!-- JAY KSHIRSAGAR 105912265 -->
<!-- Part of Enhancements -->



<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Database connection parameters
    $servername = "localhost";
    $db_username = "root"; // Change this to your database username
    $db_password = "";     // Change this to your database password
    $dbname = "terrible_db"; // Your database name
    
    // Connect to MySQL database
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        $error = "Connection failed: " . $conn->connect_error;
    } else {
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // User exists, verify password
            $user = $result->fetch_assoc();
            // Check if password is hashed or plain text (for your existing data)
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                // Password is correct
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $stmt->close();
                $conn->close();
                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid password";
            }
        } else {
            // User doesn't exist, redirect to create account page
            $stmt->close();
            $conn->close();
            header("Location: create_account.php");
            exit;
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