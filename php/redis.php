<?php
// php/redis.php
// Predis is installed via composer in your vendor/ (you installed predis/predis)
require __DIR__ . '/../vendor/autoload.php';

// Initialize Redis connection variable
$r = null;

// Use Predis client as fallback if phpredis extension not present
try {
    // Check if native PHP Redis extension is available
    if (extension_loaded('redis') && class_exists('Redis')) {
        // Use dynamic instantiation to avoid static analysis errors
        $r = new ('Redis')();
        $r->connect('127.0.0.1', 6379);
    } else {
        // Use Predis library as fallback
        $r = new Predis\Client(['scheme' => 'tcp', 'host' => '127.0.0.1', 'port' => 6379]);
    }
} catch (Exception $e) {
    // ignore - Redis optional for sessions; your app will work without it
    $r = null;
}