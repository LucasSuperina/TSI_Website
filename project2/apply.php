<?php
session_start();
require_once("settings.php");
include "header.inc";

$prefillData = [];
$loggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

if ($loggedIn) {
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    
    $prefillData = $result->fetch_assoc();
    

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="author" content="Maggie Xin Yi Law 103488683"/>
    <meta name="description" content="An application page for Terrible Software Inc. where users can apply for jobs."/>
    <meta name="keywords" content="Job, Job Application, Application Form, Terrible Software Inc., HTML, CSS, Javascript"/>
    <link rel="stylesheet" href="./styles/styles.css"/>
    <title>Terrible Software Inc - Applications</title>
</head>

<body class="apply">
    <div class="container">
        <div class="glass-container">
            <?php createHeader("Apply"); ?>

            <div class="content">
                <div class="main">
                    <h1>Application Form</h1>
                    <hr>
                    <form action="process_eoi.php" method="post" novalidate>
                        <br>
                        <label for="job-reference-number">Job Reference No. : </label>
                        <select name="job-reference-number" id="job-reference-number" required>
                            <option value="">--Select--</option>
                            <option value="ML123">AI/ML Engineer - ML123</option>
                            <option value="SD123">Software Engineer - SD123</option>
                        </select><br><br>

                        <?php if (!$loggedIn): ?>
                            <!-- Guest Form -->
                            <div class="form-group">
                                <label for="first-name">First Name:</label>
                                <input type="text" id="first-name" name="FirstName" required><br><br>

                                <label for="last-name">Last Name:</label>
                                <input type="text" id="last-name" name="LastName" required><br><br>

                                <label for="dob">Date of Birth:</label>
                                <input type="date" id="dob" name="DOB" required><br><br>

                                <label>Gender:</label>
                                <input type="radio" name="Gender" value="Male" required> Male
                                <input type="radio" name="Gender" value="Female"> Female<br><br>

                                <label for="street">Street Address:</label>
                                <input type="text" id="street" name="StreetAddress" required><br><br>

                                <label for="suburb">Suburb:</label>
                                <input type="text" id="suburb" name="Suburb" required><br><br>

                                <label for="state">State:</label>
                                <input type="text" id="state" name="State" required><br><br>

                                <label for="postcode">Postcode:</label>
                                <input type="text" id="postcode" name="Postcode" required><br><br>

                                <label for="email">Email:</label>
                                <input type="email" id="email" name="Email" required><br><br>

                                <label for="phone">Phone:</label>
                                <input type="tel" id="phone" name="PhoneNumber" required><br><br>

                                <label>Skills:</label><br>
                                <input type="checkbox" name="Skill1" value="Teamwork"> Teamwork<br>
                                <input type="checkbox" name="Skill2" value="Problem Solving"> Problem Solving<br>
                                <input type="checkbox" name="Skill3" value="Communication"> Communication<br>
                                <input type="checkbox" name="Skill4" value="Programming"> Programming<br><br>

                                <label for="other-skills">Other Skills:</label><br>
                                <textarea id="other-skills" name="OtherSkills" rows="4" cols="50"></textarea><br><br>
                            </div>

                        <?php else: ?>
                            <!-- Logged-in View -->
                            <p><strong>Welcome back, <?php echo htmlspecialchars($prefillData['FirstName'] ?? ''); ?>.</strong> Your saved details will be used:</p>
                            <ul>
                                <li>Name: <?php echo htmlspecialchars($prefillData['FirstName'] . ' ' . $prefillData['LastName']); ?></li>
                                <li>DOB: <?php echo htmlspecialchars($prefillData['DOB']); ?></li>
                                <li>Gender: <?php echo htmlspecialchars($prefillData['Gender']); ?></li>
                                <li>Address: <?php echo htmlspecialchars($prefillData['StreetAddress'] . ', ' . $prefillData['Suburb'] . ', ' . $prefillData['State'] . ' ' . $prefillData['Postcode']); ?></li>
                                <li>Email: <?php echo htmlspecialchars($prefillData['Email']); ?></li>
                                <li>Phone: <?php echo htmlspecialchars($prefillData['PhoneNumber']); ?></li>
                                <li>State: <?php echo htmlspecialchars($prefillData['State']); ?></li>
                                <li>Skills: <?php echo implode(', ', array_filter([
                                    $prefillData['Skill1'],
                                    $prefillData['Skill2'],
                                    $prefillData['Skill3'],
                                    $prefillData['Skill4']
                                ])); ?></li>
                                <li>Other Skills: <?php echo htmlspecialchars($prefillData['OtherSkills']); ?></li>
                            </ul>

                            <?php foreach ($prefillData as $key => $value): ?>
                                <?php if (!in_array($key, ['EOInumber', 'JobReferenceNumber', 'Status'])): ?>
                                    <input type="hidden" name="<?php echo htmlspecialchars($key); ?>" value="<?php echo htmlspecialchars($value); ?>">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <br><button type="submit" name="submit">Apply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.inc"; ?>
</body>
</html>
