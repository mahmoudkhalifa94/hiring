-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql303.infinityfree.com
-- Generation Time: Apr 09, 2025 at 10:48 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_38485688_ngs`
--

-- --------------------------------------------------------

--
-- Table structure for table `Answers`
--

CREATE TABLE `Answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_text` text NOT NULL,
  `points` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Answers`
--

INSERT INTO `Answers` (`id`, `question_id`, `answer_text`, `points`) VALUES
(1, 1, 'I became a teacher to inspire and empower students. A teacher in my life made a huge impact, and I strive to do the same.', '5'),
(2, 1, 'I enjoy working with children and helping them grow academically and personally. ', '4.5'),
(3, 1, 'I like teaching and working in schools. ', '4'),
(4, 1, 'I became a teacher because it is a stable job. ', '3.5'),
(5, 1, 'I just needed a job, so I chose teaching. ', '2.5'),
(6, 2, 'I have experience leading PD workshops, mentoring teachers, and organizing initiatives.', '5'),
(7, 2, 'I am open to leadership roles and willing to take on extra responsibilities when needed. ', '4.5'),
(8, 2, 'I am willing to take on some responsibilities when necessary. ', '4'),
(9, 2, 'I prefer to focus mainly on teaching. ', '3.5'),
(10, 2, 'I don\'t like extra responsibilities. ', '3'),
(11, 3, 'I work on classroom management, attend training, seek feedback, and apply strategies for engagement. ', '4'),
(12, 3, 'I try to improve my teaching methods and learn from colleagues. ', '3.5'),
(13, 3, 'I make an effort to improve based on experience. ', '3'),
(14, 3, 'I sometimes reflect on my teaching to improve. ', '2.5'),
(15, 3, 'I don\'t think I need much improvement. ', '2'),
(16, 4, 'I prioritize tasks, use time management strategies, and practice mindfulness. ', '4'),
(17, 4, 'I stay organized and take breaks when needed. ', '3.5'),
(18, 4, 'I try to complete tasks on time and stay calm. ', '3'),
(19, 4, 'I handle stress by keeping a positive mindset. ', '2.5'),
(20, 4, 'I just do my best and hope for the best. ', '2'),
(21, 5, 'Managing large class sizes and ensuring every student gets attention. ', '3'),
(22, 5, 'Sometimes, workload can be overwhelming. ', '2.5'),
(23, 5, 'Balancing different student needs is a challenge. ', '2'),
(24, 5, 'Meeting deadlines can be stressful. ', '2'),
(25, 5, 'I don\'t really have any stress. ', '1.5'),
(26, 6, 'I maintain a balance between work and personal life by exercising and engaging in hobbies. ', '6'),
(27, 6, 'I talk to colleagues and share my concerns.', '5.5'),
(28, 6, 'I try to take care of my mental and physical health. ', '4.5'),
(29, 6, 'I occasionally take time to relax. ', '3.5'),
(30, 6, 'I don\'t do much to focus on well-being. ', '2.5'),
(31, 7, 'I bring innovative teaching methods, commitment to student success, and teamwork skills. ', '7'),
(32, 7, 'I am a hardworking and passionate educator. ', '6.5'),
(33, 7, 'I have the required qualifications and experience. ', '6'),
(34, 7, 'I believe I am capable of doing the job well. ', '5'),
(35, 7, 'I am looking for a job and believe I am a good fit. ', '3.5'),
(36, 8, 'I bring experience, innovation, collaboration, and a student-centered approach. ', '5'),
(37, 8, 'I am passionate and eager to contribute. ', '4.5'),
(38, 8, 'I will work hard to help students succeed. ', '4'),
(39, 8, 'I will follow the school\'s policies and do my best. ', '3.5'),
(40, 8, 'I will do my best in teaching. ', '2.5'),
(41, 9, 'A research-backed educational book/workshop that transformed my teaching.', '3'),
(42, 9, 'I attended a workshop on classroom management. ', '2.5'),
(43, 9, 'I read educational articles to stay updated. ', '2'),
(44, 9, 'I haven\'t attended any recent workshops, but I plan to. ', '2'),
(45, 9, 'I haven\'t attended any recently. ', '1.5'),
(46, 10, 'I had a disagreement over curriculum decisions. We resolved it through open dialogue and mutual understanding. ', '5'),
(47, 10, 'I had a minor conflict but resolved it with the help of senior staff.', '4.5'),
(48, 10, 'I try to maintain good relationships to avoid conflicts. ', '4'),
(49, 10, 'I rarely face conflicts at work. ', '3.5'),
(50, 10, 'I usually avoid conflicts. ', '2.5'),
(51, 11, 'A student struggled with behavior issues. I used positive reinforcement, built rapport, and engaged parents.', '6'),
(52, 11, 'I had a student who was struggling academically, so I provided extra help after class. ', '5.5'),
(53, 11, 'I try to support struggling students during class. ', '5'),
(54, 11, 'I refer struggling students to the counselor or senior staff. ', '4.5'),
(55, 11, 'I usually refer difficult students to the school counselor. ', '3'),
(56, 12, 'I focus on social-emotional learning, mental health check-ins, and fostering a supportive classroom culture. ', '4'),
(57, 12, 'I try to create a friendly environment and be approachable. ', '3.5'),
(58, 12, 'I encourage students to talk about their concerns. ', '3'),
(59, 12, 'I listen to students when they come to me with problems. ', '2.5'),
(60, 12, 'I am always available if students need me. ', '2'),
(61, 13, 'I follow structured frameworks (e.g., Writing Process, Singapore Math, Inquiry-Based Science) and integrate real-world applications. ', '5'),
(62, 13, 'I focus on practice and reinforcement through class activities. ', '4.5'),
(63, 13, 'I use interactive teaching methods to keep students engaged. ', '4'),
(64, 13, 'I follow the curriculum closely. ', '3.5'),
(65, 13, 'I teach from the curriculum and give exercises. ', '2.5'),
(66, 14, 'Inquiry-based learning is student-centered,involving exploration, questioning, and discovery<br> 5E\'s: Engage, Explore, Explain, Elaborate, Evaluate.', '6'),
(67, 14, 'I use guided inquiry, where students explore concepts under my direction.', '5.5'),
(68, 14, 'I encourage students to ask questions and explore ideas.', '5'),
(69, 14, 'I try to make lessons engaging with questions and discussions.', '4.5'),
(70, 14, 'I encourage students to ask questions.', '3'),
(71, 15, 'I effectively integrate technology using Google Classroom, Nearpod, and AI tools.<br> I analyze student data with LMS platforms and help colleagues and students develop digital skills.', '5'),
(72, 15, 'I use Microsoft Teams and Google Drive to organize lessons, employ interactive quizzes and simulations,<br> and have solid knowledge of student data analysis. ', '4.5'),
(73, 15, 'I use PowerPoint, YouTube, and online quizzes, with basic skills in Google Docs and Excel.<br> I\'m working on expanding my knowledge of interactive platforms. ', '4'),
(74, 15, 'I use technology mainly for presentations and assessments. I am proficient in basic tools like Word and Excel but still learning deeper integration in teaching.', '3.5'),
(75, 15, 'I only use PowerPoint and email, with little experience in educational platforms, but I am open to learning.', '2.5'),
(76, 16, 'I design lessons that integrate subjects like science & math or literature & history with real-world applications. ', '5'),
(77, 16, 'I often try to connect subjects and make learning interdisciplinary. ', '4.5'),
(78, 16, 'I sometimes integrate subjects when teaching. ', '4'),
(79, 16, 'I occasionally make subject connections. ', '3.5'),
(80, 16, 'I follow the curriculum strictly. ', '2.5'),
(81, 17, 'I modify lessons using differentiation strategies like tiered assignments, flexible grouping, and scaffolding.', '6'),
(82, 17, 'adapt my lessons to meet different student needs. ', '5.5'),
(83, 17, 'I try to adjust my teaching based on student abilities. ', '5'),
(84, 17, 'I provide extra help to struggling students when I can. ', '4.5'),
(85, 17, 'I teach at the class level and provide extra work if needed. ', '3'),
(86, 18, 'I use formative assessments (exit tickets, KWL charts) and summative assessments to track progress. ', '6'),
(87, 18, 'I analyze student progress using regular assessments and feedback. ', '5.5'),
(88, 18, 'I observe student work and provide feedback. ', '4.5'),
(89, 18, 'I rely on test scores to measure progress. ', '3.5'),
(90, 18, 'I give tests and quizzes but don\'t analyze trends.', '3'),
(91, 19, 'I analyze MAP and CAT4 data to inform instruction and address student needs. ', '4'),
(92, 19, 'I use benchmark test results for student assessment and improvement. ', '3.5'),
(93, 19, 'I review test scores to guide instruction. ', '3'),
(94, 19, 'I check benchmark test results occasionally. ', '2.5'),
(95, 19, 'I rely on classroom tests. ', '2'),
(96, 20, 'I analyze student performance data across different demographics and adapt my instruction accordingly. ', '6'),
(97, 20, 'I review test results and adjust my lessons accordingly. ', '5.5'),
(98, 20, 'I consider student performance data when planning lessons. ', '5'),
(99, 20, 'I sometimes review test scores for patterns . ', '4.5'),
(100, 20, 'I check scores but do not analyze trends. ', '3');

