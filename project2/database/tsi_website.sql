-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 02:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tsi_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `EOInumber` int(11) NOT NULL,
  `JobReferenceNumber` varchar(10) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `DOB` date NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `StreetAddress` varchar(40) NOT NULL,
  `Suburb` varchar(40) NOT NULL,
  `State` enum('VIC','NSW','QLD','NT','WA','SA','TAS','ACT') NOT NULL,
  `Postcode` char(4) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `Skill1` varchar(50) DEFAULT NULL,
  `Skill2` varchar(50) DEFAULT NULL,
  `Skill3` varchar(50) DEFAULT NULL,
  `Skill4` varchar(50) DEFAULT NULL,
  `OtherSkills` text DEFAULT NULL,
  `Status` enum('New','Current','Final') DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eoi`
--

INSERT INTO `eoi` (`EOInumber`, `JobReferenceNumber`, `FirstName`, `LastName`, `DOB`, `Gender`, `StreetAddress`, `Suburb`, `State`, `Postcode`, `Email`, `PhoneNumber`, `Skill1`, `Skill2`, `Skill3`, `Skill4`, `OtherSkills`, `Status`) VALUES
(1, 'DEV001', 'Alice', 'Wong', '1998-07-14', 'Female', '123 Main St', 'Hawthorn', 'VIC', '3122', 'alice@example.com', '0412345678', 'HTML', 'CSS', NULL, NULL, 'Knows a bit of Node.js', 'Final'),
(3, 'DEV001', 'Emily', 'Tan', '1999-01-20', 'Female', '22 Innovation St', 'Hawthorn', 'VIC', '3122', 'emily.tan@example.com', '0411123456', 'HTML', 'CSS', NULL, NULL, 'Wants to learn Vue.js', 'New'),
(4, 'DEV001', 'Daniel', 'Lee', '1996-05-12', 'Male', '55 Tech Ave', 'Clayton', 'VIC', '3168', 'dan.lee@example.com', '0403123988', 'JavaScript', 'Git', NULL, NULL, 'Built a React portfolio', 'Current'),
(7, 'ML123', 'Jane', 'Doe', '1997-05-12', 'Female', '123 AI Street', 'Melbourne', 'VIC', '3000', 'jane.doe@example.com', '0411222333', 'Python', 'TensorFlow', NULL, NULL, 'Interest in deep learning and NLP', 'New'),
(8, 'ML123', 'Ahmed', 'Khan', '1990-09-21', 'Male', '42 Neural Rd', 'Brisbane', 'QLD', '4000', 'ahmed.khan@example.com', '0411333444', 'Data Science', 'Machine Learning', NULL, NULL, 'Wrote ML scripts for Kaggle competitions', 'Current'),
(9, 'SD123', 'Emily', 'Wong', '1995-11-30', 'Female', '98 Code Ave', 'Sydney', 'NSW', '2000', 'emily.wong@example.com', '0422555666', 'Java', 'ReactJS', NULL, NULL, 'Interned at Atlassian', 'New'),
(10, 'SD123', 'Liam', 'Nguyen', '1993-03-18', 'Male', '76 Developer Blvd', 'Perth', 'WA', '6000', 'liam.nguyen@example.com', '0422777888', 'C#', 'SQL', NULL, NULL, 'Built fullstack apps using .NET Core', 'Final'),
(11, 'ML123', 'a', 'b', '2025-05-05', 'male', '1', 'a', 'VIC', '3000', '1@g.com', '0410000000', 'HTML', 'CSS', 'JavaScript', 'Other', 'abc', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `hr_users`
--

CREATE TABLE `hr_users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hr_users`
--

INSERT INTO `hr_users` (`username`, `password`) VALUES
('admin', '$2y$10$H9DgfYmIkn91eEv/fhj3..yW/kC7c3Xp5O0i9v3P1hrM2eSkvC8sm'),
('Maggie', '$2y$10$1Tbx6AqYgMhl/2Q/4dYH4ueTAq7zJI6zH3w4BhdzZrzvokUt/QGGS');

-- --------------------------------------------------------

--
-- Table structure for table `job_listing_info`
--

CREATE TABLE `job_listing_info` (
  `Reference Number` varchar(10) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Location` varchar(50) DEFAULT NULL,
  `Salary Lower` int(11) DEFAULT NULL,
  `Salary Upper` int(11) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Reports To` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_listing_info`
--

INSERT INTO `job_listing_info` (`Reference Number`, `Title`, `Location`, `Salary Lower`, `Salary Upper`, `Description`, `Reports To`) VALUES
('DEV001', 'Junior Developer', 'Melbourne', 55000, 70000, 'Develop and maintain web applications.', 'Tech Lead'),
('MGR002', 'Project Manager', 'Sydney', 80000, 95000, 'Manage IT projects and cross-functional teams.', 'CTO'),
('ML123', 'Machine Learning (AI) Engineer', 'Melbourne', 85000, 110000, 'Develop and deploy AI solutions using state-of-the-art machine learning algorithms.', 'Head of AI'),
('SD123', 'Software Developer', 'Sydney', 70000, 95000, 'Design, code, and maintain scalable software systems across multiple platforms.', 'Engineering Manager');

