<!--JAY KSHIRSAGAR 105912265-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Jay Kshirsagar 105912265">
    <meta name="description" content="A home page for Terrible Software Inc., containing information about the company">
    <meta name="keywords" content="About, About Page, Innovation, Impact, Terrible Software Inc.">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Terrible Software Inc - Home</title>
</head>
<body class="home">
    <div class="container">
        <div class="glass-container">
            <?php
                include "header.inc";
                createHeader("Home");
            ?>
        
            <main class="main">                    
                <section class="hero">
                    <img src="./styles/images/index_page_background_image.jpg" alt="">
                    <div class="hero-text">
                        <h1>Creating Tomorrow</h1>
                        <p>Up for the challenge?</p>
                        <div class="hero-buttons">
                            <a href="apply.php" class="apply-btn">Apply Now</a>
                            <a href="jobs.php" class="jobs-btn">View Jobs</a>
                        </div>
                    </div>
                </section>
                <section>
                    <h2><strong>Our Story</strong></h2>
                    <p>In a world that moves at the speed of innovation, we began with a simple idea: <strong><u>use technology to solve real-world problems in meaningful ways</u></strong>.</p>
                    <p>Our journey started in <strong>2020</strong> with a small team of <strong><u>dreamers, developers, and doers</u></strong> who believed that great technology isn&#39;t just built—it&#39;s <strong><u>crafted with purpose</u></strong>. From a garage, a coffee shop, or maybe just a shared screen across time zones, we laid the first lines of code with one mission in mind: <strong><u>to create solutions that empower people and elevate businesses</u></strong>.</p>
                    <p>Since then, we&#39;ve grown—but our core hasn&#39;t changed. Every project we take on is rooted in <strong><u>curiosity, collaboration, and care</u></strong>. Whether it&#39;s building intelligent software, designing secure cloud systems, or designing seamless user experiences, we believe tech should <strong><u>feel human, be intuitive, and spark progress</u></strong>.</p>

                    <h2><strong>Why Join Us?</strong></h2>
                    <p>We&#39;re not just building products—we&#39;re building a company where people love to work. At <strong>Terrible Software</strong>, we believe in:</p>
                    <ul>
                        <li><strong>Ownership</strong>: Everyone here is a creator. Your voice matters, and your ideas help shape what we build.</li>
                        <li><strong>Growth</strong>: We invest in <strong><u>continuous learning, mentorship</u></strong>, and real opportunities to grow your skills and your career.</li>
                        <li><strong>Flexibility</strong>: Work-life balance isn&#39;t just a buzzword. We support <strong><u>remote work, flexible hours</u></strong>, and the tools you need to thrive.</li>
                        <li><strong>Impact</strong>: You won&#39;t be just another cog in the machine. The work you do here directly impacts our <strong><u>clients, our team, and the future of tech</u></strong>.</li>
                    </ul>
                </section>
            </main>
        </div>
    </div>

    <?php include "footer.inc"?>
</body>