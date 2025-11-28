<?php
// php/db.php
// Production MySQL database connection

$servername = "sql7.freesqldatabase.com";
$username = "sql7809781";
$password = "HBmu4Uw8kp";
$dbname = "sql7809781";
$port = 3306;

// Function to get database connection
function getDBConnection() {
    global $servername, $username, $password, $dbname, $port;
    
    try {
        // Connect to production database
        $dsn = "mysql:host=$servername;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create users table if not exists
        $createTable = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB";
        
        $pdo->exec($createTable);
        return $pdo;
        
    } catch(PDOException $e) {
        throw new PDOException("Database connection failed: " . $e->getMessage());
    }
}

// Initialize connection
try {
    $pdo = getDBConnection();
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>