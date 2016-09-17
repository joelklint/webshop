<?php

require_once __DIR__ . '/Product.php';
require_once __DIR__ . '/User.php';

# Class for making interaction with database easier
class DatabaseHelper {

  public function __construct(){}

  #Connect to database
  private function dbconnect() {
    $db = new SQLite3('/db/database.db');
    return $db;
  }

  #Base funtion for performing a query
  private function query($sql) {

    $db = $this->dbconnect();

    $res = $db->query($sql);

    $results = array();

    while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
      $results[] = $row;
    }

    return $results;
  }

  public function get_all_products() {
    $sql = "SELECT * FROM PRODUCTS";
    $results = $this->query($sql);
    $products = array();
    foreach ($results as $result) {
      $products[] = new Product($result);
    }
    return $products;
  }

  public function find_user_by_username($username) {
    $sql = "SELECT * FROM users where username = '" . $username . "'";
    $result = $this->query($sql);
    return count($result) == 0 ? null : new User($result[0]);
  }

  public function authenticate_with_username_and_psw($username, $password) {
    if ($user = $this->find_user_by_username($username)) {
      return $user->authenticate($password) === true ? $user : false;
    }
    else {
      return false;
    }
  }

  public function save_new_user_with_username_address_pswd($username, $address, $psw) {
    $salt = uniqid();
    $hash = $this->hash_password($psw, $salt);
    $sql = "INSERT INTO users (username, address, salt, password_hash) ";
    $sql .= "values('$username', '$address', '$salt', '$hash');";
    $db = $this->dbconnect();
    $success = $db->exec($sql);
    return $success;
  }

  private function hash_password($password, $salt) {
    return hash('sha256', $password . $salt);
  }

}
