<?php
// php/logout.php
header('Content-Type: application/json');
require 'redis.php';
$token = $_POST['token'] ?? '';
if($token && $r){
  $sessionKey = "session:$token";
  $r->del($sessionKey);
}
echo json_encode(['success'=>true]);
