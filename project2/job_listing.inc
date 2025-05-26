<!--LUCAS SUPERINA 105914669-->
<!--PUJAN KUKADIYA 105920242-->
<?php
<<<<<<< HEAD
=======
function display_jobs_page($_conn) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Pujan Kukadiya 105920242, LUCAS SUPERINA 105914669">
        <meta name="description" content="A job listing page for Terrible Software Inc., which lists all the available positions the company is hiring">
        <meta name="keywords" content="Jobs, Hiring, Position, Machine Learning, Software Developer">
        <link rel="stylesheet" href="./styles/styles.css">
        <title>Terrible Software Inc - Jobs</title>
    </head>

    <body class="jobs">
        <div class="container">
            <div class="glass-container">
                <header>
                    <div class="logo">
                        <img src="./styles/images/company_logo.png" alt="Terrible Software Limited Inc. logo">
                        <a href="index.php">Terrible Software Inc.</a>
                    
                        <nav class="navbar">
                            <ul class="nav-links">
                                <li class="nav-link"><a href="index.php">Home</a></li>
                                <li class="nav-link"><a href="about.php">About</a></li>
                                <li class="nav-link active"><a href="jobs.php">Jobs</a></li>
                                <li class="nav-link"><a href="apply.php">Apply</a></li>
                                <li class="nav-link"><a href="applicant_login.php">User Account</a></li>
                                <li class="nav-link"><a href="manage.php">Admin Account</a></li>
                            </ul>
                        </nav>
                    </div>
                </header>

                <div class="content">
                    <div class="main">
                        <h1 id="job_listing_header">Job Listings</h1>
                        <?php list_all_jobs($_conn); ?>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="container">
                <div class="glass-container-footer">
                    <div class="footer">
                        <ul>
                            <li><a href="https://terrible-software-inc.atlassian.net/jira/software/projects/SCRUM/boards/1/backlog?atlOrigin=eyJpIjoiZTBkZGQ2ODY2MzdlNGFkMWI1ODNiN2JjMDg1ZjNkYzkiLCJwIjoiaiJ9">Jira Project</a></li>
                            <li><a href="https://github.com/LucasSuperina/TSI_Website" target="_blank">GitHub</a></li>
                            <li><a href="mailto:info@terriblesoftwareinc.com">Email Us</a></li>
                            <li>© 2025 Terrible Software Inc.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </body>
    </html>
    <?php
}
>>>>>>> 6fe6da33a376618c4f1b3a58404d126e64c4c7bf

function list_all_jobs($_conn) {
    $sql = "SELECT * FROM job_listing_info";
    $result = mysqli_query($_conn, $sql);

    while ($listing = mysqli_fetch_assoc($result)) {
        job_listing($listing, $_conn);
    }
}

function job_listing($_listing, $_conn) {
    $_Title = $_listing["Title"];
    $_Location = $_listing["Location"];
    $_Salary_Lower = $_listing["Salary Lower"];
    $_Salary_Upper = $_listing["Salary Upper"];
    $_Description = $_listing["Description"];
    $_Reports_To = $_listing["Reports To"];
    $_Reference_Number = $_listing["Reference Number"];

    $_Salary_Formatted = "$".number_format($_Salary_Lower)." - "."$".number_format($_Salary_Upper);
    
    $Key_Responsibilities = get_point_list_from_type($_Reference_Number, "Key Responsibilities", $_conn);
    $_Essential_QSKA = get_point_list_from_type($_Reference_Number, "Essential QSKA", $_conn);
    $_Prefered_QSKA = get_point_list_from_type($_Reference_Number, "Preferred QSKA", $_conn);

    echo '<aside class="job-item">';
        echo "<h2>".htmlspecialchars($_Title)."</h2>";
        echo "<p>Location: ".htmlspecialchars($_Location)."</p>";
        echo "<p>Salary: ".htmlspecialchars($_Salary_Formatted)."</p>";
        echo "<p>Description: ".htmlspecialchars($_Description)."</p>";
        echo "<p>Reports to: ".htmlspecialchars($_Reports_To)."</p>";
        echo "<p>Reference Number: ".htmlspecialchars($_Reference_Number)."</p>";
        echo "<h2>Key Responsibilities</h2>";
        create_responsibilities_QSKA_list($Key_Responsibilities, TRUE);
        echo "<h2>Required Qualifications, Skills, Knowledge and Attributes</h2>";
        echo "<h3>Essential</h3>";
        create_responsibilities_QSKA_list($_Essential_QSKA, FALSE);
        echo "<h3>Preferable</h3>";
        create_responsibilities_QSKA_list($_Prefered_QSKA, FALSE);
    echo '<button class="button" onclick="location.href=\'apply.php\'">Apply Now</button>';
    echo "</aside>";
    echo "<br><br>";
}

function get_point_list_from_type($reference_number, $_point_type, $_conn) {
    $sql = "SELECT * FROM job_listing_info_points WHERE `Reference Number` LIKE '$reference_number' AND `Point_Type` LIKE '$_point_type'";
    $result = mysqli_query($_conn, $sql);

    $return_array = [];
    $i = 0;
    while ($point = mysqli_fetch_assoc($result)) {
        $return_array[$i] = $point["Point_Text"];
        $i += 1;
    } 

    return $return_array;
}

function create_responsibilities_QSKA_list($_points, $_is_ul) {
    $list_tag = $_is_ul ? "ul" : "ol";
    
    echo "<$list_tag>";
    foreach ($_points as $point) {
        echo "<li>".htmlspecialchars($point)."</li>";
    }  
    echo "</$list_tag>";
}
?>
    echo '<aside class="job-item">';
        echo "<h2>$_Title</h2>";
        echo "<p>Location: $_Location</p>";
        echo "<p>Salary: $_Salary_Formatted</p>";
        echo "<p>Description: $_Description</p>";
        echo "<p>Reports to: $_Reports_To</p>";
        echo "<p>Reference Number: $_Reference_Number</p>";
        echo "<h2>Key Responsibilities</h2>";
        create_responsibilities_QSKA_list($Key_Responsibilities, TRUE);
        echo "<h2>Required Qualifications, Skills, Knowledge and Attributes</h2>";
        echo "<h3>Essential</h3>";
        create_responsibilities_QSKA_list($_Essential_QSKA, FALSE);
        echo "<h3>Preferable</h3>";
        create_responsibilities_QSKA_list($_Prefered_QSKA, FALSE);
    echo '<button class="button" onclick="location.href=\'apply.php\'">Apply Now</button>';
    echo "</aside>";
    echo "<br><br>";

function get_point_list_from_type($reference_number, $_point_type, $_conn) {
    $sql = "SELECT * FROM job_listing_info_points WHERE `Reference Number` LIKE '$reference_number' AND `Point_Type` LIKE '$_point_type'";
    $result = mysqli_query($_conn, $sql);

    $return_array = [];
    $i = 0;
    while ($point = mysqli_fetch_assoc($result)) {
        $return_array[$i] = $point["Point_Text"];
        $i += 1;
    } 

    return $return_array;
}

function create_responsibilities_QSKA_list($_points, $_is_ul) {
    $list_tag = $_is_ul ? "ul" : "ol";
    
    echo "<$list_tag>";
    foreach ($_points as $point) {
        echo "<li>$point</li>";
    }  
    echo "</$list_tag>";
}
?>