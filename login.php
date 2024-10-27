
<?php
// login.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection
    $host = 'localhost';
    $db = 'login';  // database name
    $user = 'root'; // database username
    $pass = '';     // password
    
    session_start();

    if (empty($email) || empty($password)) {
        $message = "Email and password are required.";
    } else {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['firstname'];
                $message = "Login successful! Welcome, " . $_SESSION['user_name'];
            } else {
                $message = "Invalid email or password.";
            }   
        } catch (PDOException $e) {
            $message = "Database connection failed: " . $e->getMessage();
        }
    }
} else {
    $message = "Invalid request.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color:white;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
            padding: 20px;
            background-color: white;
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
        .logout-btn {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <p class="message"><?php echo $message; ?></p>
        <a href="login.html" class="logout-btn">Log Out</a>
    </div>
</body>
</html>
