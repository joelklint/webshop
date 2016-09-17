<?php

class User {
  private $id;
  private $username;
  private $address;
  private $salt;
  private $password_hash;

  public function __construct(Array $data) {
    $this->id = $data['ID'];
    $this->username = $data['USERNAME'];
    $this->address = $data['ADDRESS'];
    $this->salt = $data['SALT'];
    $this->password_hash = $data['PASSWORD_HASH'];
  }

  public function id() {
    return $this->id;
  }

  public function username() {
    return $this->username;
  }

  public function address() {
    return $this->address;
  }

  public function authenticate($password) {
    $salt = $this->salt;
    $attemt_hash = $this->hash($password, $salt);
    return $attemt_hash === $this->password_hash ? true : false;
  }

  private function hash($password, $salt) {
    return hash('sha256', $password . $salt);
  }

}
