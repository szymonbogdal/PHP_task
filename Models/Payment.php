<?php

class Payment
{
  private $db;
  public function __construct($db){
    $this->db = $db;
  }

  public function getOverpayments($params) {
    $query = 
      "SELECT 
        c.name AS customer_name,
        i.number AS invoice_number,
        i.total_amount AS invoice_total,
        i.issue_date AS issue_date,
        i.due_date AS due_date,
        SUM(p.amount) AS total_paid,
        (SUM(p.amount) - i.total_amount) AS overpayment_amount
      FROM payments p
      JOIN invoices i ON p.invoice_id = i.id
      JOIN customers c ON i.customer_id = c.id
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
      $query .= " WHERE " . implode(" AND ", $conditions);
    }

    $query .= " 
    GROUP BY i.id 
    HAVING overpayment_amount > 0 
    ORDER BY overpayment_amount DESC";

    $stmt = $this->db->prepare($query);
    if(!empty($values)){
      $types = str_repeat('s', count($values));
      $stmt->bind_param($types, ...$values);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $overpayments = [];
    while($row = $result->fetch_assoc()){
      $overpayments[] = $row;
    }

    return $overpayments;
  }

  public function getUnderpayments($params){
    $query = 
      "SELECT 
        c.name AS customer_name,
        i.number AS invoice_number,
        i.total_amount AS invoice_total,
        i.issue_date AS issue_date,
        i.due_date AS due_date,
        SUM(p.amount) AS total_paid,
        (i.total_amount - SUM(p.amount)) AS underpayment_amount
      FROM payments p
      JOIN invoices i ON p.invoice_id = i.id
      JOIN customers c ON i.customer_id = c.id
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
      $query .= " WHERE " . implode(" AND ", $conditions);
    }

    $query .= " 
      GROUP BY i.id 
      HAVING underpayment_amount > 0
      ORDER BY underpayment_amount DESC";

    $stmt = $this->db->prepare($query);
    if(!empty($values)){
      $types = str_repeat('s', count($values));
      $stmt->bind_param($types, ...$values);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $overpayments = [];
    while($row = $result->fetch_assoc()){
      $overpayments[] = $row;
    }

    return $overpayments;
    }
}