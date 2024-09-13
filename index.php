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
        <tr>
          <td>Szymon</td>
          <td>6000</td>
          <td>2024-01-15</td>
          <td>2024-02-15</td>
          <td>$1500</td>
        </tr>
        <tr>
          <td>Melissa</td>
          <td>5150</td>
          <td>2024-02-01</td>
          <td>2024-03-01</td>
          <td>$1200</td>
        </tr>
        <tr>
          <td>John</td>
          <td>7001</td>
          <td>2024-03-10</td>
          <td>2024-04-10</td>
          <td>$1800</td>
        </tr>
        <tr>
          <td>Anna</td>
          <td>8202</td>
          <td>2024-04-05</td>
          <td>2024-05-05</td>
          <td>$2200</td>
        </tr>
        <tr>
          <td>James</td>
          <td>9303</td>
          <td>2024-05-20</td>
          <td>2024-06-20</td>
          <td>$2500</td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>

