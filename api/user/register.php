<?php
// ini_set("display_errors", 1);
require '../../header.php';
require '../../vendor/autoload.php';

$jwt = new \App\JWTToken();
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

$user->set([
  "name" => $data->name,
  "email" => $data->email,
  "username" => $data->username,
  "password" => password_hash($data->password, PASSWORD_DEFAULT),
  "is_admin" => 0,
  "registered_at" => date('Y-m-d H:i:s')
]);

$user_created_msg = $user->create(
  $data->name,
  $data->email,
  $data->username,
  $data->password,
  date('Y-m-d H:i:s')
);

if ($user_created_msg == "201") {
  http_response_code(201);
  echo json_encode([
    "status" => 201,
    "message" => "User registered successfully"
  ]);
  die;
} else {
  http_response_code(401);
  echo json_encode([
    "status" => 401,
    "message" => "User registration failed"
  ]);
  die;
}
