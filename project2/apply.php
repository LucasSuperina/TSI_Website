<!--MAGGIE XIN YI LAW 103488683-->
<!-- JAY KSHIRSAGAR 105912265 -->

<!-- This is the application page for Terrible Software Inc. where users can apply for jobs. -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Maggie Xin Yi Law 103488683 and Jay Kshirsagar 105912265">
    <meta name="description" content="An application page for Terrible Software Inc. where users can apply for jobs.">
    <meta name="keywords" content="Job, Job Application, Application Form, Terrible Software Inc., HTML, CSS, Javascript">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Terrible Software Inc - Applications</title>
</head>

<?php
    session_start();
    include "header.inc";

    if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_SESSION['loggedin'])) {
        header("Location: login.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['loggedin'])) {
        $conn = new mysqli("localhost", "root", "", "terrible_db");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $user_id = $_SESSION['loggedin'];
        $job_ref = $_POST['job-reference-number'];

        // Check for existing application
        $check = $conn->prepare("SELECT * FROM eoi WHERE JobRefNumber = ? AND Email = (SELECT email FROM users WHERE id = ?)");
        $check->bind_param("si", $job_ref, $user_id);
        $check->execute();
        $existing = $check->get_result();

        if ($existing->num_rows > 0) {
            echo "<script>alert('You have already applied for this job.');</script>";
        } else {
            $query = "SELECT * FROM users WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($user = $result->fetch_assoc()) {
                $skills = [];
                if ($user['skill_html']) $skills[] = "HTML";
                if ($user['skill_css']) $skills[] = "CSS";
                if ($user['skill_js']) $skills[] = "JavaScript";

                // Assign skill values
                $skill1 = isset($skills[0]) ? $skills[0] : NULL;
                $skill2 = isset($skills[1]) ? $skills[1] : NULL;
                $skill3 = isset($skills[2]) ? $skills[2] : NULL;

                $insert = $conn->prepare("INSERT INTO eoi (JobRefNumber, FirstName, LastName, StreetAddress, Suburb, State, Postcode, Email, Phone, Skill1, Skill2, Skill3, OtherSkills, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'New')");
                $insert->bind_param("sssssssssssss",
                    $job_ref,
                    $user['first_name'],
                    $user['last_name'],
                    $user['street_address'],
                    $user['suburb'],
                    $user['state'],
                    $user['postcode'],
                    $user['email'],
                    $user['phone'],
                    $skill1,
                    $skill2,
                    $skill3,
                    $user['other_skills']
                );

                if ($insert->execute()) {
                    echo "<script>alert('Application submitted successfully!');</script>";
                } else {
                    echo "<script>alert('Error submitting application: " . $insert->error . "');</script>";
                }

                $insert->close();
            }

            $stmt->close();
        }

        $check->close();
        $conn->close();
    }
?>

<body class="apply">
    <div class="container">
        <div class="glass-container">
            <?php createHeader("Apply"); ?>

            <div class="content">
                <div class="main">
                    <h1>Application Form</h1>
                    <hr>
                    <form action="" method="post" novalidate>
                        <br>
                        <label for="job-reference-number">Job Reference No. : </label>
                        <select name="job-reference-number" id="job-reference-number">
                            <option value="ML123">AI/ML Engineer - ML123</option>
                            <option value="SD123">Software Engineer - SD123</option>
                        </select><br><br>

                        <button type="submit" name="submit">Apply</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <?php include "footer.inc"; ?>
</body>
</html>
