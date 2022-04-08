<?php

namespace App\user;

use App\DBConnection;
use \App\JWTToken;
use PDO;
use Exception;

class User {
  private $name;
  private $email;
  private $username;
  private $password;
  private $is_admin;
  private $registered_at;
  private static $user_info;

  public function set($data = array()) {
    if (array_key_exists('name', $data)) {
      $this->name = $data['name'];
    }
    if (array_key_exists('email', $data)) {
      $this->email = $data['email'];
    }
    if (array_key_exists('username', $data)) {
      $this->username = $data['username'];
    }
    if (array_key_exists('password', $data)) {
      $this->password = $data['password'];
    }
    if (array_key_exists('is_admin', $data)) {
      $this->is_admin = $data['is_admin'];
    }
    if (array_key_exists('registered_at', $data)) {
      $this->registered_at = $data['registered_at'];
    }
    if (array_key_exists('entryTime', $data)) {
      $this->entryTime = $data['entryTime'];
    }
  }

  public static function setUser($key, $val) {
    self::$user_info[$key] = $val;
  }

  public static function getUser($key) {
    return self::$user_info[$key];
  }

  public function login($username, $password) {
    try {
      $sql = "select * from User
        where (Username=:Username)";

      $stmt = DBConnection::prepareStatement($sql);
      $stmt->bindValue(':Username', $username);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      if (password_verify($password, $result['Password'])) {
        return $result;
      } else {
        return [];
      }
    } catch (Exception $e) {
      return "500";
    }
  }

  public function create($name, $email, $username, $password, $entryTime) {
    $sql = "select * from User
        where Username=:Username || Email=:Email";
    $stmt = DBConnection::prepareStatement($sql);
    $stmt->bindValue(':Username', $this->username);
    $stmt->bindValue(':Email', $this->email);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
      return false;
    }

    try {
      $sql = "insert into User(Name, Email, Username, Password, Registered_At, Is_Admin)
        values(:Name, :Email, :Username, :Password, :Registered_At, :Is_Admin)";
      $stmt = DBConnection::prepareStatement($sql);
      $stmt->bindValue(':Name', $name);
      $stmt->bindValue(':Email', $email);
      $stmt->bindValue(':Username', $username);
      $stmt->bindValue(':Password', password_hash($password, PASSWORD_DEFAULT));
      $stmt->bindValue(':Registered_At', $entryTime);
      $stmt->bindValue(':Is_Admin', 0);
      $stmt->execute();
      return "201";
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public static function authenticateUser($jwtoken) {
    $jwt_validation = JWTToken::validateToken($jwtoken);

    if ($jwt_validation != "200") {
      http_response_code(401);
      echo json_encode([
        "status" => 401,
        "message" => $jwt_validation
      ]);
      die;
    }

    // set data in user info
    JWTToken::decodeData($jwtoken);
  }
}
