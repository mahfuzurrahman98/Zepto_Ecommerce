<?php
ini_set("display_errors", 1);
require '../../header.php';
require '../../vendor/autoload.php';

use \App\user\User;

$product = new \App\product\Product();

// check request
if ($_SERVER['REQUEST_METHOD'] != "POST") {
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
if (empty($_POST)) {
  http_response_code(400);
  echo json_encode([
    "status" => 400,
    "message" => "Invalid request"
  ]);
  die;
}

// check all data
if (
  (!isset($_POST['id']) || $_POST['id'] == "") ||
  (!isset($_POST['name']) || $_POST['name'] == "") ||
  (!isset($_POST['price']) || $_POST['price'] == "")
) {
  http_response_code(400);
  echo json_encode([
    "status" => 400,
    "message" => "Invalid product information"
  ]);
  die;
}

$get_product_info = $product->getProductById($_POST['id']);
if (!is_array($get_product_info)) {
  http_response_code(500);
  echo json_encode([
    "status" => 500,
    "message" => $get_product_info
  ]);
  die;
}

// process file
$prev_file = $get_product_info['Image'];
if (isset($_FILES['image'])) {
  $fname = $_FILES['image']['name'];
  $ftmp = $_FILES['image']['tmp_name'];
  $ftyp = $_FILES['image']['type'];
  $fext = strtolower(substr($fname, strrpos($fname, '.')  + 1));

  if ($fext == 'jpg' or $fext == 'jpeg' or $fext == 'png') {
    unlink("../../uploads/" . $prev_file);
    move_uploaded_file($ftmp, "../../uploads/" . $fname);
  } else {
    http_response_code(400);
    echo json_encode([
      'status' => 400,
      'message' => 'Only jpg, jpeg, and png format is allowed!'
    ]);
    die;
  }
} else {
  $fname = $prev_file;
}

// set product info
$product->set([
  'name' => $_POST['name'],
  'price' => $_POST['price'],
  'image' => $fname
]);

// update product
$add_data_msg = $product->updateProductById($_POST['id']);

if ($add_data_msg != "200") {
  http_response_code(500);
  echo json_encode([
    "status" => 500,
    "message" => $add_data_msg
  ]);
  die;
}

http_response_code(200);
echo json_encode([
  "status" => 200,
  "message" => "Product updated successfully"
]);
