<?php
require '../vendor/autoload.php';
require 'redis.php';

use MongoDB\Client;

header("Content-Type: application/json");

// Validate session from Redis
$token = $_POST['token'] ?? $_GET['token'] ?? '';
if (!$token) {
    echo json_encode(["success" => false, "message" => "No session token"]);
    exit;
}

$sessionData = null;
if ($redis) {
    $sessionJson = $redis->get("session:$token");
    if ($sessionJson) {
        $sessionData = json_decode($sessionJson, true);
    }
}

if (!$sessionData) {
    echo json_encode(["success" => false, "message" => "Invalid or expired session"]);
    exit;
}

$userId = $sessionData['user_id'];

try {
    // Get user profile from MongoDB (profile storage)
    $mongoClient = new Client('mongodb+srv://balajiteen18:1810Google@cluster0.chavlh5.mongodb.net/?appName=Cluster0');
    $mongoDB = $mongoClient->intern_profiles;
    $collection = $mongoDB->user_profiles;
    
    // First try to find profile by user_id
    $user = $collection->findOne(["user_id" => $userId]);
    
    // If no profile exists, create one from MySQL registration data
    if (!$user) {
                // Connect to production MySQL database
                try {
                    $updatePdo = new PDO("mysql:host=sql7.freesqldatabase.com;port=3306;dbname=sql7809781", "sql7809781", "HBmu4Uw8kp");
                    $updatePdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch(PDOException $e) {
                    $updatePdo = null;
                }
                
                if ($updatePdo) {
                    $setParts = [];
                    $values = [];
                    foreach ($updateData as $key => $value) {
                        $setParts[] = "$key = ?";
                        $values[] = $value;
                    }
                    $values[] = $user['email']; // for WHERE clause
                    
                    $sql = "UPDATE users SET " . implode(', ', $setParts) . " WHERE email = ?";
                    $stmt = $updatePdo->prepare($sql);
                    $stmt->execute($values);
                }        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $mysqlUser = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($mysqlUser) {
            // Create profile in MongoDB with all required fields
            $profileData = [
                "user_id" => $userId,
                "email" => $mysqlUser['email'],  // Required: email to link with MySQL user
                "name" => $mysqlUser['full_name'] ?? $mysqlUser['name'] ?? '',
                "age" => null,  // Will be updated by user
                "dob" => null,  // Will be updated by user
                "phone" => $mysqlUser['phone'] ?? null,  // Required: phone number
                "address" => $mysqlUser['address'] ?? null,  // Required: address
                "gender" => null,  // Required: will be updated by user
                "created_at" => date('Y-m-d H:i:s')
            ];
            $collection->insertOne($profileData);
            $user = $profileData;
        }
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Database connection error"]);
    exit;
}

// Handle profile updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    // Re-validate session for updates
    $updateToken = $_POST['token'] ?? '';
    if (!$updateToken || !$redis || !$redis->get("session:$updateToken")) {
        echo json_encode(["success" => false, "message" => "Invalid session for update"]);
        exit;
    }
    
    if (!$user) {
        echo json_encode(["success" => false, "message" => "User not found"]);
        exit;
    }
    
    $updateData = [];
    if (isset($_POST['name']) && !empty($_POST['name'])) $updateData['name'] = $_POST['name'];
    if (isset($_POST['email']) && !empty($_POST['email'])) $updateData['email'] = $_POST['email'];
    if (isset($_POST['age']) && !empty($_POST['age'])) $updateData['age'] = (int)$_POST['age'];
    if (isset($_POST['dob']) && !empty($_POST['dob'])) $updateData['dob'] = $_POST['dob'];
    if (isset($_POST['phone']) && !empty($_POST['phone'])) $updateData['phone'] = $_POST['phone'];
    if (isset($_POST['address']) && !empty($_POST['address'])) $updateData['address'] = $_POST['address'];
    if (isset($_POST['gender']) && !empty($_POST['gender'])) $updateData['gender'] = $_POST['gender'];
    
    if (!empty($updateData)) {
        try {
            // Update profile in MongoDB only
            $collection->updateOne(["user_id" => $userId], ['$set' => $updateData]);
            
            echo json_encode(["success" => true, "message" => "Profile updated successfully"]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Update failed"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "No data to update"]);
    }
    exit;
}

if (!$user) {
    echo json_encode(["success" => false]);
    exit;
}

echo json_encode([
    "success" => true,
    "user" => [
        "name" => $user['name'] ?? '',
        "email" => $user['email'] ?? '',
        "age" => $user['age'] ?? '',
        "dob" => $user['dob'] ?? '',
        "phone" => $user['phone'] ?? '',
        "address" => $user['address'] ?? '',
        "gender" => $user['gender'] ?? '',
        "created_at" => $user['created_at'] ?? ''
    ]
]);
