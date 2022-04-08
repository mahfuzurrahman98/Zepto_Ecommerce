<?php
// ini_set("display_errors", 1);
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

// check all data
if (
  (!isset($_POST['name']) || $_POST['name'] == "") ||
  (!isset($_POST['price']) || $_POST['price'] == "") ||
  (!isset($_FILES['image']))
) {
  http_response_code(400);
  echo json_encode([
    "status" => 400,
    "message" => "Invalid product information"
  ]);
  die;
}

// process file
$fname = $_FILES['image']['name'];
$ftmp = $_FILES['image']['tmp_name'];
$ftyp = $_FILES['image']['type'];
$fext = strtolower(substr($fname, strrpos($fname, '.')  + 1));

if ($fext == 'jpg' or $fext == 'jpeg' or $fext == 'png') {
  move_uploaded_file($ftmp, "../../uploads/" . $fname);
} else {
  http_response_code(400);
  echo json_encode([
    'status' => 400,
    'message' => 'Only jpg, jpeg, and png format is allowed'
  ]);
  die;
}

// set product info
$product->set([
  'name' => $_POST['name'],
  'price' => $_POST['price'],
  'image' => $fname,
  'entry_by' => User::getUser('id'),
  'entry_time' => date('Y-m-d H:i:s')
]);


// add product
$add_data_msg = $product->addNewProduct();

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
  "message" => "Product added successfully"
]);
