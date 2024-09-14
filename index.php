<?php
require_once __DIR__ . '/Routes/web.php';

$action = $_GET['action'] ?? null;

if($action){
  $router = new Router();
  $router->dispatch($action);
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script type="module" src="Public/js/main.js"></script>
  <link rel="stylesheet" href="Public/css/style.css">
  <title>Reports</title>
</head>
<body>
  <nav>
    <div class="nav-body">
      <h1 class="nav-heading">Raports</h1>
      <div class="nav-options">
        <button class="nav-item nav-active" data-action="overpayments">Overpayments raport</button>
        <button class="nav-item" data-action="underpayments">Underpayments raport</button>
        <button class="nav-item" data-action="unsettledinvoices">Unsettled invoices raport</button>
      </div>
    </div>
  </nav>
  <div class="container">
    <div class="filters">
      <div class="filter-item">
        <label for="name">Client name</label>
        <input id="name" data-column="name">
      </div>
      <div class="filter-item">
        <label for="invoice-number">Invoice number</label>
        <input id="invoice-number"  data-column="invoice_number">
      </div>
      <div class="filter-item">
        <label for="issued-at">Issued at</label>
        <input id="issued-at"  data-column="issue_date">
      </div>
      <div class="filter-item">
        <label for="due-at">Due at</label>
        <input id="due-at"  data-column="due_date">
      </div>
    </div>
    <div class="error-msg">
      <p>Oops! Something went wrong. Please try refreshing the page.</p>
    </div>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>

          </tr>
        </thead>
        <tbody>
        
        </tbody>
      </table>
    </div>
    <div class="no-records-msg">
      <p>No records found.</p>
    </div>
  </div>
</body>
</html>

