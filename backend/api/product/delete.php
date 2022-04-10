<?php
// ini_set("display_errors", 1);
require '../../header.php';
require '../../vendor/autoload.php';

use \App\user\User;

$product = new \App\product\Product();

// check request
if ($_SERVER['REQUEST_METHOD'] != "DELETE") {
  http_response_code(405);
  echo json_encode([
    "status" => 405,
    "message" => "Requested method is not allowed"
  ]);
  die;
}

// get token and vallidate
$headers = getallheaders();
$jwtoken = $headers['Authorization'];
User::authenticateUser($jwtoken);


// check admin or not
if (User::getUser('is_admin') != 1) {
  http_response_code(401);
  echo json_encode([
    "status" => 401,
    "message" => "Unauthorized access"
  ]);
  die;
}

// get data
$data = json_decode(file_get_contents("php://input"));
if (empty($data)) {
  http_response_code(400);
  echo json_encode([
    "status" => 400,
    "message" => "Invalid request"
  ]);
  die;
}

// check data
if ((!isset($data->id))) {
  http_response_code(400);
  echo json_encode([
    "status" => 400,
    "message" => "Invalid product id"
  ]);
  die;
}

// delete product
$delete_data_msg = $product->deleteProductById($data->id);

if ($delete_data_msg != "200") {
  http_response_code(500);
  echo json_encode([
    "status" => 500,
    "message" => $delete_data_msg
  ]);
  die;
}

// get single product
$product_info = $product->getProductById($data->id);

if (!is_array($product_info)) {
  http_response_code(404);
  echo json_encode([
    "status" => 404,
    "message" => "The requested resource not found"
  ]);
  die;
}

// delete image
unlink("../../uploads/" . $product_info['Image']);
http_response_code(200);
echo json_encode([
  "status" => 200,
  "message" => "Product deleted successfully"
]);
