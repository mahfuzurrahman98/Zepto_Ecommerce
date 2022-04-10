<?php

namespace App;

use Firebase\JWT\JWT;
use \App\user\User;

class JWTToken {
  private static $key = "zepto98";
  private static $alg = "HS256";
  private static $issuer = "localhost";
  private static $audience = "all_users";

  public static function generateJWT($user_data) {
    $payload = [
      "iss" => self::$issuer,
      "iat" => time(),
      "nbf" => time() + 10,
      "exp" => time() + 3600,
      "aud" => self::$audience,
      "user_data" => [
        'id' => $user_data['Id'],
        'name' => $user_data['Name'],
        'username' => $user_data['Username'],
        'email' => $user_data['Email'],
        'is_admin' => $user_data['Is_Admin']
      ]
    ];
    return JWT::encode($payload, self::$key, self::$alg);
  }

  public static function validateToken($token) {
    if (trim($token) != '') {
      try {
        JWT::decode($token, self::$key, [self::$alg]);
        return "200";
      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }
  }

  public static function decodeData($token) {
    if (trim($token) != '') {
      try {
        $decoded = JWT::decode($token, self::$key, [self::$alg]);
        $user_data = $decoded->user_data;
        foreach ($user_data as $key => $data) {
          User::setUser($key, $data);
        }
      } catch (\Exception $e) {
        echo $e->getMessage();
      }
    }
  }
}
