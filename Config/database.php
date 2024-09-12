<?php

class Database{
  private $conn;
  private $host = "localhost";
  private $username = "root";
  private $password = "";
  private $db = "php_task";

  public function __construct(){
    $this->conn = new mysqli($this->host, $this->username, $this->password);

    if($this->conn->connect_error){
      die("Connection failed: ".$this->conn->connect_error);
    }

    $this->createDatabase();
    $this->conn->select_db($this->db);

    $this->setupCustomersTable();
    $this->setupInvoicesTable();
    $this->setupInvoiceItemsTable();
    $this->setupPaymentsTable();
  }

  private function createDatabase(){
    $sql = "CREATE DATABASE IF NOT EXISTS $this->db";
    $this->conn->query($sql);
    if($this->conn->error){
      echo "Error creating database: ".$this->conn->error."\n";
    }
  }

  private function setupCustomersTable() {
    $sql = "CREATE TABLE IF NOT EXISTS customers (
      id INT AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255),
      bank_account_number VARCHAR(30),
      nip VARCHAR(10),
      UNIQUE (name, bank_account_number, nip)
    )";
    $this->executeQuery($sql);
    
    $sql = "INSERT IGNORE INTO customers (name, bank_account_number, nip) VALUES 
      ('ABC Ltd.', '12345678901234567890123456', '1234567890'),
      ('XYZ Sp. z o.o.', '98765432109876543210987654', '0987654321')";
    $this->executeQuery($sql);
  }

  private function setupInvoicesTable() {
    $sql = "CREATE TABLE IF NOT EXISTS invoices (
      id INT AUTO_INCREMENT PRIMARY KEY,
      customer_id INT,
      number VARCHAR(255),
      issue_date date,
      due_date DATE,
      total_amount DECIMAL(10,2),
      FOREIGN KEY (customer_id) REFERENCES customers(id),
      UNIQUE (customer_id, number, issue_date, due_date)
    )";
    $this->executeQuery($sql);
    
    $sql = "INSERT IGNORE INTO invoices (customer_id, number, issue_date, due_date, total_amount) VALUES 
      (1, 'INV-001', '2023-01-01', '2023-01-15', 1000.00),
      (1, 'INV-002', '2023-01-05', '2023-01-20', 1500.00),
      (2, 'INV-003', '2023-01-01', '2023-01-05', 500.00)";
    $this->executeQuery($sql);
  }

  private function setupInvoiceItemsTable() {
    $sql = "CREATE TABLE IF NOT EXISTS invoice_items (
      id INT AUTO_INCREMENT PRIMARY KEY,
      invoice_id INT,
      product_name VARCHAR(255),
      qty INT,
      price DECIMAL(10,2),
      FOREIGN KEY (invoice_id) REFERENCES invoices(id),
      UNIQUE (invoice_id, product_name, qty, price)
    )";
    $this->executeQuery($sql);
    
    $sql = "INSERT IGNORE INTO invoice_items (invoice_id, product_name, qty, price) VALUES 
      (1, 'Produkt A', 5, 200.00),
      (1, 'Produkt B', 10, 150.00),
      (3, 'Produkt C', 1, 500.00)";
    $this->executeQuery($sql);
  }

  private function setupPaymentsTable() {
    $sql = "CREATE TABLE IF NOT EXISTS payments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        invoice_id INT,
        title VARCHAR(255),
        amount DECIMAL(10,2),
        payment_date DATE,
        payment_account_number VARCHAR(30),
      FOREIGN KEY (invoice_id) REFERENCES invoices(id),
      UNIQUE (invoice_id, title, amount, payment_date, payment_account_number)
    )";
    $this->executeQuery($sql);
    
    $sql = "INSERT IGNORE INTO payments (invoice_id, title, amount, payment_date, payment_account_number) VALUES 
      (1, 'Wpłata 1', 750.00, '2023-01-10', '12345678901234567890123456'),
      (1, 'Wpłata 2', 250.00, '2023-01-13', '12345678901234567890123456'),
      (2, 'Wpłata 3', 1000.00, '2023-01-06', '12345678901234567890123456'),
      (3, 'Wpłata 4', 600.00, '2023-01-03', '98765432109876543210987654')";
    $this->executeQuery($sql);
  }

  private function executeQuery($sql){
    $this->conn->query($sql);
    if($this->conn->error){
      echo "Error:  ".$sql." ".$this->conn->error."\n";
    }
  }

  public function getConnection(){
    return $this->conn;
  }
}