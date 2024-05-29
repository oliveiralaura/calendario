<?php
session_start();

require_once('back/dbconfig.php');

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$statusMsg = '';
$status = 'danger';

if (isset($_SESSION['id_cliente'])) {
  $event_id = $_SESSION['id_cliente'];


    $sql = "SELECT date, time_from, time_to, procedimentos.nome_procedimento, procedimentos.valor_procedimento 
    FROM events 
    INNER JOIN procedimentos ON events.procedimentos_id_procedimento = procedimentos.id_procedimento 
    WHERE events.clientes_id_cliente = ? ORDER BY date DESC;";
    
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
      while ($user = mysqli_fetch_array($result)) {
          $dados [] = array(
          'date' => $user['date'],
          'time_from' => $user['time_from'],
          'time_to' => $user['time_to'],
          'nome_procedimento' => $user['nome_procedimento'],
          'valor_procedimento' => $user['valor_procedimento']
           );
      };
  
}} else {
    echo "nada";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <nav class="nav-agendar">
      <div class="div-nav">
        <a href="#">
          <img src="./images/batom.png" id="img-logo" alt="">
        </a>
      </div>
      <div class="div-nav" id="menu">
        <a  class="a-nav-agendar" href="index.php">Sobre</a>
        <a  class="a-nav-agendar" href="index.php">Serviços</a>
        <a  class="a-nav-agendar" href="agendamentos.php">Meus agendamentos</a>
        <a  class="a-nav-agendar" href="index.php">Contato</a>
      </div>
    </nav>
    <div id="div-agen">
      <h1 id="h1-agen">MEUS AGENDAMENTOS</h1>
      

        <div id="div-fim">
       <section id="section-agen">
            <h4> Procedimentos</h4>
            <h5>Rua Rua Quincas Vieira, bairro Vila Dubus, número 930</h5>
       </section>
       <?php if (!empty($statusMsg)) { ?>
        <div class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></div>
    <?php } ?>
       <?php foreach ($dados as $dado): ?>     
       <p>
            Procedimento: <?php echo $dado['nome_procedimento']; ?><br>
            Data: <?php echo $dado['date']; ?><br>
            Horário de início: <?php echo $dado['time_from']; ?><br>
            Horário de término: <?php echo $dado['time_to']; ?><br>
            Valor: R$ <?php echo $dado['valor_procedimento']; ?><br>
        </p>
        <?php endforeach; ?>

        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ebbcd8" fill-opacity="1" d="M0,288L48,272C96,256,192,224,288,197.3C384,171,480,149,576,165.3C672,181,768,235,864,250.7C960,267,1056,245,1152,250.7C1248,256,1344,288,1392,304L1440,320L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
    </div>

    </body>
    </html>

    