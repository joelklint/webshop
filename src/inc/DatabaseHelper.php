<?php

require_once __DIR__ . '/models/Product.php';
require_once __DIR__ . '/models/User.php';

# Class for making interaction with database easier
class DatabaseHelper {

  public function __construct(){}

  #Connect to database
  private function dbconnect() {
    $db = new SQLite3('/db/database.db');
    return $db;
  }

  private function prepare($sql) {
    $db = $this->dbconnect();
    $statement = $db->prepare($sql);
    return $statement;
  }

  private function get_result_from_prep_statement_as_array($statement) {
    $result = $statement->execute();
    $results = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $results[] = $row;
    }
    return $results;
  }

  private function exec_statement_and_get_boolean_response($statement) {
    $success = $statement->execute();
    return $success ? true : false;
  }

  #Gets all products from database and returns them as an array of Product models
  public function get_all_products() {
    $stmt = $this->prepare('SELECT * FROM products');
    $results = $this->get_result_from_prep_statement_as_array($stmt);
    $products = array();
    foreach ($results as $result) {
      $products[] = new Product($result);
    }
    return $products;
  }

  #Returns one product object or null if it does not exist
  public function get_product_with_id($product_id) {
    $stmt = $this->prepare('SELECT * FROM products WHERE ID = :id');
    $stmt->bindValue(':id', $product_id, SQLITE3_INTEGER);
    $results = $this->get_result_from_prep_statement_as_array($stmt);
    return count($results) == 0 ? null : new Product($results[0]);
  }

  #Returns an array of product objects or null if none of them exists
  public function get_products_with_id_numbers($id_numbers) {
    $products = array();
    foreach($id_numbers as $id) {
      $product = $this->get_product_with_id($id);
      if($product) {
        $products[] = $this->get_product_with_id($id);
      }
    }
    return $products;
  }

  public function find_user_by_username($username) {
    $stmt = $this->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $results = $this->get_result_from_prep_statement_as_array($stmt);
    return count($results) == 0 ? null : new User($results[0]);
  }

  public function authenticate_with_username_and_psw($username, $password) {
    if ($user = $this->find_user_by_username($username)) {
      return $user->authenticate($password) === true ? $user : false;
    }
    else {
      return false;
    }
  }

  #Attemts to store a user in database.
  #Returns true if success, otherwise false.
  public function save_new_user_with_username_address_pswd($username, $address, $psw) {
    $salt = uniqid();
    $hash = $this->hash_password($psw, $salt);
    $sql = 'INSERT INTO users (username, address, salt, password_hash) values(:username, :address, :salt, :hash)';
    $stmt = $this->prepare($sql);
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':address', $address, SQLITE3_TEXT);
    $stmt->bindValue(':salt', $salt, SQLITE3_TEXT);
    $stmt->bindValue(':hash', $hash, SQLITE3_TEXT);
    return $this->exec_statement_and_get_boolean_response($stmt);
  }

  private function hash_password($password, $salt) {
    return hash('sha256', $password . $salt);
  }

}
