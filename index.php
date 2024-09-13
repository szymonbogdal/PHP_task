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
        <input id="name">
      </div>
      <div class="filter-item">
        <label for="invoice-number">Invoice number</label>
        <input id="invoice-number">
      </div>
      <div class="filter-item">
        <label for="issued-at">Issued at</label>
        <input id="issued-at">
      </div>
      <div class="filter-item">
        <label for="due-at">Due at</label>
        <input id="due-at">
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th>Client name</th>
          <th>Invoice number</th>
          <th>Issued at</th>
          <th>Due at</th>
          <th>Full amount</th>
        </tr>
      </thead>
      <tbody>
       
      </tbody>
    </table>
    <div class="no-records-msg">
      <p>No records found.</p>
    </div>
  </div>
</body>
</html>

