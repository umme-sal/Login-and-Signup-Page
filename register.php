<?php
// register.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get data
    $firstname = $_POST['firstname'];
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword=$_POST['repassword'];
    
    // Database connection
    $host = 'localhost';
    $db = 'login';  // database name
    $user = 'root'; // database username
    $pass = '';     // password
    
    if (empty($firstname) || empty($repassword) || empty($email) || empty($password)) {
        $message = "All fields are required.";
    } else {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if email already exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $existingUser = $stmt->fetch();

            if ($existingUser) {
                $message = "Email is already registered.";
            } else {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert user data
                $stmt = $pdo->prepare("INSERT INTO users (firstname,email, password) VALUES (?, ?, ?)");
                $stmt->execute([$firstname,$email, $hashedPassword]);

                $message = "Registration successful! You can now log in.";
            }
        } catch (PDOException $e) {
            $message = "Database connection failed: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            width: 100%;
        }
        .message {
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
        }
        .back-btn {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($message)) { ?>
            <p class="message"><?php echo $message; ?></p>
        <?php } ?>
        <a href="login.html" class="back-btn">Go to Login</a>
    </div>
</body>
</html>
