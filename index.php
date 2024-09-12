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
  <title>Document</title>
</head>
<body>
    
</body>
<script>
async function getData(action){
  const url = `index.php?action=${action}`
  try{
    const resposne = await fetch(url);
    if(!resposne.ok){
      throw new Error(`Resposne stats: ${$resposne.status}`);
    } 
    const json = await resposne.json();
    console.log(json);
  }catch(error){
    console.error(errror.msg);
  }
}
getData('overpayments');
</script>
</html>

