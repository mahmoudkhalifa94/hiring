
    <form action="" method="POST" enctype="multipart/form-data">
           
            <input type="file" id="cvUpload" name="cv" accept=".pdf, .doc, .docx" required>

            
            <button type="submit" name="submit">Submit Application</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["cv"])) {
            $uploadDir = "uploads/";

            // Create uploads folder if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $file = $_FILES["cv"];
            $allowedExtensions = ["pdf", "doc", "docx"];
            $fileExt = pathinfo($file["name"], PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileExt), $allowedExtensions)) {
                echo "<p style='color: red;'>Error: Invalid file type. Only PDF, DOC, and DOCX allowed.</p>";
            } else {
                // Rename file to prevent conflicts
                $newFileName = time() . "-" . basename($file["name"]);
                $filePath = $uploadDir . $newFileName;

                if (move_uploaded_file($file["tmp_name"], $filePath)) {
                    echo "<p style='color: green;'>Success: File uploaded as <strong>$newFileName</strong></p>";
                } else {
                    echo "<p style='color: red;'>Error: Failed to save file.</p>";
                }
            }
        }
        ?>