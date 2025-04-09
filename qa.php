<?php
require 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q&A Management</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { width: 80%; margin: auto; padding: 20px; background: white; border-radius: 10px; }
        .questions-wrapper { display: flex; flex-wrap: wrap; gap: 20px; }
        .question-frame { border: 2px solid #ccc; padding: 15px; border-radius: 10px; width: calc(50.33% - 20px); box-sizing: border-box; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: black; color: white; }
        input, button { padding: 10px; margin: 5px; }
        a { text-decoration: none; color: inherit; }
        .answer-wrapper { display: flex; align-items: center; gap: 10px; }
        input[name='new_answer_points'], input[name='answer_points'] { width: 60px; } /* Small Points Field */
        input[name='new_answer_text'], input[name='answer_text'] { width: 300px; } /* Small Answer Field */
        input[name='question_text'] { width: 300px; } /* Small Question Field */
        .input-group {
        display: flex;
        align-items: center;
        gap: 10px; /* Adjust spacing between textarea and button */
        margin-bottom: 15px;
    }

    .input-group textarea {
        flex: 1; /* Takes up available space */
        padding: 10px;
        border: 2px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        resize: none;
    }

    .input-group button {
        padding: 10px 15px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }

    .input-group button:hover {
        background-color: #45a049;
    }
    </style>
</head>
<body>
    <div class="container">
       <center> <h2>Manage Questions & Answers</h2></center> <br>
       <center> <form method="POST">
 <div class="input-group">
        <textarea name="new_question_text" required placeholder="Enter new question"></textarea>
        <button type="submit" name="addQ">Add Question</button>
    </div>        </form> </center><br><br>
        <div class="questions-wrapper">
            <?php while ($qRow = $questionsResult->fetch_assoc()) { ?>
                <div class="question-frame">
                  <center>  <form method="POST">
                        <input type="hidden" name="question_id" value="<?php echo $qRow['id']; ?>">
                        <input class="input-group textarea" type="text" name="question_text" required value="<?php echo $qRow['question_text']; ?>">
                        <button type="submit" name="updateQ">Update</button> <button type="submit" name="addA">Add Answer</button> <button type="submit" name="deleteQ"><font color="red">Delete</font></button> 
                    </form></center>
                   <center>
                    <h4>Answers:</h4></center>
                    <?php 
                    $qID = $qRow['id'];
                    $answersQuery = "SELECT * FROM Answers WHERE question_id = $qID";
                    $answersResult = $conn->query($answersQuery);
                    while ($aRow = $answersResult->fetch_assoc()) { ?>
                       <form method="POST" class="answer-wrapper" style="display: flex; align-items: center; gap: 10px;">
    <input type="hidden" name="answer_id" value="<?php echo $aRow['id']; ?>">
    <input type="text" required name="answer_text" value="<?php echo $aRow['answer_text']; ?>">
    <input type="text" required name="answer_points" value="<?php echo $aRow['points']; ?>">
    <button type="submit" name="updateA">Update</button>
    <button type="submit" name="deleteA" style="background: none; border: none; cursor: pointer; color: red; font-size: 18px;">❌</button>
</form>

                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>