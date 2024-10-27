<?php

$host = 'localhost';
$db = 'login';  
$user = 'root';  
$pass = '';      

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Database connection successful";  
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>