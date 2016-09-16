<?php

require_once __DIR__ . '/Product.php';

# Class for making interaction with database easier
class DatabaseHelper {

  public function __construct(){}

  #Connect to database
  private function dbconnect() {
    $db = new SQLite3(__DIR__ . '/database.db');
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

}
