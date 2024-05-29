<?php

  session_start();

  if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$status = $statusMsg = '';
if (!empty($_SESSION['status_response'])) {
    $status_response = $_SESSION['status_response']; 
    $status = $status_response['status'];
    $statusMsg = $status_response['status_msg'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizado</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
       
    </style>
</head>
<body>
    <nav>
      <div class="div-nav">
        <a href="#">
          <img src="./images/batom.png" id="img-logo" alt="">
        </a>
      </div>
      <div class="div-nav" id="menu">
        <a  class="a-nav" href="index.php">Home</a>
        
      </div>
    </nav>
    <div class="wave-header">
    
        

        <div id="div-finalizado">
        <?php if (!empty($statusMsg)) { ?>
        <div class="" id="finalizado"><?php echo $statusMsg; ?></div>
    <?php } ?>

        


        </div>

        <a id="a-finalizado" href="agendamentos.php"> Visualizar meus agendamentos</a>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#862f66" fill-opacity="1" d="M0,64L48,58.7C96,53,192,43,288,74.7C384,107,480,181,576,181.3C672,181,768,107,864,96C960,85,1056,139,1152,149.3C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
    </div>
  </body>
  </html>