<?php
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Invoice.php';

class ReportController
{
  private $payment;
  private $invoice;

  public function __construct($db){
    $this->payment = new Payment($db);
    $this->invoice = new Invoice($db);
  }

  public function showOverPayments(){
    return $this->payment->getOverpayments();
  }

  public function showUnderPayments(){
    return $this->payment->getUnderpayments();
  }

  public function showUnselttledInvoices(){
    return $this->invoice->getUnsettledInvoices();
  }
}
