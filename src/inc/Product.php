<?php

class Product {
  private $id;
  private $name;
  private $description;

  public function __construct(Array $data) {
    $this->id = $data['ID'];
    $this->name = $data['NAME'];
    $this->description = $data['DESCRIPTION'];
  }

  public function id() {
    return $this->id;
  }

  public function name() {
    return $this->name;
  }

  public function description() {
    return $this->description;
  }

}
