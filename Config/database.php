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


    if(!$this->tablesExist()){
      $this->setupCustomersTable();
      $this->setupInvoicesTable();
      $this->setupInvoiceItemsTable();
      $this->setupPaymentsTable();
    }
  }
  private function tablesExist() {
    $result = $this->conn->query("SHOW TABLES LIKE 'customers'");
    return $result && $result->num_rows > 0;
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
      ('XYZ Sp. z o.o.', '98765432109876543210987654', '0987654321'),
      ('DEF Corp.', '11223344556677889900112233', '1122334455'),
      ('GHI Services', '99887766554433221100998877', '5544332211'),
      ('JKL Enterprises', '55667788990011223344556677', '6677889900')";
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
      (2, 'INV-003', '2023-01-01', '2023-01-05', 500.00),
      (3, 'INV-004', '2023-02-01', '2023-02-15', 2000.00),
      (4, 'INV-005', '2023-02-05', '2023-02-20', 1200.00),
      (5, 'INV-006', '2023-02-10', '2023-02-25', 3000.00),
      (1, 'INV-007', '2023-03-01', '2023-03-15', 800.00),
      (2, 'INV-008', '2023-03-05', '2023-03-20', 1500.00),
      (3, 'INV-009', '2024-08-01', '2024-08-15', 2500.00),
      (4, 'INV-010', '2024-08-10', '2024-08-25', 1800.00),
      (5, 'INV-011', '2024-08-20', '2024-09-03', 3200.00),
      (1, 'INV-012', '2024-08-25', '2024-09-08', 1600.00),
      (2, 'INV-013', '2024-08-15', '2024-08-30', 3000.00),
      (4, 'INV-014', '2024-08-20', '2024-09-05', 2200.00),
      (4, 'INV-015', '2024-10-20', '2024-12-05', 2200.00)";
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
      (3, 'Produkt C', 1, 500.00),
      (4, 'Product D', 4, 500.00),
      (5, 'Product E', 6, 200.00),
      (6, 'Product F', 10, 300.00),
      (7, 'Product G', 2, 400.00),
      (8, 'Product H', 5, 300.00),
      (9, 'Product I', 5, 300.00),
      (9, 'Product J', 10, 100.00),
      (10, 'Product K', 3, 400.00),
      (10, 'Product L', 6, 100.00),
      (11, 'Product M', 8, 350.00),
      (11, 'Product N', 4, 150.00),
      (12, 'Product O', 2, 500.00),
      (12, 'Product P', 3, 200.00),
      (13, 'Product Q', 4, 500.00),
      (13, 'Product R', 5, 200.00),
      (14, 'Product S', 2, 800.00),
      (14, 'Product T', 3, 200.00)";
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
      (3, 'Wpłata 4', 600.00, '2023-01-03', '98765432109876543210987654'),
      (4, 'Payment 5', 1800.00, '2023-02-14', '11223344556677889900112233'), 
      (5, 'Payment 6', 1300.00, '2023-02-18', '99887766554433221100998877'), 
      (7, 'Payment 7', 400.00, '2023-03-10', '12345678901234567890123456'),
      (13, 'Payment INV-013 (1)', 2000.00, '2024-08-25', '98765432109876543210987654'),
      (13, 'Payment INV-013 (2)', 1200.00, '2024-08-28', '98765432109876543210987654'),
      (13, 'Payment INV-013 (3)', 100.00, '2024-08-30', '98765432109876543210987654'),
      (14, 'Payment INV-014 (1)', 1500.00, '2024-08-30', '99887766554433221100998877'),
      (14, 'Payment INV-014 (2)', 800.00, '2024-09-02', '99887766554433221100998877')";
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