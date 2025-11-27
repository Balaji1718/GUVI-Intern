<?php
header("Content-Type: application/json");

// Always enable error reporting during development
error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/../vendor/autoload.php';

// Connect to MongoDB
$client = new MongoDB\Client("mongodb://127.0.0.1:27017");
$collection = $client->intern_profiles->profiles;

// Read POST data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$name || !$email || !$password) {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}

// Check if email exists
$exists = $collection->findOne(["email" => $email]);
if ($exists) {
    echo json_encode(["success" => false, "message" => "Email already registered"]);
    exit;
}

// Insert new user
$collection->insertOne([
    "name" => $name,
    "email" => $email,
    "password" => password_hash($password, PASSWORD_DEFAULT),
    "created_at" => date("Y-m-d H:i:s")
]);

echo json_encode(["success" => true]);
