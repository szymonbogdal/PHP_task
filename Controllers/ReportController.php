<?php
require_once __DIR__ . '/../models/Payment.php';

class ReportController
{
  private $payment;

  public function __construct($db){
    $this->payment = new Payment($db);
  }
}
