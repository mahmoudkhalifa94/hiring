<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Upload & Autofill Form</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.2/mammoth.browser.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            width: 50%;
            margin: auto;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, textarea, button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid black;
            border-radius: 5px;
        }
        textarea {
            height: 150px;
            white-space: pre-wrap; /* Keeps line breaks */
        }
        button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Upload Your CV & Auto-Fill the Form</h2>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="cvUpload">Upload CV:</label>
            <input type="file" id="cvUpload" name="cv" accept=".pdf, .doc, .docx" required>

            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email">

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone">

            <label for="experience">Work Experience:</label>
            <textarea id="experience" name="experience"></textarea>

            <label for="skills">Skills:</label>
            <textarea id="skills" name="skills"></textarea>

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

    </div>

    <script>
        document.getElementById("cvUpload").addEventListener("change", function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                // Extract full name from the file name
                const fileName = file.name;
                const fullName = extractFullNameFromFileName(fileName);
                document.getElementById("fullName").value = fullName;

                if (file.type === "application/pdf") {
                    reader.onload = function() {
                        extractTextFromPDF(reader.result);
                    };
                    reader.readAsArrayBuffer(file);
                } else if (file.type === "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                    reader.onload = function() {
                        extractTextFromDocx(reader.result);
                    };
                    reader.readAsArrayBuffer(file);
                } else {
                    alert("Please upload a PDF or DOCX file.");
                }
            }
        });

        function extractFullNameFromFileName(fileName) {
            const nameWithoutExtension = fileName.replace(/\.[^/.]+$/, "");
            return nameWithoutExtension.replace(/_/g, " ");
        }

        function extractTextFromPDF(pdfData) {
            const loadingTask = pdfjsLib.getDocument({ data: pdfData });
            loadingTask.promise.then(pdf => {
                let textContent = "";
                const promises = [];
                for (let i = 1; i <= pdf.numPages; i++) {
                    promises.push(
                        pdf.getPage(i).then(page => {
                            return page.getTextContent().then(text => {
                                text.items.forEach(item => textContent += item.str + "\n");
                            });
                        })
                    );
                }
                Promise.all(promises).then(() => fillForm(textContent));
            });
        }

        function extractTextFromDocx(docData) {
            mammoth.extractRawText({ arrayBuffer: docData }).then(result => {
                fillForm(result.value);
            });
        }

        function fillForm(text) {
            document.getElementById("email").value = extractEmail(text);
            document.getElementById("phone").value = extractPhone(text);
            document.getElementById("experience").value = extractWorkExperience(text);
            document.getElementById("skills").value = extractSection(text, "Skills", ["Education", "Projects"]);
        }

        function extractEmail(text) {
            const emailMatch = text.match(/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/);
            return emailMatch ? emailMatch[0] : "";
        }

        function extractPhone(text) {
            const phoneMatch = text.match(/\+?\d{1,3}?[-.\s]?\(?\d{2,4}\)?[-.\s]?\d{2,4}[-.\s]?\d{2,9}/);
            return phoneMatch ? phoneMatch[0] : "";
        }

        function extractWorkExperience(text) {
            const dateRegex = /\b(\d{2}\/\d{4}|\d{4})\b/g;
            const lines = text.split("\n");
            let experienceText = "Work Experience:\n";

            lines.forEach(line => {
                if (dateRegex.test(line)) {
                    experienceText += `• ${line.trim()}\n`;
                }
            });

            return experienceText;
        }

        function extractSection(text, startKeyword, endKeywords) {
            const startIndex = text.indexOf(startKeyword);
            if (startIndex === -1) return "Not Found";

            let endIndex = text.length;
            for (const endKeyword of endKeywords) {
                const tempEndIndex = text.indexOf(endKeyword, startIndex);
                if (tempEndIndex !== -1 && tempEndIndex < endIndex) {
                    endIndex = tempEndIndex;
                }
            }

            let sectionText = text.substring(startIndex + startKeyword.length, endIndex).trim();
            sectionText = sectionText.replace(/^[•.\s]+/gm, "");
            sectionText = sectionText.replace(/(^|\n)([^\n]+)/g, "$1• $2");

            return sectionText;
        }
    </script>

</body>
</html>
