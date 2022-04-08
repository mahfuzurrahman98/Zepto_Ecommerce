<?php

namespace App\product;

use App\DBConnection;
use Exception;

class Product {

  private $name;
  private $price;
  private $image;
  private $entry_by;
  private $entry_time;

  public function set($data) {
    if (array_key_exists('name', $data)) {
      $this->name = $data['name'];
    }
    if (array_key_exists('price', $data)) {
      $this->price = $data['price'];
    }
    if (array_key_exists('image', $data) && $data['image'] != '') {
      $this->image = $data['image'];
    }
    if (array_key_exists('entry_by', $data)) {
      $this->entry_by = $data['entry_by'];
    }
    if (array_key_exists('entry_time', $data)) {
      $this->entry_time = $data['entry_time'];
    }
  }

  public function addNewProduct() {
    try {
      $sql = "insert into Product(Name, Price, Image, Entry_By, Entry_Time) 
        values (:Name, :Price, :Image, :Entry_By, :Entry_Time)";
      $stmt = DBConnection::prepareStatement($sql);
      $stmt->bindValue(':Name', $this->name);
      $stmt->bindValue(':Price', $this->price);
      $stmt->bindValue(':Image', $this->image);
      $stmt->bindValue(':Entry_By', $this->entry_by);
      $stmt->bindValue(':Entry_Time', $this->entry_time);
      $stmt->execute();
      return true;
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public function getAllProducts() {
    try {
      $sql = "select Product.*, User.Username from Product 
        join User on Product.Entry_By = User.Id
        order by Product.Id desc";

      $stmt = DBConnection::prepareStatement($sql);
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public function getProductById($id) {
    try {
      $sql = "select Product.*, User.Username from Product 
        join User on Product.Entry_By = User.Id
        where Product.Id = :ID";

      $stmt = DBConnection::prepareStatement($sql);
      $stmt->bindValue(':ID', $id);
      $stmt->execute();
      return $stmt->fetch(\PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public function getProductByName($name) {
    try {
      $sql = "select Product.*, User.Username from Product 
        join User on Product.Entry_By = User.Id
        where Product.Name like :Name";

      $stmt = DBConnection::prepareStatement($sql);
      $stmt->bindValue(':Name', "%$name%");
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public function deleteProductById($id) {
    try {
      $sql = "delete from Product where Product.Id = :ID";
      $stmt = DBConnection::prepareStatement($sql);
      $stmt->bindValue(':ID', $id);
      $stmt->execute();
      return "200";
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public function updateProductById($id) {
    try {
      $sql = "update Product set 
        Name = :Name,
        Price = :Price,
        Image = :Image
        where Product.Id = :ID";

      $stmt = DBConnection::prepareStatement($sql);
      $stmt->bindValue(':Name', $this->name);
      $stmt->bindValue(':Price', $this->price);
      $stmt->bindValue(':Image', $this->image);
      $stmt->bindValue(':ID', $id);
      $stmt->execute();
      return "200";
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }
}
