<?php

class Invoice
{
  private $db;
  public function __construct($db){
    $this->db = $db;
  }

  public function getUnsettledInvoices(){
    $query = 
      "SELECT
        i.number AS invoice_number,
        i.total_amount AS invoice_total,
        c.name AS customer_name
      FROM invoices i
      LEFT JOIN payments p ON i.id = p.id
      JOIN customers c ON i.customer_id = c.id
      WHERE p.id IS NULL 
        AND i.due_date < CURDATE()
      ORDER BY i.due_date
      ";

    $result = $this->db->query($query);
    $invoices = [];
    while ($row = $result->fetch_assoc()){
        $invoices[] = $row;
    }

    return $invoices;
  }
}