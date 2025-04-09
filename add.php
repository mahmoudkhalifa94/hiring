

<?php
session_start();
if (!isset($_SESSION["role"]) || ($_SESSION["role"] !== "admin" && $_SESSION["role"] !== "recruiter")) {
    header("Location: index.php");
    exit();
}

// Database connection
$servername = "sql303.infinityfree.com";
$username = "if0_38485688";
$password = "cexWqtvxJ70";
$dbname = "if0_38485688_ngs";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch questions and answers
$questionsQuery = "SELECT * FROM Questions;";
$questionsResult = $conn->query($questionsQuery);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure DB connection

    // Retrieve candidate details from form
    $name = $_POST['candidate_name'];
    $speciality = $_POST['speciality'];
    $interviewer = $_SESSION["name"];
    $date_interview = $_POST['date_interview'];
    $way = $_POST['way'];
    $current_location = $_POST['current_location'];
    $overall_feedback = $_POST['overall_feedback'];
    $candidate_questions = $_POST['candidate_questions'];
    $final_decision = $_POST['final_decision'];
    $rate = $_POST['rate'];
    $total_points = $_POST['total_points'];
     $state = 'Pending';
    // Handle CV Upload
    $cvName = $_FILES['cv']['name'];
    $cvTmp = $_FILES['cv']['tmp_name'];
    $cvPath = "uploads/" . basename($cvName);

    if (move_uploaded_file($cvTmp, $cvPath)) {
        $totalPoints = 0;

        $insertCandidate = "INSERT INTO Candidates (name, speciality, interviewer, interview_date, way, current_location, cv_path, total_points, rate, state, overall_feedback, quest, final_decision) 
                            VALUES ('$name', '$speciality', '$interviewer', '$date_interview', '$way', '$current_location', '$cvPath', '$total_points', '$rate', '$state', '$overall_feedback', '$candidate_questions', '$final_decision')";

        if ($conn->query($insertCandidate) === TRUE) {
            $candidateID = $conn->insert_id; // Get the last inserted candidate ID

            // Insert Answers into Candidate_Answers Table
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'q') === 0 && !empty($value)) { 
                    $questionID = substr($key, 1); // Extract question ID
                    $answerID = intval($value); // Selected answer ID

                    // Fetch points for the selected answer
                    $answerQuery = "SELECT points FROM Answers WHERE id = '$answerID'";
                    $answerResult = $conn->query($answerQuery);
                    if ($answerResult->num_rows > 0) {
                        $answerRow = $answerResult->fetch_assoc();
                        $answerPoints = floatval($answerRow['points']);
                        $totalPoints += $answerPoints;
                    }

                    // Insert into Candidate_Answers
                    $insertAnswer = "INSERT INTO Candidate_Answers (candidate_id, question_id, answer_id) 
                                     VALUES ('$candidateID', '$questionID', '$answerID')";
                    $conn->query($insertAnswer);
                }
            }


                echo "<script>alert('✅ Candidate saved successfully!'); location.href = 'add.php'</script>";
        } else {
                echo "<script>alert('❌ Error: " . $conn->error . "'); location.href = 'add.php';</script>";
        }
    } else {
                    echo "<script>alert('❌ Error uploading CV.'); location.href = 'add.php'</script>";

    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Notes & Feedback</title>
    <style>


     .checkbox-container {
        display: flex;
        align-items: center;
        font-family: Arial, sans-serif;
        font-size: 16px;
        cursor: pointer;
    }

    .checkbox-container input {
        appearance: none;
        width: 18px;
        height: 18px;
        border: 2px solid #007BFF;
        border-radius: 4px;
        margin-right: 8px;
        position: relative;
        cursor: pointer;
    }

    .checkbox-container input:checked {
        background-color: #007BFF;
        border-color: #007BFF;
    }

    .checkbox-container input:checked::before {
        content: "✔";
        position: absolute;
        left: 2px;
        top: -2px;
        color: white;
        font-size: 14px;
        font-weight: bold;
    }


    .button-container {
    text-align: center;
}

.submit-btn {
    padding: 15px 30px;
    font-size: 18px;
    font-weight: bold;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.submit-btn:hover {
    background-color: #45a049;
    transform: scale(1.05);
}

.submit-btn:active {
    transform: scale(1);
}

br {
    line-height: 20px;
}/* General body styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    background-color: #f4f4f9;
    
    justify-content: center;
    align-items: center;
    height: 100vh;
    flex-direction: column;
}

/* Container to hold the content */
.container {
    width: 90%;
    max-width: 1200px;  /* Max width to prevent stretching on large screens */
    margin: 20px auto;
}

/* Styling for tables */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

/* Table header styling */
th {
    background-color: #e4961f;
    color: white;
    padding: 10px;
}

/* Table cell styling */
th, td {
    border: 1px solid black;
    padding: 10px;
    text-align: left;
}

/* Styling the button */
.submit-btn {
    padding: 15px 30px;
    font-size: 18px;
    font-weight: bold;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    margin-top: 20px;
}

.submit-btn:hover {
    background-color: #45a049;
    transform: scale(1.05);
}

.submit-btn:active {
    transform: scale(1);
}

/* Input and textarea styling */
input, textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Specific styling for textarea */
textarea {
    resize: vertical;
}

/* Section titles styling */
.section-title {
    font-weight: bold;
    background-color: #f0f0f0;
    padding: 10px;
}

/* Title section styling */
.title {
    text-align: center;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Media Queries for responsiveness */
@media (max-width: 768px) {
    /* Make table headers stack vertically */
    th, td {
        display: block;
        width: 100%;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    /* Styling the button for smaller screens */
    .submit-btn {
        width: 100%;
        padding: 12px;
    }

    /* Adjust the title to be smaller */
    .title {
        font-size: 20px;
    }

    /* Adjust input sizes and textareas for smaller screens */
    input, textarea {
        font-size: 14px;
    }

    /* Stack the input fields and adjust label widths */
    table {
        width: 100%;
    }
}

@media (max-width: 480px) {
    /* Adjust text size for very small screens */
    .submit-btn {
        font-size: 16px;
    }

    /* Ensure textareas are fully responsive */
    textarea {
        font-size: 14px;
    }

    /* Adjust padding and margins for small screens */
    input, textarea {
        font-size: 12px;
        padding: 8px;
    }

    /* Further reduce table padding */
    th, td {
        font-size: 12px;
        padding: 8px;
    }
}

        th {
            background-color: #e4961f;
            color: white;
        }
        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 10px;
        }
        input, textarea rows="7" {
            width: 100%;
            border: 1px solid black;
            padding: 5px;
            box-sizing: border-box;
        }
        textarea rows="7" {
           height: auto;
            resize: vertical;
        }
         select, input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
        }

        select:focus, input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        

    .translate-container {
            text-align: right;
            margin: 10px;
        }

        /* إخفاء شريط الترجمة العلوي */
        .goog-te-banner-frame {
            display: none !important;
        }

        /* ضبط المسافة العلوية للجسم */
        body {
            top: 0 !important;
        }

        /* تحسين شكل القائمة المنسدلة للترجمة */
        #google_translate_element {
            text-align: right;
            margin: 10px;
        }

        #google_translate_element select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            cursor: pointer;
            background-color: #f8f8f8;
            transition: background-color 0.3s ease;
        }

        #google_translate_element select:hover {
            background-color: #e0e0e0;
        }

        /* منع إخفاء القائمة عند النقر */
        .goog-te-gadget {
            display: inline-block !important;
        }
        /*===============================================================================================================================================*/
