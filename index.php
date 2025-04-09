<?php
session_start();

// Database connection
$servername = "sql303.infinityfree.com";
$db_username = "if0_38485688"; // Change if necessary
$db_password = "cexWqtvxJ70";  // Change if necessary
$dbname = "if0_38485688_ngs";  // Change to your actual database name

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        
        $stmt = $conn->prepare("SELECT id, name, username, password, role FROM Users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Compare passwords directly (not secure if passwords are hashed)
            if ($password === $user["password"]) {
                // Store session variables
                $_SESSION["id"] = $user["id"];
                $_SESSION["name"] = $user["name"];
                $_SESSION["role"] = $user["role"];
                $_SESSION["logged_in"] = true;

                // Redirect to refresh the session variables
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $error = "Invalid username or password!";
            }
        } else {
            $error = "Invalid username or password!";
        }
        $stmt->close();
    } else {
        $error = "Username and password are required!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('https://media-whichmedia.s3.ap-southeast-1.amazonaws.com/media/large/6/2/62fc796f1a94.jpg') no-repeat center center/cover;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .logo {
            width: 80px;
            margin-bottom: 20px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #0052cc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #003d99;
        }
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .popup-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .popup button {
            margin-top: 10px;
            background: #0052cc;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
    <script>
        window.onload = function() {
            <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true): ?>
                document.getElementById('welcome-popup').style.display = 'flex';
                <?php unset($_SESSION["logged_in"]); // Remove session flag after displaying ?>
            <?php endif; ?>
        };
    </script>
</head>
<body>
    <div class="login-container">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSlWTyC9UUynmQA6LC-2k86oCa-w3OaFcO5MA&s" alt="Logo" class="logo">
       <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
       <form action="" method="POST">
        <input type="text" placeholder="Username" id="username" name="username" required>
        <input type="password" placeholder="Password" id="password" name="password" required>
        <button type="submit">Login</button>
         </form>
    </div>
    
    <div id="welcome-popup" class="popup">
        <div class="popup-content">
            <h2>Welcome back, <?php echo $_SESSION['name'] ?? ''; ?>!</h2>
            <button onclick="document.getElementById('welcome-popup').style.display='none'; window.location.href='Dashboard.php';">OK</button>
        </div>
    </div>
</body>
</html>
