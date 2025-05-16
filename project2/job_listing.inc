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
        //these will be passed in as query results that are then looped over using mysqli_fetch_assoc
        //however, so i dont get a desire to wander into the woods and live the rest of my life as a hermit,
        //the test data will just be an array.

        $sql = "SELECT * FROM job_listing_info_points WHERE `Reference Number`LIKE '$reference_number' AND `Point_Type` LIKE '$_point_type'";
        $result = mysqli_query($_conn, $sql);

        $return_array = [];
        while ($point = mysqli_fetch_assoc($result)) {
            $return_array[ $point["Point_ID"] ] = $point["Point_Text"];
        } 

        return $return_array;

        if ($_point_type == "Key Responsibilities") {
            return [
                "Design and develop machine learning models for classification, regression, clustering, and recommendation tasks.",
                "Implement and maintain ML pipelines for model training, validation, and deployment.",
                "Collaborate with data scientists, software engineers, and product teams to integrate ML solutions into production systems.",
                "Conduct model performance evaluation and hyperparameter tuning.</li>",
                "Stay updated with the latest research and trends in machine learning and AI.",
                "Document processes and contribute to best practices for ML development."
            ];
        } elseif ($_point_type == "Essential QSKA") {
            return [
                "Bachelor’s degree in Computer Science, Engineering, Mathematics, or related field.",
                "Minimum of 3 years of experience in developing machine learning models.",
                "Strong proficiency in Python and ML libraries such as TensorFlow, PyTorch, Scikit-learn, and Pandas.",
                "Experience with cloud platforms (e.g., AWS, GCP, or Azure) and ML services.",
                "Solid understanding of data preprocessing, feature engineering, and model evaluation techniques.",
            " Experience deploying ML models into production environments using Docker, Kubernetes, or similar tools.",
            ];
        } elseif ($_point_type == "Preferred QSKA") {
            return [
                "Master’s degree or Ph.D. in a related field.",
                "Experience with MLOps tools such as MLflow, Kubeflow, or SageMaker.",
                "Knowledge of NLP, deep learning, or reinforcement learning.",
                "Familiarity with version control (Git) and CI/CD pipelines.",
                "Strong communication and collaboration skills in cross-functional teams."
            ];
        }
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