/* General Page Styles */


h2 {
    font-size: 24px;
}

/* Inputs */
#marksInput input {
    width: 80%;
    padding: 8px;
    margin: 5px 0;
    border-radius: 5px;
    border: none;
    text-align: center;
}

/* Button */
button {
    padding: 10px 15px;
    background: #ff8c00;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #e67600;
}

/* Popup Styling */
.popup {
    display: none;
    position: fixed;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    width: 300px;
    text-align: center;
    animation: fadeIn 0.5s ease-in-out;
}

.popup-content {
    position: relative;
    color: black;
}
.close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 22px;
    font-weight: bold;
    color: #fff;
    background: #ff4d4d; /* Red close button */
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    text-align: center;
    line-height: 30px;
    cursor: pointer;
    transition: 0.3s ease-in-out;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.close-btn:hover {
    background: #ff1a1a; /* Darker red */
    transform: scale(1.1); /* Slight zoom effect */
}

/* Loading Animation */
.loader {
    border: 5px solid #f3f3f3;
    border-top: 5px solid #ff8c00;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 20px auto;
}

/* Animations */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9) translate(-50%, -50%); }
    to { opacity: 1; transform: scale(1) translate(-50%, -50%); }
}

.readonly-input {
    text-align: center;
    width: 100px; /* Adjust width as needed */
    border: 1px solid #ccc; 
    background-color: #f9f9f9; /* Light gray background */
    font-weight: bold;
}





