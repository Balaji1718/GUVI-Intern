<?php
// php/mongo.php
require __DIR__ . '/../vendor/autoload.php';


try {
    // MongoDB Atlas connection for production
    $mongoClient = new MongoDB\Client('mongodb+srv://balajiteen18:1810Google@cluster0.chavlh5.mongodb.net/?appName=Cluster0');
    $mongoDB = $mongoClient->intern_profiles; // database
    $profilesColl = $mongoDB->user_profiles; // collection
} catch (Exception $e) {
    // Log error but don't expose details in production
    error_log("MongoDB connection failed: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection error']);
    exit;
}