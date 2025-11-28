<?php
require __DIR__ . '/../vendor/autoload.php';
require_once 'redis.php';
require_once 'db.php';

header("Content-Type: application/json");

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(["success" => false, "message" => "Email & password required"]);
    exit;
}

// Authenticate from MySQL (registration data)
try {
    // Use the existing db connection from db.php
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo json_encode(["success" => false, "message" => "Email not found"]);
        exit;
    }
    
    // verify password
    if (!password_verify($password, $user['password'])) {
        echo json_encode(["success" => false, "message" => "Wrong password"]);
        exit;
    }
    
    // Create session token for Redis
    $sessionToken = bin2hex(random_bytes(32));
    $sessionData = json_encode([
        'user_id' => $user['id'],
        'email' => $user['email'],
        'login_time' => time()
    ]);
    
    // Store session in Redis
    if ($redis) {
        $redis->setex("session:$sessionToken", 3600, $sessionData); // 1 hour expiry
    }
    
    echo json_encode(["success" => true, "token" => $sessionToken]);
    
} catch(PDOException $e) {
    echo json_encode(["success" => false, "message" => "Login failed"]);
} catch(Exception $e) {
    echo json_encode(["success" => false, "message" => "Login error"]);
}
