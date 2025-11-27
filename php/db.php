<?php
// php/db.php
// MySQL database connection

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intern_profiles";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Connection successful
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>