#gradeText {
    font-size: 20px;
    font-weight: bold;
    margin-top: 10px;
    padding: 5px 10px;
    border-radius: 8px;
    display: inline-block;
}

.excellent {
    color: white;
    background-color: #28a745; /* Green */
}

.very-good {
    color: white;
    background-color: #17a2b8; /* Blue */
}

.good {
    color: white;
    background-color: #ffc107; /* Yellow */
}

.acceptable {
    color: white;
    background-color: #fd7e14; /* Orange */
}

.weak {
    color: white;
    background-color: #d64c33; /* Red */
}
  .title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 10px;
        background-color: #f8f9fa;
        border-bottom: 2px solid #ddd;
    }

    .back-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 5px;
        border-radius: 5px;
    }

    .back-button:hover {
        background-color: #0056b3;
    }

    .title-text {
        flex-grow: 1;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
    }

    #google_translate_element {
        margin-left: auto;
    }
/*===============================================================================================================================================*/
       
    </style>
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement(
                {pageLanguage: 'en', includedLanguages: 'ar,en,fr,de,es', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 
                'google_translate_element'
            );
        }
    </script>
   
</head>
<body>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="container">
<div class="title">
    <button class="back-button" onclick="window.location.href='Dashboard.php'">
        <i class="fa fa-arrow-left"></i> Dashboard
    </button>
    <span class="title-text">INTERVIEW NOTES & FEEDBACK</span>
    <div id="google_translate_element"></div>
</div>
     

    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
 <script>
        function appendFilename() {
            let fileInput = document.getElementById("cvUpload");
            let nameInput = document.getElementById("candidate_name");

            if (fileInput.files.length > 0) {
                let fileName = fileInput.files[0].name.replace(/\.pdf/gi, ""); // Remove ".pdf"
                nameInput.value = nameInput.value + " " + fileName;
            }
        }
    </script>

        <table>
            <tr>
                <th>Candidate Name:</th>
                <td><input type="text" name="candidate_name" id="candidate_name" value=""></td>
                <th>Speciality:</th>
                <td><input type="text" name="speciality" id="speciality"></td>
            </tr>
            <tr>
                <th>Interviewed by:</th>
               <td><input type='text' name='interviewer' value="<? echo $_SESSION["name"]; ?>"  readonly id='interviewer'></td>
                <th>Date & way of interview:</th>
                <td><input type="date" name="date_interview" id="date_interview">
                <select name="way" id="way">
    <option value="online">Online</option>
    <option value="offline">Offline</option>
</select>
</td>
            </tr>

            <tr>
                <th>Current Location:</th>
                <td><input type="text" name="current_location" id="current_location"></td>
                        

                <th>Resume:</th>
               
<td> <input type="file" id="cvUpload" name="cv" accept=".pdf, .doc, .docx" required onchange="appendFilename()"></td>
  </tr>
        </table>
        <table>
            <tr>
                <th>Questions</th>
                 <th>Mark</th>
               <!-- <th>Notes</th>-->
            </tr>
           <?php 
            $qNumber = 1;
            while ($qRow = $questionsResult->fetch_assoc()) { 
                $qID = $qRow['id'];
                $questionText = $qRow['question_text'];

                echo "<tr>
                    <td>
                        <b>{$qNumber}. {$questionText}</b><br><br>";

                // Fetch answers for this question
                $answersQuery = "SELECT * FROM Answers WHERE question_id = $qID";
                $answersResult = $conn->query($answersQuery);
                while ($aRow = $answersResult->fetch_assoc()) {
                    $answerText = $aRow['answer_text'];
                    $answerPoints = $aRow['points'];

                    echo "<label class='checkbox-container'>
                        <input type='checkbox' name='q{$qID}' value='{$answerPoints}' onclick='setPoints(this, \"mark{$qID}\")'>
                        $answerText (<font color='green'>{$answerPoints} pts</font>)
                    </label>";
                }

                echo "</td>
                    <td><input type='text' readonly name='mark{$qID}' id='mark{$qID}' class='readonly-input'></td>
                    <!--<td><textarea rows='6' name='n{$qID}' id='n{$qID}'></textarea></td>-->
                </tr>";

                $qNumber++;
            } 
            ?>
            </table>



     <br>
        <table>
            <tr>
                <th>Candidate Questions</th>
                <td><textarea rows="12" cols="100" name="candidate_questions" id="candidate_questions"></textarea></td>
            </tr>
            <tr>
                <th>Overall Feedback</th>
                <td><textarea rows="12" cols="100" name="overall_feedback" id="overall_feedback"></textarea></td>
            </tr>
            <tr>
                <th>Final Decision</th>
                <td><textarea rows="12" cols="100" name="final_decision" id="final_decision"></textarea></td>
            </tr>
        </table>
         <input type="hidden" name="total_points" id="total_points">
        <input type="hidden" name="rate" id="rate">
         <div class="button-container">
         <center>
