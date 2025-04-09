<?php
require 'header.php'; // تضمين ملف الهيدر

if (isset($_GET['id'])) {
    $candidate_id = intval($_GET['id']); // تأمين الـ ID ضد الهجمات
// استعلام جلب الإجابات
    $answersQuery = "SELECT ca.id AS candidate_answer_id, q.question_text, a.answer_text, a.points 
                     FROM Candidate_Answers ca
                     JOIN Questions q ON ca.question_id = q.id
                     JOIN Answers a ON ca.answer_id = a.id
                     WHERE ca.candidate_id = ?";

    $stmt = $conn->prepare($answersQuery);
    $stmt->bind_param("i", $candidate_id);
    $stmt->execute();
    $answersResult = $stmt->get_result();
    $stmt->close();

    // استعلام لجلب بيانات المرشح
    $query = "SELECT * FROM Candidates WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $candidate_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p style='color: red; text-align: center;'>No candidate found.</p>";
        exit();
    }
    $stmt->close();
}

// تحديث بيانات المرشح عند إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_candidate'])) {
    // استلام البيانات الجديدة
    $name = htmlspecialchars($_POST['name']);
    $speciality = htmlspecialchars($_POST['speciality']);
    $interviewer = htmlspecialchars($_POST['interviewer']);
    $rate = htmlspecialchars($_POST['rate']);
    $state = htmlspecialchars($_POST['state']);
    $interview_date = htmlspecialchars($_POST['interview_date']);
    $current_location = htmlspecialchars($_POST['current_location']);
    $total_points = intval($_POST['total_points']);
    $quest = htmlspecialchars($_POST['quest']);
    $overall_feedback = htmlspecialchars($_POST['overall_feedback']);
    $final_decision = htmlspecialchars($_POST['final_decision']);

    // تحديث البيانات في قاعدة البيانات
    $updateQuery = "UPDATE Candidates SET 
                    name=?, speciality=?, interviewer=?, rate=?, state=?, 
                    interview_date=?, current_location=?, total_points=?, quest=?, 
                    overall_feedback=?, final_decision=? WHERE id=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssssssssssi", 
                      $name, $speciality, $interviewer, $rate, $state, 
                      $interview_date, $current_location, $total_points, $quest, 
                      $overall_feedback, $final_decision, $candidate_id);

    if ($stmt->execute()) {
        echo "<p style='color: green; text-align: center;'>Candidate updated successfully!</p>";
        header("Location: view_candidate.php?id=" . $candidate_id);
        exit();
    } else {
        echo "<p style='color: red; text-align: center;'>Error updating candidate: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_candidate'])) {
    // استعلام الحذف
    $deleteQuery = "DELETE FROM Candidates WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $candidate_id);

    if ($stmt->execute()) {
        echo "<p style='color: green; text-align: center;'>Candidate deleted successfully!</p>";
        header("Location: candidates.php"); // ✅ إعادة التوجيه إلى صفحة القائمة بعد الحذف
        exit();
    } else {
        echo "<p style='color: red; text-align: center;'>Error deleting candidate: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Candidate</title>
    <style>
  body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #f3f4f6, #dfe3ee);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    max-width: 650px;
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    animation: fadeIn 0.5s ease-in-out;
}

h2 {
    text-align: center;
    color: #007bff;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

/* ✅ استخدام Grid لوضع العناصر بجانب بعضها */
form {
    display: grid;
    grid-template-columns: 30% 70%;
    gap: 10px 15px; /* تحديد المسافات بين العناصر */
    align-items: center;
}

label {
    font-weight: bold;
    color: #333;
    text-align: right;
    padding-right: 10px;
}

input, select, textarea {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    width: 100%;
    transition: all 0.3s ease-in-out;
}

input:focus, select:focus, textarea:focus {
    border-color: #007bff;
    box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
}

textarea {
    resize: vertical;
    height: 80px;
}

/* ✅ زر التحديث بمظهر جذاب */
.full-width {
    grid-column: span 2; /* يجعل الزر يمتد على العرض بالكامل */
    display: flex;
    justify-content: center;
}

button {
    background: #007bff;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: all 0.3s ease-in-out;
}

button:hover {
    background: #0056b3;
    transform: scale(1.05);
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

</style>
</head>
<body>

<div class="container">
    <h2>Edit Candidate</h2>

    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>

        <label for="speciality">Speciality:</label>
        <input type="text" id="speciality" name="speciality" value="<?php echo $row['speciality']; ?>" required>

        <label for="interviewer">Interviewer:</label>
        <input type="text" id="interviewer" name="interviewer" value="<?php echo $row['interviewer']; ?>" required>

        <label for="rate">Rate:</label>
<select id="rate" name="rate" required>
            <option value="Excellent" <?php if ($row['rate'] == 'Excellent') echo 'selected'; ?>>Excellent</option>
            <option value="Very Good" <?php if ($row['rate'] == 'Very Good') echo 'selected'; ?>>Very Good</option>
            <option value="Good" <?php if ($row['rate'] == 'Good') echo 'selected'; ?>>Good</option>
            <option value="Acceptable" <?php if ($row['rate'] == 'Acceptable') echo 'selected'; ?>>Acceptable</option>
            <option value="Weak" <?php if ($row['rate'] == 'Weak') echo 'selected'; ?>>Weak</option>

        </select>
        <label for="state">State:</label>
        <select id="state" name="state" required>
            <option value="Pending" <?php if ($row['state'] == 'Pending') echo 'selected'; ?>>Pending</option>
            <option value="Approved" <?php if ($row['state'] == 'Approved') echo 'selected'; ?>>Approved</option>
            <option value="Rejected" <?php if ($row['state'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
        </select>

        <label for="interview_date">Interview Date:</label>
        <input type="date" id="interview_date" name="interview_date" value="<?php echo $row['interview_date']; ?>" required>

        <label for="current_location">Current Location:</label>
        <input type="text" id="current_location" name="current_location" value="<?php echo $row['current_location']; ?>" required>

        <label for="total_points">Total Points:</label>
        <input type="number" id="total_points" name="total_points" value="<?php echo $row['total_points']; ?>" required>

        <label for="quest">Candidate Questions:</label>
        <textarea id="quest" name="quest" ><?php echo $row['quest']; ?></textarea>

        <label for="overall_feedback">Overall Feedback:</label>
        <textarea id="overall_feedback" name="overall_feedback" ><?php echo $row['overall_feedback']; ?></textarea>

        <label for="final_decision">Final Decision:</label>
       
 <textarea id="final_decision" name="final_decision" ><?php echo $row['final_decision']; ?></textarea>

        <div class="full-width">
            <button type="submit" name="update_candidate">Update Candidate</button>&nbsp; &nbsp; 
    <button type="submit" name="delete_candidate" onclick="return confirm('Are you sure you want to delete this candidate?');" style="background: red;">Delete Candidate</button>
        </div>
    </form>
</div>

</body>
</html>


<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Answers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>
<h2>Candidate Answers</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Question</th>
        <th>Answer</th>
        <th>Points</th>
    </tr>
    <?php while ($answer = $answersResult->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $answer['candidate_answer_id']; ?></td>
            <td><?php echo $answer['question_text']; ?></td>
            <td><?php echo $answer['answer_text']; ?></td>
            <td><?php echo $answer['points']; ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
