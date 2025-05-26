<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $dob = trim($_POST['dob']);
    $gender = trim($_POST['gender']);
    $streetAddress = trim($_POST['streetAddress']);
    $suburb = trim($_POST['suburb']);
    $state = trim($_POST['state']);
    $postcode = trim($_POST['postcode']);
    $phoneNumber = trim($_POST['phoneNumber']);

    // Handle skills from checkboxes
    $selectedSkills = isset($_POST['skills']) ? (array)$_POST['skills'] : [];
    
    // Initialize skill variables
    $skill1 = '';
    $skill2 = '';
    $skill3 = '';
    $skill4 = '';

    // Assign selected skills to the database columns
    $skillIndex = 1;
    if (in_array('HTML', $selectedSkills)) {
        if ($skillIndex == 1) $skill1 = 'HTML';
        else if ($skillIndex == 2) $skill2 = 'HTML';
        else if ($skillIndex == 3) $skill3 = 'HTML';
        else if ($skillIndex == 4) $skill4 = 'HTML';
        $skillIndex++;
    }
    if (in_array('CSS', $selectedSkills)) {
        if ($skillIndex == 1) $skill1 = 'CSS';
        else if ($skillIndex == 2) $skill2 = 'CSS';
        else if ($skillIndex == 3) $skill3 = 'CSS';
        else if ($skillIndex == 4) $skill4 = 'CSS';
        $skillIndex++;
    }
    if (in_array('JavaScript', $selectedSkills)) {
        if ($skillIndex == 1) $skill1 = 'JavaScript';
        else if ($skillIndex == 2) $skill2 = 'JavaScript';
        else if ($skillIndex == 3) $skill3 = 'JavaScript';
        else if ($skillIndex == 4) $skill4 = 'JavaScript';
        $skillIndex++;
    }
    // You could add logic here for other specific skills if you had more checkboxes
    // and wanted them mapped to Skill4. For now, it will remain empty if only the three are selected.

    $otherSkills = trim($_POST['otherSkills']);
    $status = "Pending";

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) ||
        empty($firstName) || empty($lastName) || empty($dob) ||
        empty($gender) || empty($streetAddress) || empty($suburb) || empty($state) ||
        empty($postcode) || empty($phoneNumber) || (empty($selectedSkills) && empty($otherSkills)) // Require at least one skill or other skills
    ) {
        $error = "All mandatory fields are required (including at least one skill or other skills).";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address";
    } elseif (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]{2,29}$/', $username)) {
        $error = "Username must be 3–30 characters, start with a letter, and contain only letters, numbers, or underscores.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        $error = "Password must be at least 8 characters and include uppercase, lowercase, number, and special character.";
    } else {
        $conn = new mysqli("localhost", "root", "", "tsi_website");

        if ($conn->connect_error) {
            $error = "Connection failed: " . $conn->connect_error;
        } else {
            $stmt = $conn->prepare("SELECT EOInumber FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $error = "An account with this email already exists.";
                $stmt->close();
            } else {
                $stmt->close();
                $stmt = $conn->prepare("SELECT EOInumber FROM users WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $error = "Username is already taken.";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    $stmt = $conn->prepare("INSERT INTO users (Username, Password, FirstName, LastName, DOB, Gender, StreetAddress, Suburb, State, Postcode, Email, PhoneNumber, Skill1, Skill2, Skill3, Skill4, OtherSkills, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param(
                        "ssssssssssssssssss",
                        $username,
                        $hashed_password,
                        $firstName,
                        $lastName,
                        $dob,
                        $gender,
                        $streetAddress,
                        $suburb,
                        $state,
                        $postcode,
                        $email,
                        $phoneNumber,
                        $skill1,
                        $skill2,
                        $skill3,
                        $skill4,
                        $otherSkills,
                        $status
                    );

                    if ($stmt->execute()) {
                        $success = "Account created successfully! Redirecting to login...";
                        header("refresh:2;url=applicant_login.php");
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
<html lang="en">
<head>
    <title>Create Account</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Jay Kshirsagar 105912265">
    <meta name="description" content="Create an account for Terrible Software Inc.">
    <meta name="keywords" content="Login users, Terrible Software Inc., HTML, CSS, Javascript">
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body class="manage">
    <?php include "header.inc"; ?>

    <div class="container">
        <div class="glass-container">
            <?php
                  if (function_exists('createHeader')) {
                      createHeader("Create Account");
                  } else {
                      echo '<h1>Create Account</h1>';
                  }
            ?>

            <div class="content">
                <div class="main">
                    <h2>Create Account</h2>

                    <?php if (isset($error)): ?>
                        <div class="error-message"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                        <div class="success-message"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form method="post" action="">
                        <div class="form-group">
                            <label for="username">Username (for login):</label>
                            <input type="text" id="username" name="username" required
                                   value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                        </div>
                        <br>

                        ---

                        <h3>Personal Information</h3>
                        <div class="form-group">
                            <label for="firstName">First Name:</label>
                            <input type="text" id="firstName" name="firstName" required
                                   value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="lastName">Last Name:</label>
                            <input type="text" id="lastName" name="lastName" required
                                   value="<?php echo isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : ''; ?>">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" id="dob" name="dob" required
                                   value="<?php echo isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="streetAddress">Street Address:</label>
                            <input type="text" id="streetAddress" name="streetAddress" required
                                   value="<?php echo isset($_POST['streetAddress']) ? htmlspecialchars($_POST['streetAddress']) : ''; ?>">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="suburb">Suburb:</label>
                            <input type="text" id="suburb" name="suburb" required
                                   value="<?php echo isset($_POST['suburb']) ? htmlspecialchars($_POST['suburb']) : ''; ?>">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="state">State:</label>
                            <input type="text" id="state" name="state" required
                                   value="<?php echo isset($_POST['state']) ? htmlspecialchars($_POST['state']) : ''; ?>">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="postcode">Postcode:</label>
                            <input type="text" id="postcode" name="postcode" required
                                   value="<?php echo isset($_POST['postcode']) ? htmlspecialchars($_POST['postcode']) : ''; ?>">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number:</label>
                            <input type="tel" id="phoneNumber" name="phoneNumber" required
                                   value="<?php echo isset($_POST['phoneNumber']) ? htmlspecialchars($_POST['phoneNumber']) : ''; ?>">
                        </div>
                        <br>

                        ---

                        <h3>Skills Information</h3>
                        <div class="form-group">
                            <label>Select Skills:</label><br>
                            <input type="checkbox" id="skill_html" name="skills[]" value="HTML"
                                <?php echo (isset($_POST['skills']) && in_array('HTML', $_POST['skills'])) ? 'checked' : ''; ?>>
                            <label for="skill_html">HTML</label><br>

                            <input type="checkbox" id="skill_css" name="skills[]" value="CSS"
                                <?php echo (isset($_POST['skills']) && in_array('CSS', $_POST['skills'])) ? 'checked' : ''; ?>>
                            <label for="skill_css">CSS</label><br>

                            <input type="checkbox" id="skill_javascript" name="skills[]" value="JavaScript"
                                <?php echo (isset($_POST['skills']) && in_array('JavaScript', $_POST['skills'])) ? 'checked' : ''; ?>>
                            <label for="skill_javascript">JavaScript</label><br>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="otherSkills">Other Skills (Optional):</label>
                            <textarea id="otherSkills" name="otherSkills" rows="4"><?php echo isset($_POST['otherSkills']) ? htmlspecialchars($_POST['otherSkills']) : ''; ?></textarea>
                        </div>
                        <br>

                        <input type="submit" value="Create Account">
                    </form>

                    <p><a href='applicant_login.php' style='margin-top: 1.5em; display: flex; padding: 0.6em 1.5em; background:rgba(248, 164, 155, 0.18); color: white; border-radius: 6px; text-decoration: none;'>Already have an account?<strong>Login Here</strong></a><p>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.inc"; ?>
</body>
</html>