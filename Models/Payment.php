<?php

class Payment
{
  private $db;
  public function __construct($db){
    $this->db = $db;
  }
}