<?php
require_once('../back/dbconfig.php');

$query_procedimentos = "SELECT COUNT(*) AS total_procedimentos FROM procedimentos";
$result_procedimentos = mysqli_query($db, $query_procedimentos);
$row_procedimentos = mysqli_fetch_assoc($result_procedimentos);
$total_procedimentos = $row_procedimentos['total_procedimentos'];

$query_profissionais = "SELECT COUNT(*) AS total_profissionais FROM profissionais";
$result_profissionais = mysqli_query($db, $query_profissionais);
$row_profissionais = mysqli_fetch_assoc($result_profissionais);
$total_profissionais = $row_profissionais['total_profissionais'];

$query_servicos = "SELECT COUNT(*) AS total_servicos FROM servicos";
$result_servicos = mysqli_query($db, $query_servicos);
$row_servicos = mysqli_fetch_assoc($result_servicos);
$total_servicos = $row_servicos['total_servicos'];

$query_usuarios = "SELECT COUNT(*) AS total_usuarios FROM clientes";
$result_usuarios = mysqli_query($db, $query_usuarios);
$row_usuarios = mysqli_fetch_assoc($result_usuarios);
$total_usuarios = $row_usuarios['total_usuarios'];

date_default_timezone_set('America/Sao_Paulo');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard</title>
    <link rel="stylesheet" href="../public/css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="listcadastros/listprocede.php">Procedimentos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="listcadastros/listprofissa.php" >Profissionais</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-disabled="true" href="listcadastros/listservices.php">Serviços</a>
        </li>
        <?php if ($_SESSION['user_level'] === 'master'): ?>
          <li class="nav-item">
              <a class="nav-link active" aria-disabled="true" href="listcadastros/listusers.php">Usuários</a>
          </li>
        <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link active" aria-disabled="true" href="../index.php">Site</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-disabled="true" href="mostrar/index.php">Calendário</a>
          </li>
        <li class="nav-item">
          <a class="nav-link active" aria-disabled="true" href="backadmin/sair.php">Sair</a>
        </li>
      </ul>
      
    </div>
  </div>
</nav>
        <div class="row"><h4>Olá <?php echo $_SESSION['nome_cliente'].' - '.date('d/m/Y');?></h4>
        </div>
    </header>
    <main class="container border border-1 ">
        <div class="row m-4">
            <div class="col mb-3">
                <div class="card">
                    <div class="card-header">
                      Procedimentos
                    </div>
                    <div class="card-body">
                      <blockquote class="blockquote mb-0">
                        <p><?php echo $total_procedimentos; ?></p>
                      </blockquote>
                    </div>
                  </div>
            </div>
            <div class="col mb-3">
                <div class="card">
                    <div class="card-header">
                      Profissionais
                    </div>
                    <div class="card-body">
                      <blockquote class="blockquote mb-0">
                        <p><?php echo $total_profissionais; ?></p>
                      </blockquote>
                    </div>
                  </div>
            </div>
            <div class="col mb-3">
                <div class="card">
                    <div class="card-header">
                      Serviços
                    </div>
                    <div class="card-body">
                      <blockquote class="blockquote mb-0">
                        <p><?php echo $total_servicos; ?></p>
                      </blockquote>
                    </div>
                  </div>
            </div>
            <div class="col mb-3">
                <div class="card">
                    <div class="card-header">
                      Usuários
                    </div>
                    <div class="card-body">
                      <blockquote class="blockquote mb-0">
                        <p><?php echo $total_usuarios; ?></p>
                      </blockquote>
                    </div>
                  </div>
            </div>
        </div>
        <div class="row m-4">
            <div class="col">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </main>
    <script>
        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Procedimentos', 'Profissionais', 'Serviços', 'Usuários'],
                datasets: [{
                    label: 'Totais',
                    data: [<?php echo $total_procedimentos; ?>, <?php echo $total_profissionais; ?>, <?php echo $total_servicos; ?>, <?php echo $total_usuarios; ?>],
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545'],
                    borderColor: ['#007bff', '#28a745', '#ffc107', '#dc3545'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
