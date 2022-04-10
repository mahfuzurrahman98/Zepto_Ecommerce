<?php

require '../../header.php';
require '../../vendor/autoload.php';

use \App\user\User;

$product = new \App\product\Product();

// check request
if ($_SERVER['REQUEST_METHOD'] != "GET") {
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

if (isset($_GET['name']) && $_GET['name'] != '') {
  $product_info = $product->getProductByName($_GET['name']);

  if (!is_array($product_info)) {
    http_response_code(500);
    echo json_encode([
      "status" => 500,
      "message" => $product_info
    ]);
    die;
  }

  if (empty($product_info)) {
    http_response_code(404);
    echo json_encode([
      "status" => 404,
      "message" => "The requested resource not found"
    ]);
    die;
  }

  http_response_code(200);
  echo json_encode([
    "status" => 200,
    "message" => "Product fetched successfully",
    "data" => $product_info
  ]);
  die;
}

if (isset($_GET['id']) && $_GET['id'] != '') {
  // get single product
  $product_info = $product->getProductById($_GET['id']);

  if (!is_array($product_info)) {
    http_response_code(500);
    echo json_encode([
      "status" => 500,
      "message" => $product_info
    ]);
    die;
  }

  if (empty($product_info)) {
    http_response_code(404);
    echo json_encode([
      "status" => 404,
      "message" => "The requested resource not found"
    ]);
    die;
  }

  http_response_code(200);
  echo json_encode([
    "status" => 200,
    "message" => "Product fetched successfully",
    "data" => $product_info
  ]);
  die;
} else {
  // get all product
  $products = $product->getAllProducts();

  if (!is_array($products)) {
    http_response_code(500);
    echo json_encode([
      "status" => 500,
      "message" => $products
    ]);
    die;
  }

  http_response_code(200);
  echo json_encode([
    "status" => 200,
    "message" => "Products fetched successfully",
    "data" => $products
  ]);
}
