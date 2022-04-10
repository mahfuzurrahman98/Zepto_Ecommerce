<?php

namespace App;

use PDO;

class DBConnection {
  private static $pdo;
  private static $user_name = "root";
  private static $password = "Password@9859";
  private static $host = "localhost";
  private static $db_name = "Zepto_Ecommerce";

  public static function connection() {
    if (!isset(self::$pdo)) {
      try {
        self::$pdo = new PDO(
          "mysql:host=" . self::$host . "; dbname=" . self::$db_name,
          self::$user_name,
          self::$password
        );
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (\PDOException $e) {
        return $e->getMessage();
      }
    }
    return self::$pdo;
  }

  public static function prepareStatement($sql) {
    return self::connection()->prepare($sql);
  }
}
