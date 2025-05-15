<!--LUCAS SUPERINA 105914669-->
<?php

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

    function job_listing() {
        $TEST_DATA_JOB_BASE_INFO = ["Title"=>"Machine Learning(AI) Engineer", "Location" => "Remote", "Salary" => "$80,000 - $100,000",
        "Description" => "We are seeking a highly skilled Machine Learning Engineer to join our team. You will be responsible for designing, building, and deploying scalable machine learning models and pipelines to support key business initiatives.", 
        "Reports_To" => "Head Machine Learning(AI) Engineer", "Reference_Number" => "ML123",
    ];

        $_Title = $TEST_DATA_JOB_BASE_INFO["Title"];
        $_Location = $TEST_DATA_JOB_BASE_INFO["Location"];
        $_Salary = $TEST_DATA_JOB_BASE_INFO["Salary"];
        $_Description = $TEST_DATA_JOB_BASE_INFO["Description"];
        $_Reports_To = $TEST_DATA_JOB_BASE_INFO["Reports_To"];
        $_Reference_Number = $TEST_DATA_JOB_BASE_INFO["Reference_Number"];

        //these will be passed in as query results that are then looped over using mysqli_fetch_assoc
        //however, so i dont get a desire to wander into the woods and live the rest of my life as a hermit,
        //the test data will just be an array.
        $Key_Responsibilities = [
            "Design and develop machine learning models for classification, regression, clustering, and recommendation tasks.",
            "Implement and maintain ML pipelines for model training, validation, and deployment.",
            "Collaborate with data scientists, software engineers, and product teams to integrate ML solutions into production systems.",
            "Conduct model performance evaluation and hyperparameter tuning.</li>",
            "Stay updated with the latest research and trends in machine learning and AI.",
            "Document processes and contribute to best practices for ML development."
        ];

        $_Required_QSKA = [
            "Bachelor’s degree in Computer Science, Engineering, Mathematics, or related field.",
            "Minimum of 3 years of experience in developing machine learning models.",
            "Strong proficiency in Python and ML libraries such as TensorFlow, PyTorch, Scikit-learn, and Pandas.",
            "Experience with cloud platforms (e.g., AWS, GCP, or Azure) and ML services.",
            "Solid understanding of data preprocessing, feature engineering, and model evaluation techniques.",
           " Experience deploying ML models into production environments using Docker, Kubernetes, or similar tools.",
        ];

        $_Prefered_QSKA = [
            "Master’s degree or Ph.D. in a related field.",
            "Experience with MLOps tools such as MLflow, Kubeflow, or SageMaker.",
            "Knowledge of NLP, deep learning, or reinforcement learning.",
            "Familiarity with version control (Git) and CI/CD pipelines.",
            "Strong communication and collaboration skills in cross-functional teams."
        ];
        
        echo '<aside class="job-item">';
            echo "<h2>$_Title</h2>";
            echo "<p>Location: $_Location</p>";
            echo "<p>Salary: $_Salary</p>";
            echo "<p>Description $_Description</p>";
            echo "<p>Reports to: $_Reports_To</p>";
            echo "<p>Reference Number: $_Reference_Number</p>";
            echo "<h2>Key Responsibilities</h2>";
            create_responsibilities_QSKA_list($Key_Responsibilities, TRUE);
            echo "<h2>Required Qualifications, Skills, Knowledge and Attributes</h2>";
            echo "<h3>Essential</h3>";
            create_responsibilities_QSKA_list($_Required_QSKA, FALSE);
            echo "<h3>Preferable</h3>";
            create_responsibilities_QSKA_list($_Prefered_QSKA, FALSE);
        echo "<a class='button' href='apply.html'>Apply Now</a>";
        echo "</aside>";
        echo "<br><br>";

        }
    



?>