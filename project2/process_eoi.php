<!--MAGGIE XIN YI LAW 103488683-->

<?php
// Enable error reporting (for development only)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"])) {
    header("Location: apply.php");
    exit();
}

require_once("settings.php");
$conn = @mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

function clean_input($data) {
    return htmlspecialchars(trim($data ?? ""));
}

$reference_number = clean_input($_POST["job-reference-number"]);
$first_name = clean_input($_POST["first-name"]);
$last_name = clean_input($_POST["last-name"]);
$dob = clean_input($_POST["dob"]);
$gender = clean_input($_POST["gender"]);
$street_address = clean_input($_POST["street-address"]);
$suburb = clean_input($_POST["suburb"]);
$state = clean_input($_POST["state"]);
$postcode = clean_input($_POST["postcode"]);
$email = clean_input($_POST["email"]);
$phone = clean_input($_POST["phone"]);
$other_skills = isset($_POST["others"]) ? clean_input($_POST["others"]) : "";

$skills = isset($_POST["skills"]) ? $_POST["skills"] : [];
$skill1 = $skill2 = $skill3 = $skill4 = null;
if (isset($skills[0])) $skill1 = $skills[0];
if (isset($skills[1])) $skill2 = $skills[1];
if (isset($skills[2])) $skill3 = $skills[2];
if (isset($skills[3])) $skill4 = $skills[3];

$errors = [];
if (!preg_match("/^[a-zA-Z]{1,20}$/", $first_name)) {
    $errors[] = "First name must be alphabetic and max 20 characters.";
}
if (!preg_match("/^[a-zA-Z]{1,20}$/", $last_name)) {
    $errors[] = "Last name must be alphabetic and max 20 characters.";
}
if (!in_array($state, ["VIC","NSW","QLD","NT","WA","SA","TAS","ACT"])) {
    $errors[] = "Invalid state selected.";
}
if (!preg_match("/^[0-9]{4}$/", $postcode)) {
    $errors[] = "Postcode must be exactly 4 digits.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email format is invalid.";
}
if (!preg_match("/^[0-9 ]{8,12}$/", $phone)) {
    $errors[] = "Phone number must be 8 to 12 digits or spaces.";
}
if (empty($skills)) {
    $errors[] = "At least one skill must be selected.";
}
if (in_array("Other", $skills) && empty($other_skills)) {
    $errors[] = "Please describe your 'Other' skill.";
}


if (count($errors) > 0) {
    include_once("header.inc");
    createHeader("Form Error");

    echo '<div class="error-box" style="margin: 3em auto; max-width: 600px; padding: 2em; border-radius: 12px; box-shadow: 0 0 15px rgba(255,0,0,0.2); background: #fff5f5; color: #c0392b;">';
    echo "<h2 style='color: #c0392b;'>Submission Error</h2>";
    echo "<p>The following issues were found in your application:</p><ul style='text-align: left;'>";
    foreach ($errors as $err) {
        echo "<li>$err</li>";
    }
    echo "</ul>";
    echo "<a href='apply.php' style='margin-top: 1.5em; display: inline-block; padding: 0.6em 1.5em; background: #c0392b; color: white; border-radius: 6px; text-decoration: none;'>Return to Application Form</a>";
    echo "</div>";

    include_once("footer.inc");
    exit();
}

$create_table = "
CREATE TABLE IF NOT EXISTS eoi (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    JobReferenceNumber VARCHAR(10) NOT NULL,
    FirstName VARCHAR(20) NOT NULL,
    LastName VARCHAR(20) NOT NULL,
    DOB DATE NOT NULL,
    Gender VARCHAR(10) NOT NULL,
    StreetAddress VARCHAR(40) NOT NULL,
    Suburb VARCHAR(40) NOT NULL,
    State ENUM('VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT') NOT NULL,
    Postcode CHAR(4) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    PhoneNumber VARCHAR(15) NOT NULL,
    Skill1 VARCHAR(50),
    Skill2 VARCHAR(50),
    Skill3 VARCHAR(50),
    Skill4 VARCHAR(50),
    OtherSkills TEXT,
    Status ENUM('New', 'Current', 'Final') DEFAULT 'New'
)";
mysqli_query($conn, $create_table);

$query = "INSERT INTO eoi (
    JobReferenceNumber, FirstName, LastName, DOB, Gender, StreetAddress, Suburb, State, Postcode, 
    Email, PhoneNumber, Skill1, Skill2, Skill3, Skill4, OtherSkills
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ssssssssssssssss", 
    $reference_number, $first_name, $last_name, $dob, $gender, $street_address, $suburb, $state, $postcode,
    $email, $phone, $skill1, $skill2, $skill3, $skill4, $other_skills);

if (mysqli_stmt_execute($stmt)) {
    $eoi_number = mysqli_insert_id($conn);
    include_once("header.inc");
    createHeader("Confirmation");

    echo '<div class="confirmation-box" style="margin: 3em auto; max-width: 600px; padding: 2em; border-radius: 12px; box-shadow: 0 0 15px rgba(0,0,0,0.1); background: #f4f9ff; text-align: center;">';
    echo "<h2 style='color: #2a7ae2;'>Application Submitted Successfully!</h2>";
    echo "<p>Thank you, <strong>$first_name $last_name</strong>, for your application.</p>";
    echo "<p>Your EOI Number is: <strong style='color: #e26d2a;'>$eoi_number</strong></p>";
    echo "<p>A confirmation has been sent to <strong>$email</strong>.</p>";
    echo "<a href='index.php' style='margin-top: 1.5em; display: inline-block; padding: 0.6em 1.5em; background: #2a7ae2; color: white; border-radius: 6px; text-decoration: none;'>Return to Home</a>";
    echo "</div>";

    include_once("footer.inc");
} else {
    echo "<p>Something went wrong. Please try again later.</p>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>