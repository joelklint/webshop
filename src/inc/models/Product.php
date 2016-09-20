<?php

class Product {
  private $id;
  private $name;
  private $description;
  private $price;

  public function __construct(Array $data) {
    $this->id = $data['ID'];
    $this->name = $data['NAME'];
    $this->description = $data['DESCRIPTION'];
    $this->price = $data['PRICE'];
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

  public function price() {
    return $this->price;
  }

}
