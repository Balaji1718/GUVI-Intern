<?php
// php/logout.php
header('Content-Type: application/json');
require 'redis.php';
$token = $_POST['token'] ?? '';
if($token){
  $sessionKey = "session:$token";
  $redis->del([$sessionKey]);
}
echo json_encode(['success'=>true]);
