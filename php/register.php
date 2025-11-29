<?php
header("Content-Type: application/json");

// Always enable error reporting during development
error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/../vendor/autoload.php';

// Read POST data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$age = $_POST['age'] ?? '';
$dob = $_POST['dob'] ?? '';
$contact = $_POST['contact'] ?? '';

if (!$name || !$email || !$password || !$age || !$dob || !$contact) {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}

// Validate age and contact
if (!is_numeric($age) || $age < 18 || $age > 100) {
    echo json_encode(["success" => false, "message" => "Age must be between 18 and 100"]);
    exit;
}

if (!preg_match('/^[0-9]{10}$/', $contact)) {
    echo json_encode(["success" => false, "message" => "Contact must be 10 digits"]);
    exit;
}

// Store registration data in both MySQL and MongoDB
try {
    // Use the standard database connection
    require_once 'db.php';
    
    // Use the global $pdo from db connection
    global $pdo;
    
    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(["success" => false, "message" => "Email already registered"]);
        exit;
    }
    
    // Insert new user in MySQL using proper prepared statement
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
    
    // Also create profile in MongoDB with registration data
    try {
        // Use the same MongoDB connection from mongo.php
        require_once 'mongo.php';
        global $profilesColl;
        
        $profileData = [
            'email' => $email,
            'name' => $name,
            'age' => $age,
            'dob' => $dob,
            'phone' => $contact,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ];
        
        $profilesColl->insertOne($profileData);
    } catch(Exception $mongoError) {
        // MongoDB error shouldn't stop registration, just log it
        error_log("MongoDB profile creation failed: " . $mongoError->getMessage());
    }
    
} catch(PDOException $e) {
    echo json_encode(["success" => false, "message" => "Registration failed"]);
    exit;
}

echo json_encode(["success" => true]);
