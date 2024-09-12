<?php
require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Controllers/ReportController.php';
class Router
{
  private $controller;
  private $routes = [];

  public function __construct(){
    $db = (new Database())->getConnection();
    $this->controller = new ReportController($db);
    $this->routes = [
      "overpayments" => "showOverPayments"
    ];
  }

  public function dispatch($action) {
    header('Content-Type: application/json');

    if(array_key_exists($action, $this->routes)){
      $method = $this->routes[$action];
      if(method_exists($this->controller, $method)){
        $result = $this->controller->$method();
        echo json_encode($result);
      }else{
        echo json_encode(["error" => "Method $method does not exist"]);
      }
    }else{
      echo json_encode(["error" => "Action $action is not defined"]);
    }
  }
}
