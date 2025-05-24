<!-- JAY KSHIRSAGAR 105912265 -->
<!-- Part of Enhancements -->

<?php


session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $street_address = trim($_POST['street_address']);
    $suburb = trim($_POST['suburb']);
    $state = $_POST['state'];
    $postcode = trim($_POST['postcode']);
    $phone = trim($_POST['phone']);

    $skills = isset($_POST['skills']) ? $_POST['skills'] : [];
    $skill_html = in_array("HTML", $skills) ? 1 : 0;
    $skill_css = in_array("CSS", $skills) ? 1 : 0;
    $skill_js = in_array("JavaScript", $skills) ? 1 : 0;
    $other_skills = isset($_POST['other_skills']) ? trim($_POST['other_skills']) : '';

    // Input validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($first_name) || empty($last_name) || empty($dob) || empty($gender)) {
        $error = "All required fields must be filled";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address";
    } elseif (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]{2,29}$/', $username)) {
        $error = "Username must be 3–30 characters, start with a letter, and contain only letters, numbers, or underscores.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        $error = "Password must be at least 8 characters and include uppercase, lowercase, number, and special character.";
    } else {
        $conn = new mysqli("localhost", "root", "", "terrible_db");

        if ($conn->connect_error) {
            $error = "Connection failed: " . $conn->connect_error;
        } else {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $error = "An account with this email already exists.";
            } else {
                $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $error = "Username is already taken.";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users 
                        (username, password, email, first_name, last_name, dob, gender, street_address, suburb, state, postcode, phone, skill_html, skill_css, skill_js, other_skills) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssssssssiiiss", 
                        $username, $hashed_password, $email, 
                        $first_name, $last_name, $dob, $gender, 
                        $street_address, $suburb, $state, $postcode, $phone, 
                        $skill_html, $skill_css, $skill_js, $other_skills);

                    if ($stmt->execute()) {
                        $success = "Account created successfully! Redirecting to login...";
                        header("refresh:2;url=login.php");
                    } else {
                        $error = "Error creating account: " . $stmt->error;
                    }
                }
            }
            $stmt->close();
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Jay Kshirsagar 105912265">
    <meta name="description" content="Create an account for Terrible Software Inc. to apply for jobs.">
    <meta name="keywords" content="Create Account, Terrible Software Inc., User Registration, Sign Up">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Terrible Software Inc - Home</title>
</head>
<body>
    <h2>Create Account</h2>

    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    <?php if (isset($success)) echo "<div class='success'>$success</div>"; ?>

    <form method="post" action="">
        <fieldset>
            <legend>Personal Information</legend>
            <label>First Name:</label>
            <input type="text" name="first_name" required><br>
            <label>Last Name:</label>
            <input type="text" name="last_name" required><br>
            <label>Date of Birth:</label>
            <input type="date" name="dob" required><br>
            <label>Gender:</label>
            <input type="radio" name="gender" value="Male" required> Male
            <input type="radio" name="gender" value="Female" required> Female<br>
        </fieldset>

        <fieldset>
            <legend>Address</legend>
            <label>Street Address:</label>
            <input type="text" name="street_address"><br>
            <label>Suburb/Town:</label>
            <input type="text" name="suburb"><br>
            <label>State:</label>
            <select name="state">
                <option value="">Select your state</option>
                <option value="VIC">VIC</option>
                <option value="NSW">NSW</option>
                <option value="QLD">QLD</option>
                <option value="WA">WA</option>
                <option value="SA">SA</option>
                <option value="TAS">TAS</option>
                <option value="ACT">ACT</option>
                <option value="NT">NT</option>
            </select><br>
            <label>Postcode:</label>
            <input type="text" name="postcode"><br>
        </fieldset>

        <fieldset>
            <legend>Contact Information</legend>
            <label>Email:</label>
            <input type="email" name="email" required><br>
            <label>Phone:</label>
            <input type="text" name="phone"><br>
        </fieldset>

        <fieldset>
            <legend>Required Technical</legend>
            <label>Skills:</label><br>
            <input type="checkbox" name="skills[]" value="HTML"> HTML<br>
            <input type="checkbox" name="skills[]" value="CSS"> CSS<br>
            <input type="checkbox" name="skills[]" value="JavaScript"> JavaScript<br>
            <input type="checkbox" name="skills[]" value="Other"> Other skills<br>
            <label>Please specify:</label><br>
            <textarea name="other_skills"></textarea>
        </fieldset>

        <fieldset>
            <legend>Account Info</legend>
            <label>Username:</label>
            <input type="text" name="username" required><br>
            <label>Password:</label>
            <input type="password" name="password" required><br>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required><br>
        </fieldset>

        <input type="submit" value="Create Account">
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
