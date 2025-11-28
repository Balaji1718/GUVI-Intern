<?php
// php/redis.php
// Predis is installed via composer in your vendor/ (you installed predis/predis)
require __DIR__ . '/../vendor/autoload.php';

// Initialize Redis connection variable
$redis = null;

// Use Predis client as fallback if phpredis extension not present
try {
    // Check if native PHP Redis extension is available
    if (extension_loaded('redis') && class_exists('Redis')) {
        // Use dynamic instantiation to avoid static analysis errors
        $redis = new ('Redis')();
        $redis->connect('redis-19218.c99.us-east-1-4.ec2.cloud.redislabs.com', 19218);
        $redis->auth('default:LB00vHobCQAxVH1cGFh9Lmf3qmneiIR1');
    } else {
        // Use Predis library as fallback
        $redis = new Predis\Client('redis://default:LB00vHobCQAxVH1cGFh9Lmf3qmneiIR1@redis-19218.c99.us-east-1-4.ec2.cloud.redislabs.com:19218');
    }
} catch (Exception $e) {
    // ignore - Redis optional for sessions; your app will work without it
    $redis = null;
}