<?php

class Invoice
{
  private $db;
  public function __construct($db){
    $this->db = $db;
  }

  public function getUnsettledInvoices($params){
    $query = 
      "SELECT
        i.number AS invoice_number,
        i.total_amount AS invoice_total,
        i.issue_date AS issue_date,
        i.due_date AS due_date,
        c.name AS customer_name
      FROM invoices i
      LEFT JOIN payments p ON i.id = p.invoice_id
      JOIN customers c ON i.customer_id = c.id
      WHERE p.id IS NULL 
        AND i.due_date < CURDATE()
      ";

    $conditions = [];
    $values = [];

    if(!empty($params['name'])){
      $conditions[] = "c.name LIKE ?";
      $values[] = "%".$params['name']."%";
    }
    if(!empty($params['invoice_number'])){
      $conditions[] = "i.number LIKE ?";
      $values[] = "%".$this->db->real_escape_string($params['invoice_number'])."%";
    }
    if(!empty($params['issue_date'])){
      $conditions[] = "i.issue_date LIKE ?";
      $values[] = "%".$params['issue_date']."%";
    }
    if(!empty($params['due_date'])){
      $conditions[] = "i.due_date LIKE ?";
      $values[] = "%".$this->db->real_escape_string($params['due_date'])."%";
    }
    if(!empty($conditions)){
      $query .= " AND " . implode(" AND ", $conditions);
    }


    $query .= " 
      ORDER BY i.due_date";

  $stmt = $this->db->prepare($query);
  if(!empty($values)){
    $types = str_repeat('s', count($values));
    $stmt->bind_param($types, ...$values);
  }
  $stmt->execute();
  $result = $stmt->get_result();

  $invocies = [];
  while($row = $result->fetch_assoc()){
    $invocies[] = $row;
  }

  return $invocies;
  }
}