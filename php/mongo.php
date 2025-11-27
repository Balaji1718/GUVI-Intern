<?php
// php/mongo.php
require __DIR__ . '/../vendor/autoload.php';


try {
// default local Mongo URL - change if needed
$mongoClient = new MongoDB\Client('mongodb://127.0.0.1:27017');
$mongoDB = $mongoClient->intern_profiles; // database
$profilesColl = $mongoDB->profiles;
} catch (Exception $e) {
// don't echo internal errors in production
http_response_code(500);
echo json_encode(['success' => false, 'message' => 'Mongo connection error']);
exit;
}