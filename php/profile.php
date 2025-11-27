<?php
session_start();
require '../vendor/autoload.php';

use MongoDB\Client;

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

try {
    // Initialize MongoDB client
    $mongoClient = new Client('mongodb://127.0.0.1:27017');
    $mongoDB = $mongoClient->intern_profiles;
    $collection = $mongoDB->profiles;

    // Use fully qualified class name to avoid static analysis issues
    $objectIdClass = '\\MongoDB\\BSON\\ObjectId';
    $id = new $objectIdClass($_SESSION['user_id']);
    $user = $collection->findOne(["_id" => $id]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Database connection error"]);
    exit;
}

if (!$user) {
    echo json_encode(["success" => false]);
    exit;
}

echo json_encode([
    "success" => true,
    "user" => [
        "name" => $user['name'],
        "email" => $user['email'],
        "created_at" => $user['created_at']
    ]
]);
