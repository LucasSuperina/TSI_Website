<!--LUCAS SUPERINA 105914669-->
<!--PUJAN KUKADIYA 105920242-->
<?php

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

    echo '<article class="job_listing">';
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
    echo "<a class='fake_button' href='apply.php'>Apply Now</a>";
    echo "</article>";
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