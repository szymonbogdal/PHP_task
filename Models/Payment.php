<?php

class Payment
{
  private $db;
  public function __construct($db){
    $this->db = $db;
  }

  public function getOverpayments(){
    $query = 
      "SELECT 
        c.name AS customer_name,
        i.number AS invoice_number,
        i.total_amount AS invoice_total,
        SUM(p.amount) AS total_paid,
        (SUM(p.amount) - i.total_amount) AS overpayment_amount
      FROM payments p
      JOIN invoices i ON p.invoice_id = i.id
      JOIN customers c ON i.customer_id = c.id
      GROUP BY i.id
      HAVING overpayment_amount > 0
      ORDER BY overpayment_amount DESC";

    $result = $this->db->query($query);
    $overpayments = [];
    while ($row = $result->fetch_assoc()) {
        $overpayments[] = $row;
    }

    return $overpayments;
  }
}