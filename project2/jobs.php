<!--PUJAN KUKADIYA 105920242-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Pujan Kukadiya 105920242">
    <meta name="description" content="A job listing page for Terrible Software Inc., which lists all the available positions the company is hiring">
    <meta name="keywords" content="Jobs, Hiring, Position, Machine Learning, Software Developer">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Terrible Software Inc - Jobs</title>
</head>

<?php
    require_once("settings.php");   

    include "job_listing.inc";

    include "header.inc";
?>

<body class="jobs">
    <div class="container">
        <div class="glass-container">
            <?php createHeader("Jobs"); ?>

            <main class="main">
                <h1 id="job_listing_header">Job Listings</h1>
                <?php
                    list_all_jobs($conn);
                ?>    
            </main>
        </div>
    </div>

    <?php include "footer.inc"?>
</body>
</html>