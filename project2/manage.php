<!--MAGGIE XIN YI LAW 103488683-->
<!--PUJAN KUKADIYA 105920242-->

<?php
// Start session to manage login and authentication state
session_start();
require_once"settings.php"; // Include database connection settings

// Database connection
// Check if the session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Maggie Xin Yi Law 103488683">
    <meta name="description" content="Manage EOIs for Terrible Software Inc.">
    <meta name="keywords" content="EOI, Job Application, Management, Terrible Software Inc., HTML, CSS, Javascript">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Terrible Software Inc - Manage EOIs</title>
</head>

<?php
    include"header.inc";
?>

<body class="manage">
    <div class="container">
        <div class="glass-container">
            <?php
                createHeader("Admin Account");
            ?>

            <?php
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
                echo '<div class="content">';
                    echo '<main class="main">';
                        echo "<h2>HR Manager Login</h2>";
                        // Display login error if any
                        // Use htmlspecialchars to prevent XSS attacks
                        if ($login_error) echo "<p style='color:red;'>$login_error</p>";
                        echo    '<form method="POST" action="manage.php">
                                    <div class="form-group">
                                    <label>Username:</label>
                                    <input type="text" name="username" required>
                                    </div><br>
                                    <div class="form-group">
                                    <label>Password:</label>
                                    <input type="password" name="password" required>
                                    </div><br>
                                    <button type="submit" name="login" value="Login">Login</button><br>
                                </form>';
                        echo "<a href='register_hr.php' style='margin-top: 1.5em; display: flex; padding: 0.6em 1.5em; background:rgba(248, 164, 155, 0.18); color: white; border-radius: 6px; text-decoration: none;'>No account yet?<strong>Register Here</strong></a>";
                    echo '</main>';
                echo '</div>';
            echo '</div>';
            echo '</div>';
            include "footer.inc";
            echo '</body>';
            exit();
            }

            // Handle deletion of EOIs by job reference
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
                $delete_job_ref = mysqli_real_escape_string($conn, $_POST['delete_job_ref']); // Escapes dangerous characters in user input (like quotes, backslashes) to prevent SQL injection
                $query = "DELETE FROM eoi WHERE JobReferenceNumber = '$delete_job_ref'"; // Removes all rows in the eoi table where the job reference matches. Used when the HR manager wants to bulk delete submissions for a specific job.
                mysqli_query($conn, $query);
                // Check if the query was successful
                // & also if any rows were affected
                if (mysqli_affected_rows($conn) > 0) {
                    echo '<aside class="confirmation_box">';
                    echo "<p>Deleted EOIs with Job Reference: $delete_job_ref</p>";
                    echo '</aside>';
                } else {
                    // If no rows affected, it means no EOIs were found with that Job Reference
                    echo '<aside class="error_box">';
                    echo "<p>No EOIs found with Job Reference: $delete_job_ref</p>";
                    echo '</aside>';
                }
            }

            // Handle status update
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
                $eoi_number = mysqli_real_escape_string($conn, $_POST['eoi_number']);
                $new_status = mysqli_real_escape_string($conn, $_POST['new_status']);
                $query = "UPDATE eoi SET Status = '$new_status' WHERE EOInumber = '$eoi_number'"; //Updates the Status field (e.g., from New → Final) of a specific EOI application.
                mysqli_query($conn, $query);
                echo '<aside class="confirmation_box">';
                echo "<p>Updated EOI Number: $eoi_number to Status: $new_status</p>";
                echo '</aside>';
            }
            ?>

            <a class='fake_button' href='logout.php'>Logout</a>
            <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
            <h1>Manage EOIs</h1>
            <hr>
            <div class="content">
                <main class="main">
                    <p>Use the forms below to manage EOIs.</p><br>
                    <!-- Form to search EOIs by job reference, name, or sort -->
                    <form method="GET" action="manage.php">
                        <fieldset>
                            <legend>Search EOIs</legend><br>
                            <select name="sort_by">
                                <option value="">Sort by...</option>
                                <option value="EOInumber">EOI Number</option>
                                <option value="LastName">Last Name</option>
                                <option value="Status">Status</option>
                            </select>
                            <br><br>
                            <input type="text" name="job_ref" placeholder="Job Ref Number">
                            <input type="text" name="first_name" placeholder="First Name">
                            <input type="text" name="last_name" placeholder="Last Name">
                            
                    <input type="submit" value="Search">
                        </fieldset>
                    </form>
                    <br><br>
                    <!-- Form to delete EOIs by job reference -->
                    <form method="POST" action="manage.php">
                        <fieldset>
                            <legend>Delete EOIs by Job Ref</legend>
                            <input type="text" name="delete_job_ref" placeholder="Enter Job Ref" required>
                            <input type="submit" name="delete" value="Delete">
                        </fieldset>
                    </form>
                </main>
            </div>


            <?php
            // Display search results if filters are applied
            if ($_SERVER["REQUEST_METHOD"] == "GET" && (isset($_GET['job_ref']) || isset($_GET['first_name']) || isset($_GET['last_name']))) {
                $filters = [];
                if (!empty($_GET['job_ref'])) $filters[] = "JobReferenceNumber = '" . mysqli_real_escape_string($conn, $_GET['job_ref']) . "'";
                if (!empty($_GET['first_name'])) $filters[] = "FirstName = '" . mysqli_real_escape_string($conn, $_GET['first_name']) . "'";
                if (!empty($_GET['last_name'])) $filters[] = "LastName = '" . mysqli_real_escape_string($conn, $_GET['last_name']) . "'";
                $where_clause = count($filters) > 0 ? "WHERE " . implode(" AND ", $filters) : "";
                $sort_clause = !empty($_GET['sort_by']) ? "ORDER BY " . $_GET['sort_by'] : "";
                // Selects all columns from the eoi table where the filters match, & optional sort order.
                // The WHERE clause is built dynamically based on the filters provided by the user.
                $query = "SELECT * FROM eoi $where_clause $sort_clause"; 
                // WHERE JobReferenceNumber = 'ABC123' AND FirstName = 'John'   // ORDER BY LastName
                $result = mysqli_query($conn, $query);
            
                // Display the results in a table
                if (mysqli_num_rows($result) > 0) {
                    echo "<h2>Search Results</h2>";
                    echo "<p>Found " . mysqli_num_rows($result) . " EOIs matching the criteria.</p>";
                    echo "<table class='eoi-table'>";
                    // Table headers
                    echo "<tr>";
                        echo "<th>EOI Number</th>";
                        echo "<th>Job Reference Number</th>";
                        echo "<th>First Name</th>";
                        echo "<th>Last Name</th>";
                        echo "<th>Status</th>";
                        echo "<th>Change Status</th>";
                    echo "</tr>";
                    while ($row = mysqli_fetch_assoc($result)) { //loop through all rows to display them in a table
                        echo "<tr>";
                        echo "<td>{$row['EOInumber']}</td>";
                        echo "<td>{$row['JobReferenceNumber']}</td>";
                        echo "<td>{$row['FirstName']}</td>";
                        echo "<td>{$row['LastName']}</td>";
                        echo "<td>{$row['Status']}</td>";
                        // Inline form to CHANGE STATUS for a specific EOI
                        echo "<td>
                                <form method='POST' action='manage.php'>
                                    <input type='hidden' name='eoi_number' value='{$row['EOInumber']}'>
                                    <select name='new_status'>
                                        <option value='New'>New</option>
                                        <option value='Current'>Current</option>
                                        <option value='Final'>Final</option>
                                    </select>
                                    <input type='submit' name='update_status' value='Update'>
                                </form>
                            </td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No EOIs found matching the criteria.</p>";
                }
            }
            ?>
        </div>
    </div>
    <?php
    include "footer.inc"
?>
</body>

</html>