-- --------------------------------------------------------

--
-- Table structure for table `Candidates`
--

CREATE TABLE `Candidates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `speciality` text NOT NULL,
  `interviewer` text NOT NULL,
  `interview_date` text NOT NULL,
  `current_location` text NOT NULL,
  `cv_path` text NOT NULL,
  `rate` text NOT NULL,
  `state` text NOT NULL,
  `way` text NOT NULL,
  `total_points` varchar(255) NOT NULL,
  `quest` text NOT NULL,
  `overall_feedback` text DEFAULT NULL,
  `final_decision` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Candidates`
--

INSERT INTO `Candidates` (`id`, `name`, `speciality`, `interviewer`, `interview_date`, `current_location`, `cv_path`, `rate`, `state`, `way`, `total_points`, `quest`, `overall_feedback`, `final_decision`) VALUES
(6, ' AbiAbdulahad-Resume 2024 newest', 'English MS/HS', 'Sahar', '', 'USA', 'uploads/AbiAbdulahad-Resume 2024 newest.pdf', '', 'Pending', 'online', '', '', '', ''),
(10, 'Dania Dania Zein Resume', '', 'Ahmed Ansary', '2025-04-11', '', 'uploads/Dania Zein Resume.pdf', '', 'Pending', 'offline', '', '', '', ''),
(8, 'Sharmina Haja Shamrin Haja (1)', 'Islamic B', 'Ahmed Ansary', '2025-04-09', 'NGS', 'uploads/Shamrin Haja (1).pdf', 'Excellent', 'Approved', 'offline', '90', '', '', ''),
(9, 'Omar Mohamed CV.Omar 2025 Ø³ÙŠØ±Ø© Ø°Ø§ØªÙŠØ© Ø¹Ù…Ø±-1', 'Arabic B', 'Ahmed Ansary', '2025-04-10', '', 'uploads/CV.Omar 2025 Ø³ÙŠØ±Ø© Ø°Ø§ØªÙŠØ© Ø¹Ù…Ø±-1.pdf', '', 'Pending', 'offline', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `Candidate_Answers`
--

CREATE TABLE `Candidate_Answers` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `question_id` text NOT NULL,
  `answer_id` text NOT NULL,
  `question_text` text NOT NULL,
  `answer_text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Candidate_Answers`
--

INSERT INTO `Candidate_Answers` (`id`, `candidate_id`, `question_id`, `answer_id`, `question_text`, `answer_text`) VALUES
(1, 1, '1', '5', '', ''),
(2, 1, '2', '5', '', ''),
(3, 1, '3', '4', '', ''),
(4, 1, '4', '4', '', ''),
(5, 1, '5', '3', '', ''),
(6, 1, '6', '6', '', ''),
(7, 1, '7', '7', '', ''),
(8, 1, '8', '4', '', ''),
(9, 1, '9', '3', '', ''),
(10, 1, '10', '5', '', ''),
(11, 1, '11', '5', '', ''),
(12, 1, '12', '3', '', ''),
(13, 1, '13', '4', '', ''),
(14, 1, '14', '5', '', ''),
(15, 1, '15', '5', '', ''),
(16, 1, '16', '5', '', ''),
(17, 1, '17', '6', '', ''),
(18, 1, '18', '6', '', ''),
(19, 1, '19', '3', '', ''),
(20, 1, '20', '5', '', ''),
(21, 2, '1', '5', '', ''),
(22, 2, '2', '5', '', ''),
(23, 2, '3', '4', '', ''),
(24, 2, '4', '4', '', ''),
(25, 2, '5', '3', '', ''),
(26, 2, '6', '6', '', ''),
(27, 2, '7', '7', '', ''),
(28, 2, '8', '5', '', ''),
(29, 2, '9', '3', '', ''),
(30, 2, '10', '5', '', ''),
(31, 2, '11', '6', '', ''),
(32, 2, '12', '4', '', ''),
(33, 2, '13', '5', '', ''),
(34, 2, '14', '6', '', ''),
(35, 2, '15', '5', '', ''),
(36, 2, '16', '5', '', ''),
(37, 2, '17', '6', '', ''),
(38, 2, '18', '6', '', ''),
(39, 2, '19', '4', '', ''),
(40, 2, '20', '6', '', ''),
(41, 4, '1', '2', '', ''),
(42, 4, '2', '3', '', ''),
(43, 5, '1', '5', '', ''),
(44, 5, '2', '4', '', ''),
(45, 5, '3', '3', '', ''),
(46, 5, '4', '4', '', ''),
(47, 5, '5', '3', '', ''),
(48, 5, '6', '5', '', ''),
(49, 5, '7', '3', '', ''),
(50, 5, '8', '4', '', ''),
(51, 5, '9', '2', '', ''),
(52, 5, '10', '2', '', ''),
(53, 5, '12', '2', '', ''),
(54, 5, '13', '2', '', ''),
(55, 5, '15', '4', '', ''),
(56, 5, '16', '3', '', ''),
(57, 5, '17', '5', '', ''),
(58, 5, '18', '3', '', ''),
(59, 5, '19', '2', '', ''),
(60, 5, '20', '3', '', ''),
(61, 6, '1', '3', '', ''),
(62, 6, '2', '5', '', ''),
(63, 6, '3', '4', '', ''),
(64, 6, '4', '4', '', ''),
(65, 6, '5', '2', '', ''),
(66, 6, '6', '3', '', ''),
(67, 6, '7', '6', '', ''),
(68, 6, '8', '4', '', ''),
(69, 6, '9', '2', '', ''),
(70, 6, '10', '2', '', ''),
(71, 6, '11', '6', '', ''),
(72, 6, '12', '4', '', ''),
(73, 6, '13', '2', '', ''),
(74, 6, '14', '6', '', ''),
(75, 6, '15', '5', '', ''),
(76, 6, '16', '4', '', ''),
(77, 6, '17', '4', '', ''),
(78, 6, '18', '3', '', ''),
(79, 6, '19', '2', '', ''),
(80, 6, '20', '6', '', ''),
(81, 7, '1', '5', '', ''),
(82, 7, '3', '3', '', ''),
(83, 7, '4', '2', '', ''),
(84, 7, '5', '2', '', ''),
(85, 7, '6', '2', '', ''),
(86, 7, '7', '3', '', ''),
(87, 7, '8', '4', '', ''),
(88, 7, '9', '3', '', ''),
(89, 7, '10', '4', '', ''),
(90, 7, '11', '5', '', ''),
(91, 7, '12', '3', '', ''),
(92, 7, '13', '5', '', ''),
(93, 7, '14', '4', '', ''),
(94, 7, '15', '3', '', ''),
(95, 7, '16', '4', '', ''),
(96, 7, '17', '6', '', ''),
(97, 7, '18', '6', '', ''),
(98, 7, '19', '3', '', ''),
(99, 7, '20', '6', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `Questions`
--

CREATE TABLE `Questions` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question_text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Questions`
--

INSERT INTO `Questions` (`id`, `question_id`, `question_text`) VALUES
(1, 1, 'What inspired you to become a teacher?'),
(2, 2, 'Potential for leadership/extra responsibilities?'),
(3, 3, 'Areas for improvement & what have you done?'),
(4, 4, 'Strategies to handle stress & deadlines?'),
(5, 5, 'First source of work-related stress?'),
(6, 6, 'How do you maintain well-being?'),
(7, 7, 'Why should we hire you?'),
(8, 8, 'What will you bring to the school?'),
(9, 9, 'Most influential book/workshop recently?'),
(10, 10, 'Recall a conflict with a colleague/HoD/Admin?'),
(11, 11, 'Challenging student situation & how you managed it?'),
(12, 12, 'Strategies to ensure student well-being?'),
(13, 13, 'How do you teach writing/math/science?'),
(14, 14, 'Inquiry-based education?'),
(15, 15, 'Technology and Computer Usage?'),
(16, 16, 'Cross-curricular integration?'),
(17, 17, 'Experience with differentiation?'),
(18, 18, 'How do you measure impact/progress?'),
(19, 19, 'Experience with Diagnostic/Benchmark Tests?'),
(20, 20, 'Ability to analyze data?');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','recruiter','candidate') NOT NULL,
  `added_by` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `name`, `username`, `password`, `role`, `added_by`) VALUES
(1, 'Admin', 'abosaed2015', '201520', 'admin', ''),
(2, 'Ahmed Ansary', 'ahmed', '123', 'admin', 'Admin'),
(8, 'Sahar', 'sahar', '123', 'admin', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Answers`
--
ALTER TABLE `Answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `Candidates`
--
ALTER TABLE `Candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Candidate_Answers`
--
ALTER TABLE `Candidate_Answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_id` (`candidate_id`),
  ADD KEY `question_id` (`question_id`(1000)),
  ADD KEY `answer_id` (`answer_id`(1000));

--
-- Indexes for table `Questions`
--
ALTER TABLE `Questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `unique_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Answers`
--
ALTER TABLE `Answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `Candidates`
--
ALTER TABLE `Candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Candidate_Answers`
--
ALTER TABLE `Candidate_Answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `Questions`
--
ALTER TABLE `Questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