-- --------------------------------------------------------

--
-- Table structure for table `job_listing_info_points`
--

CREATE TABLE `job_listing_info_points` (
  `Point_ID` int(11) NOT NULL,
  `Reference Number` varchar(10) DEFAULT NULL,
  `Point_Type` enum('Key Responsibilities','Essential QSKA','Preferred QSKA') DEFAULT NULL,
  `Point_Text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_listing_info_points`
--

INSERT INTO `job_listing_info_points` (`Point_ID`, `Reference Number`, `Point_Type`, `Point_Text`) VALUES
(1, 'DEV001', 'Key Responsibilities', 'Write clean and maintainable code.'),
(2, 'DEV001', 'Essential QSKA', 'Knowledge of HTML, CSS, and JavaScript.'),
(3, 'DEV001', 'Preferred QSKA', 'Experience with React or Vue.'),
(4, 'MGR002', 'Key Responsibilities', 'Lead project meetings and documentation.'),
(5, 'MGR002', 'Essential QSKA', 'Strong communication and leadership skills.'),
(6, 'MGR002', 'Preferred QSKA', 'PMP Certification.'),
(7, 'ML123', 'Key Responsibilities', 'Develop and fine-tune machine learning models'),
(8, 'ML123', 'Key Responsibilities', 'Collaborate with cross-functional teams on AI product integration'),
(9, 'ML123', 'Essential QSKA', 'Strong knowledge of Python and ML libraries like TensorFlow or PyTorch'),
(10, 'ML123', 'Essential QSKA', 'Experience in data preprocessing and feature engineering'),
(11, 'ML123', 'Preferred QSKA', 'Master’s degree in AI/ML or related field'),
(12, 'ML123', 'Preferred QSKA', 'Publications in ML conferences or Kaggle achievements'),
(13, 'SD123', 'Key Responsibilities', 'Write clean, efficient, and maintainable code'),
(14, 'SD123', 'Key Responsibilities', 'Participate in design and code reviews'),
(15, 'SD123', 'Essential QSKA', 'Proficiency in Java, C#, or a similar language'),
(16, 'SD123', 'Essential QSKA', 'Familiarity with REST APIs and SQL databases'),
(17, 'SD123', 'Preferred QSKA', 'Experience with Agile development'),
(18, 'SD123', 'Preferred QSKA', 'Knowledge of frontend frameworks like React or Angular');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `EOInumber` int(11) NOT NULL,
  `JobReferenceNumber` varchar(50) DEFAULT NULL,
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Gender` varchar(20) DEFAULT NULL,
  `StreetAddress` varchar(255) DEFAULT NULL,
  `Suburb` varchar(100) DEFAULT NULL,
  `State` varchar(50) DEFAULT NULL,
  `Postcode` varchar(10) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `Skill1` varchar(100) DEFAULT NULL,
  `Skill2` varchar(100) DEFAULT NULL,
  `Skill3` varchar(100) DEFAULT NULL,
  `Skill4` varchar(100) DEFAULT NULL,
  `OtherSkills` text DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`EOInumber`, `JobReferenceNumber`, `FirstName`, `LastName`, `DOB`, `Gender`, `StreetAddress`, `Suburb`, `State`, `Postcode`, `Email`, `PhoneNumber`, `Skill1`, `Skill2`, `Skill3`, `Skill4`, `OtherSkills`, `Status`, `username`, `password`) VALUES
(1, NULL, 'Jay', 'Jay', '2025-04-29', 'Female', '10 Downing Street', 'Melbourne', 'Victoria', '3030', 'a@gmail.com', '0411111111', 'HTML', '', '', '', '', 'Pending', 'jaNE', '$2y$10$xofpl4kU1UE.xOTVr.dQGe0hYkEYncXoOIBxrG9UMIj96Z1xZVhHe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- Indexes for table `hr_users`
--
ALTER TABLE `hr_users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `job_listing_info`
--
ALTER TABLE `job_listing_info`
  ADD PRIMARY KEY (`Reference Number`);

--
-- Indexes for table `job_listing_info_points`
--
ALTER TABLE `job_listing_info_points`
  ADD PRIMARY KEY (`Point_ID`),
  ADD KEY `Reference Number` (`Reference Number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`EOInumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `job_listing_info_points`
--
ALTER TABLE `job_listing_info_points`
  MODIFY `Point_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `job_listing_info_points`
--
ALTER TABLE `job_listing_info_points`
  ADD CONSTRAINT `job_listing_info_points_ibfk_1` FOREIGN KEY (`Reference Number`) REFERENCES `job_listing_info` (`Reference Number`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
