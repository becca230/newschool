<?php
// db_connect.php

$host = "localhost";
$dbname = "newschool_db";  // <-- change to your database name
$username = "root";     // default for XAMPP
$password = "";         // default is empty in XAMPP

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set PDO error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}