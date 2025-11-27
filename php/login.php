<?php
session_start();
require '../vendor/autoload.php';

header("Content-Type: application/json");

$client = new MongoDB\Client("mongodb://127.0.0.1:27017");
$collection = $client->intern_profiles->profiles;

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(["success" => false, "message" => "Email & password required"]);
    exit;
}

$user = $collection->findOne(["email" => $email]);

if (!$user) {
    echo json_encode(["success" => false, "message" => "Email not found"]);
    exit;
}

// verify password
if (!password_verify($password, $user['password'])) {
    echo json_encode(["success" => false, "message" => "Wrong password"]);
    exit;
}

// create session
$_SESSION['user_id'] = (string)$user['_id'];

echo json_encode(["success" => true]);
