<!--LUCAS SUPERINA 105914669-->
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

        echo '<aside class="job-item">';
            echo "<h2>$_Title</h2>";
            echo "<p>Location: $_Location</p>";
            echo "<p>Salary: $_Salary_Formatted</p>";
            echo "<p>Description $_Description</p>";
            echo "<p>Reports to: $_Reports_To</p>";
            echo "<p>Reference Number: $_Reference_Number</p>";
            echo "<h2>Key Responsibilities</h2>";
            create_responsibilities_QSKA_list($Key_Responsibilities, TRUE);
            echo "<h2>Required Qualifications, Skills, Knowledge and Attributes</h2>";
            echo "<h3>Essential</h3>";
            create_responsibilities_QSKA_list($_Essential_QSKA, FALSE);
            echo "<h3>Preferable</h3>";
            create_responsibilities_QSKA_list($_Prefered_QSKA, FALSE);
        echo "<a class='button' href='apply.php'>Apply Now</a>";
        echo "</aside>";
        echo "<br><br>";

    }

    function get_point_list_from_type($reference_number, $_point_type, $_conn) {
        $sql = "SELECT * FROM job_listing_info_points WHERE `Reference Number`LIKE '$reference_number' AND `Point_Type` LIKE '$_point_type'";
        $result = mysqli_query($_conn, $sql);

        $return_array = [];
        while ($point = mysqli_fetch_assoc($result)) {
            $return_array[ $point["Point_ID"] ] = $point["Point_Text"];
        } 

        return $return_array;

        
    }

    function create_responsibilities_QSKA_list($_points, $_is_ul) {
        $list_tag;
        if ($_is_ul == TRUE) {
            $list_tag = "ul";
        } else {
            $list_tag = "ol";
        };

        echo "<$list_tag>";
        for ($i = 0; $i < sizeof($_points); $i++) {
            $Current_Point = $_points[$i];
            echo "<li>$Current_Point</li>";
        }  
        echo "</$list_tag>";
    }
?>