
<?php
session_start();
if (!isset($_SESSION["role"]) || ($_SESSION["role"] !== "admin" && $_SESSION["role"] !== "recruiter")) {
    header("Location: index.php");
    exit();
}

// Database connection
$servername = "sql303.infinityfree.com";
$username = "if0_38485688";  // Change this if necessary
$password = "cexWqtvxJ70";      // Change this if necessary
$dbname = "if0_38485688_ngs"; // Change to your actual database name
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// ضبط الترميز لدعم العربية
$conn->set_charset("utf8");

// Add New User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addU'])) {
    if (!empty($_POST['name']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['role'])) {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password']; 
        $role = $_POST['role'];
        $admin= $_SESSION['name'];
        $insertQuery = "INSERT INTO Users (name, username, password, role,added_by) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssss", $name, $username, $password, $role,$admin);

        if ($stmt->execute()) {
        } else {
        }

        $stmt->close();
    } else {
        echo "All fields are required!";
    }
}





// Query to get the latest 5 candidates
$sql = "SELECT * FROM Candidates ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);
// استعلام جلب المستخدمين
$sqluser = "SELECT * FROM Users";
$resultusers = $conn->query($sqluser);
// Query to get total candidates
$candidateCountQuery = "SELECT COUNT(*) AS total FROM Candidates";
$candidateCountResult = $conn->query($candidateCountQuery);
$candidateCount = ($candidateCountResult->num_rows > 0) ? $candidateCountResult->fetch_assoc()['total'] : 0;
// Query to get approved candidates
$approvedCountQuery = "SELECT COUNT(*) AS total FROM Candidates WHERE state = 'Approved'";
$approvedCountResult = $conn->query($approvedCountQuery);
$approvedCount = ($approvedCountResult->num_rows > 0) ? $approvedCountResult->fetch_assoc()['total'] : 0;
// Query to get pending candidates
$pendingCountQuery = "SELECT COUNT(*) AS total FROM Candidates WHERE state = 'pending'";
$pendingCountResult = $conn->query($pendingCountQuery);
$pendingCount = ($pendingCountResult->num_rows > 0) ? $pendingCountResult->fetch_assoc()['total'] : 0;
// Query to get rejected candidates
$rejectedCountQuery = "SELECT COUNT(*) AS total FROM Candidates WHERE state = 'rejected'";
$rejectedCountResult = $conn->query($rejectedCountQuery);
$rejectedCount = ($rejectedCountResult->num_rows > 0) ? $rejectedCountResult->fetch_assoc()['total'] : 0;

// Update question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateQ'])) {
    $qID = $_POST['question_id'];
    $newText = $_POST['question_text'];
    
    $updateQuery = "UPDATE Questions SET question_text = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $newText, $qID);
    $stmt->execute();
    $stmt->close();
}

// Update answer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateA'])) {
    $aID = $_POST['answer_id'];
    $newAnswer = $_POST['answer_text'];
    $newPoints = $_POST['answer_points'];
    
    $updateQuery = "UPDATE Answers SET answer_text = ?, points = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sdi", $newAnswer, $newPoints, $aID);
    $stmt->execute();
    $stmt->close();
}

// Add new question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addQ'])) {
    $newQuestion = $_POST['new_question_text'];
    
    $insertQuery = "INSERT INTO Questions (question_text) VALUES (?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("s", $newQuestion);
    $stmt->execute();
    $stmt->close();
}

// Add new answer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addA'])) {
    $questionID = $_POST['question_id'];
    $newAnswer = 'New Answer Text';
    $newPoints = 'Points';
    
    $insertQuery = "INSERT INTO Answers (question_id, answer_text, points) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sdi", $questionID, $newAnswer, $newPoints);
    $stmt->execute();
    $stmt->close();
}
// Delete question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteQ'])) {
    $aID = $_POST['question_id'];

    $deleteQuery = "DELETE FROM Questions WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $aID);
    $stmt->execute();
    $stmt->close();
}
// Delete answer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteA'])) {
    $aID = $_POST['answer_id'];

    $deleteQuery = "DELETE FROM Answers WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $aID);
    $stmt->execute();
    $stmt->close();
}
// Delete User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteU'])) {
    if (!empty($_POST['user_id'])) {
        $user_id = intval($_POST['user_id']); 
        $deleteQuery = "DELETE FROM Users WHERE id=?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $user_id);
   

if ($stmt->execute()) {
                    echo "<script>alert('✅ User deleted successfully!'); users.href = 'index.php'</script>";
        } else {
            echo "Error deleting user: " . $stmt->error;
        }

        $stmt->close();
   

    }
}




// Fetch Questions and Answers
$questionsQuery = "SELECT * FROM Questions ORDER BY id DESC;";
$questionsResult = $conn->query($questionsQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css">
  <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            height: 100vh;
            background: #f5f5f5;
        }
        .sidebar {
            width: 250px;
            background: #fff;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .sidebar ul {
            list-style: none;
        }
        .sidebar ul li {
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: 0.3s;
        }
        .sidebar ul li:hover {
            background: #ddd;
        }
        .sidebar ul li i {
            margin-right: 10px;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .cards {
            display: flex;
            gap: 20px;
        }
        .card {
            flex: 1;
            padding: 20px;
            border-radius: 10px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card:nth-child(1) { background: #4a90e2; }
        .card:nth-child(2) { background: #7b5cf7; }
        .card:nth-child(3) { background: #f4b400; }
        .table-container {
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background: #eee;
        }
        a {
     text-decoration: none;
    color: inherit; 
}
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li><i class="fas fa-home"></i><a href="Dashboard.php"> Dashboard</a></li>
         <?php   
if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") { 
    echo '<li><i class="fas fa-users"></i><a href="users.php"> Users</a></li>';
}
?>

            
            <li><i class="fas fa-user-tie"></i><a href="candidates.php"> Candidates</a></li>
            <li><i class="fa fa-plus"></i><a href="add.php">New Candidate</a></li>
            <?php   
if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") { 
    echo ' <li><i class="fas fa-question-circle"></i><a href="qa.php"> Q&A</a></li>';
}
?>
           
          <!--  <li><i class="fas fa-bookmark"></i><a href="#"> Saved</a></li> -->
            <li><i class="fas fa-cog"></i><a href="settings.php">Account Settings</a></li>
            <li><i class="fas fa-sign-out-alt"></i><a href="logout.php"> Sign Out</a></li>
        </ul>
    </div>
     <div class="content"> <br> <br>
        <h2>Welcome,  <?php echo $_SESSION['name']; ?>!</h2><br>
