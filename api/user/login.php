<?php
// ini_set("display_errors", 1);
require '../../header.php';
require '../../vendor/autoload.php';

use \App\JWTToken;

$user = new \App\user\User();

if ($_SERVER['REQUEST_METHOD'] != "POST") {
  http_response_code(405);
  echo json_encode([
    "status" => 405,
    "message" => "Requested method is not allowed"
  ]);
  die;
}

$data = json_decode(file_get_contents("php://input"));
if (empty($data)) {
  http_response_code(400);
  echo json_encode([
    "status" => 400,
    "message" => "Invalid request"
  ]);
  die;
}

$user_data = $user->login($data->username, $data->password);
if ($user_data == "500") {
  http_response_code(500);
  echo json_encode([
    "status" => 500,
    "message" => "Login failed"
  ]);
  die;
}

if (!empty($user_data)) {
  http_response_code(200);
  echo json_encode([
    "status" => 200,
    "message" => "Login successful",
    "jwtoken" => JWTToken::generateJWT($user_data)
  ]);
} else {
  http_response_code(401);
  echo json_encode([
    "status" => 401,
    "message" => "Invalid credintials"
  ]);
}
die;