<div id="calculateMarks" onclick="calculateTotalMarks()" style="cursor: pointer; padding: 17px 17px; background: blue; color: white; text-align: center; display: inline-block; border-radius: 5px;">
   <b> Calculate<b>
</div>

<!-- Popup Structure -->
<div id="popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0,0,0,0.2);">
    <div id="loadingAnimation">🔄 Calculating...</div>
    <div id="percentageResult" style="display: none;">🎯 Total Marks: <b>0</b></div><br><br>
    <div id="gradeText" style="display: none;"> <b>---</b></div><br><br>
    <div style="margin-top: 10px; text-align: center; cursor: pointer; background: red; color: white; padding: 5px; border-radius: 5px;" onclick="closePopup()">Close</div>
</div>
<button class="submit-btn" name="submit">Submit</button>
</center>   
   </form> 
   
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["cv"])) {
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $file = $_FILES["cv"];
    $allowedExtensions = ["pdf", "doc", "docx"];
    $fileExt = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    if ($file["error"] !== UPLOAD_ERR_OK) {
    } elseif (!in_array($fileExt, $allowedExtensions)) {
    } else {
        $newFileName = basename($file["name"]);
        $filePath = $uploadDir . $newFileName;

        if (move_uploaded_file($file["tmp_name"], $filePath)) {
        } else {
        }
    }
}
?>

</div>
      </div>
    </div>
</div>   

    
<script>
function calculateTotalMarks() {
    let totalMarks = 0;

    // Find all inputs where ID starts with "mark"
    document.querySelectorAll("[id^=mark]").forEach(markField => {
        if (markField.value !== "") {
            totalMarks += parseFloat(markField.value) || 0;
        }
    });

    showPopup(totalMarks.toFixed(2));
}

function showPopup(totalMarks) {
    let popup = document.getElementById("popup");
    let resultText = document.getElementById("percentageResult");
    let loader = document.getElementById("loadingAnimation");
    let gradeText = document.getElementById("gradeText");

    let grade = "";
    
    if (totalMarks >= 90) grade = "Excellent";
    else if (totalMarks >= 80) grade = "Very Good";
    else if (totalMarks >= 70) grade = "Good";
    else if (totalMarks >= 51) grade = "Acceptable";
    else grade = "Weak";
    document.getElementById("total_points").value = totalMarks;
    document.getElementById("rate").value = grade;
    popup.style.display = "block";
    loader.style.display = "block";
    resultText.style.display = "none";
    gradeText.style.display = "none";

    setTimeout(() => {
        loader.style.display = "none";
        resultText.innerHTML = `<br> 🎯 Total Marks: <b>${totalMarks}</b><br><br>`;
        gradeText.innerHTML = `<b>${grade}</b>`;
        resultText.style.display = "block";
        gradeText.style.display = "block";
    }, 1500);
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
}
</script>
<script>
function setPoints(checkbox, markId) {
    // Uncheck all other checkboxes in the same question group
    let checkboxes = document.getElementsByName(checkbox.name);
    checkboxes.forEach((cb) => {
        if (cb !== checkbox) {
            cb.checked = false;
        }
    });

    // Set the value of the corresponding mark input field
    document.getElementById(markId).value = checkbox.checked ? checkbox.value : "";
}

</script>




</body>
</html>
