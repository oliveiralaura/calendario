<?php
session_start();
include_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Location: conclusao.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conclusão do Agendamento</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="oi">Conclusão do Agendamento</h1>
        <div class="wrapper">
            <div class="col-md-12">
                <div class="alert alert-success">O agendamento foi concluído com sucesso!</div>
            </div>
            <?php if(!empty($statusMsg)){ ?>
                <div class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
