<!--MAGGIE XIN YI LAW 103488683-->

<!-- This is the application page for Terrible Software Inc. where users can apply for jobs. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Maggie Xin Yi Law 103488683">
    <meta name="description" content="An application page for Terrible Software Inc. where users can apply for jobs.">
    <meta name="keywords" content="Job, Job Application, Application Form, Terrible Software Inc., HTML, CSS, Javascript">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Terrible Software Inc - Applications</title>
</head>

<?php
    include "header.inc";
?>

<body class="apply">
    <div class="container">
        <div class="glass-container">
            <?php
                createHeader("Apply");
            ?>

            <main class="content">
                <div class="main">
                    <h1>Application Form</h1>
                    <hr>
                    <!-- Disabled client-side validation -->
                    <form action="process_eoi.php" method="post" novalidate>
                        <br>
                        <label for="job-reference-number">Job Reference No. : </label>
                        <select name="job-reference-number" id="job-reference-number">
                            <option value="ML123">AI/ML Engineer - ML123</option>
                            <option value="SD123">Software Engineer - SD123</option>
                        </select><br><br>

                        <fieldset>
                            <legend>Personal Information</legend><br>
                            <label for="first-name">First Name: </label>
                            <input type="text" id="first-name" name="first-name" required pattern="[A-Za-z\\s]{1,20}">
                            <label for="last-name">Last Name: </label>
                            <input type="text" id="last-name" name="last-name" required pattern="[A-Za-z\\s]{1,20}"><br><br>
                            
                            <label for="dob">Date of Birth: </label>
                            <input type="date" id="dob" name="dob" required><br><br>
                            
                            <fieldset>
                                <legend>Gender</legend><br>
                                <input type="radio" id="male" name="gender" value="male" required checked>
                                <label for="male">Male</label>
                                <input type="radio" id="female" name="gender" value="female" required>
                                <label for="female">Female</label><br><br>
                            </fieldset><br><br>
                            
                            <fieldset>
                                <legend>Address</legend><br>
                                <label for="street-address">Street Address: </label><br>
                                <input type="text" id="street-address" name="street-address" required maxlength="40"><br><br>

                                <label for="suburb">Suburb/Town: </label><br>
                                <input type="text" id="suburb" name="suburb" required maxlength="40"><br><br>

                                <label for="state">State: </label><br>
                                <select name="state" id="state" required>
                                    <option value="" selected hidden>Select your state</option>
                                    <option value="NSW">NSW</option>
                                    <option value="VIC">VIC</option>
                                    <option value="QLD">QLD</option>
                                    <option value="SA">SA</option>
                                    <option value="WA">WA</option>
                                    <option value="TAS">TAS</option>
                                    <option value="NT">NT</option>
                                    <option value="ACT">ACT</option>
                                </select><br><br>

                                <label for="postcode">Postcode: </label><br>
                                <input type="text" id="postcode" name="postcode" required pattern="[0-9]{4}"><br><br>
                            </fieldset><br><br>

                            <fieldset>
                                <legend>Contact Information</legend><br>
                                <label for="email">Email: </label>
                                <input type="email" id="email" name="email" required ><br><br>
                                
                                <label for="phone">Phone: </label>
                                <input type="tel" id="phone" name="phone" required pattern="[0-9\\s]{8,12}"><br><br>
                            </fieldset><br><br>
                            
                            <fieldset>
                                <legend>Required Technical</legend><br>
                                <p>Skills: </p>
                                <input type="checkbox" id="html" name="skills[]" value="HTML" checked>
                                <label for="html">HTML</label><br>
                                <input type="checkbox" id="css" name="skills[]" value="CSS">
                                <label for="css">CSS</label><br>
                                <input type="checkbox" id="javascript" name="skills[]" value="JavaScript">
                                <label for="javascript">JavaScript</label><br>
                                <input type="checkbox" id="other-skills" name="skills[]" value="Other">
                                <label for="other-skills">Other skills</label><br><br>
                                <label for="other-skills-text">Please specify: </label><br>
                                <textarea name="others" id="other-skills-text"></textarea><br><br>
                            </fieldset><br>
                        </fieldset><br><br>
                        <button type="submit" name="submit">Apply</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <?php
        include "footer.inc"
    ?>
</body>
</html>