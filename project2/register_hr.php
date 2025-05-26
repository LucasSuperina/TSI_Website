<!--HTML: MAGGIE XIN YI LAW 103488683-->
<!--PHP: PUJAN KUKADIYA 105920242-->
<!-- Part of Enhancements -->

<!--HR Manager Registration Page-->

<?php
// Start session
session_start();
require_once("settings.php");

$company_verification_code = "TSI2025"; // Hardcoded verification code for simplicity

// Database connection
// Check if the session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize variables
$username = $password = $confirm_password = $verify_code = "";
$username_err = $password_err = $confirm_password_err = $verify_code_err = $success_msg = "";

// If form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);

        // Check if username already exists in hr_users table
        $sql = "SELECT username FROM hr_users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql); // Prepare query
        mysqli_stmt_bind_param($stmt, "s", $param_username); // Bind username to query
        $param_username = $username;

        mysqli_stmt_execute($stmt); // Execute query
        mysqli_stmt_store_result($stmt); // Store result

        // If result exists, user already taken
        if (mysqli_stmt_num_rows($stmt) == 1) {
            $username_err = "This username is already taken.";
        }

        mysqli_stmt_close($stmt); // Close statement
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";     
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } elseif (!preg_match('@[A-Z]@', $_POST["password"]) || !preg_match('@[a-z]@', $_POST["password"]) || !preg_match('@[0-9]@', $_POST["password"])) {
        $password_err = "Password must include at least one uppercase letter, one lowercase letter, and one number.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate verification code
    if (empty(trim($_POST["verify_code"]))) {
        $verify_code_err = "Please enter the verification code.";
    } else {
        $verify_code = trim($_POST["verify_code"]);
        if ($verify_code !== $company_verification_code) {
            $verify_code_err = "Invalid verification code.";
        }
    }

    // If all validation passed, insert into database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($verify_code_err)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Encrypt password
        $sql = "INSERT INTO hr_users (username, password) VALUES (?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
        $param_username = $username;
        $param_password = $hashed_password;

        // Execute insert query
        if (mysqli_stmt_execute($stmt)) {
            $success_msg = "Account created successfully! You can now <a href='manage.php'>log in</a>.";
        } else {
            echo "Something went wrong. Please try again later.";
        }

        mysqli_stmt_close($stmt); // Close statement
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Maggie Xin Yi Law 103488683, Pujan Kukadiya 105920242">
    <meta name="description" content="HR Manager Registration for Terrible Software Inc.">
    <meta name="keywords" content="HR, Registration, Terrible Software Inc., HTML, CSS, Javascript">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Terrible Software Inc - Manage EOIs</title>
</head>

<?php
    include_once('header.inc');
?>

<body class="register">
    <div class="container">
        <div class="glass-container">
            <?php
                createHeader("HR Manager Registration");
            ?>
            <div class="content">
                <div class="main">
                    <h2>HR Manager Registration</h2>
                    <hr><br><br>
                    <!-- Registration Form -->
                    <form action="register_hr.php" method="post">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
                            <span style="color:red;"><?php echo $username_err; ?></span><br><br>
                        </div><br>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password">
                            <span style="color:red;"><?php echo $password_err; ?></span><br><br>
                        </div><br>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" id="confirm_password" name="confirm_password">
                            <span style="color:red;"><?php echo $confirm_password_err; ?></span><br><br>
                        </div><br>
                        <div class="form-group">
                            <label for="verify_code">Verification Code</label>
                            <input type="text" id="verify_code" name="verify_code" required>
                            <span style="color:red;"><?php echo $verify_code_err; ?></span><br><br>
                        </div><br>
                        <button type="submit" name="register">Register</button>
                    </form>
                    <!-- Display success message if registration is successful -->
                    <?php
                    if (!empty($success_msg)) {
                        echo "<p style='color:green;'>$success_msg</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


    <?php include_once'footer.inc'; ?>
</body>
</html>