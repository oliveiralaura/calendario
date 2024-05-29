<?php
    require_once '../../back/dbconfig.php';

    if (!isset($_SESSION['email']) || ($_SESSION['user_level'] !== 'admin' && $_SESSION['user_level'] !== 'master')) {
        header('Location: ../../login.php');
        exit();
    }
    

    $sql_procede = "SELECT procedimentos.id_procedimento, procedimentos.nome_procedimento,  procedimentos.duracao_procedimento, procedimentos.valor_procedimento, servicos.nome_servico FROM `procedimentos` INNER join servicos on procedimentos.servicos_id_servicos = servicos.id_servicos;";
    $result_procede = $db->query($sql_procede);

    if (mysqli_num_rows($result_procede) > 0) {
        while ($user = mysqli_fetch_array($result_procede)) {
            $dados_procede[] = array(
                'id' => $user['id_procedimento'],
                'profissional' => $user['nome_procedimento'],
                'duração' => $user['duracao_procedimento'],
                'valor' => $user['valor_procedimento'],
                'serviço' => $user['nome_servico']
            );
        }
    } else {
        echo 'Nenhum registro de usuários';
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de serviços</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        header{

        }
        main{
            width: 100%;
            min-height: 500px;
            height: auto;
        }
    </style>
</head>
<body>
    <header>
    <div class="card">
  <div class="card-header">
    Olá, seja bem-vindo(a)
  </div>
  <div class="card-body">
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="listprocede.php">Procedimentos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="listprofissa.php" >Profissionais</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-disabled="true" href="listservices.php">Serviços</a>
        </li>
        <?php if ($_SESSION['user_level'] === 'master'): ?>
            <li class="nav-item">
                <a class="nav-link active" aria-disabled="true" href="listusers.php">Usuários</a>
            </li>
        <?php endif; ?>
        <li class="nav-item">
                                    <a class="nav-link active" aria-disabled="true" href="../../index.php">Site</a>
                                </li>
                                <li class="nav-item">
            <a class="nav-link active" aria-disabled="true" href="../mostrar/index.php">Calendário</a>
          </li>
        <li class="nav-item">
          <a class="nav-link active" aria-disabled="true" href="../backadmin/sair.php">Sair</a>
        </li>
      </ul>
      
    </div>
  </div>
</nav>
  </div>
  <div class="card-body">
  <a class="nav-link active" aria-current="page" href="../cadastraprocede.php">Cadastrar Procedimento</a>
  
  </div>
</div>
    </header>
    <main class="container">
    <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success">
                <?php echo $_GET['message']; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success">
        <?php echo $_GET['message']; ?>
    </div>
<?php endif; ?>

        <div class="row mt-4 rounded m-2 p-2 d-flex border">
            <div class="col">ID</div>
            <div class="col">Procedimento</div>
            <div class="col">Duração</div>
            <div class="col">Valor</div>
            <div class="col">Serviço</div>
            <div class="col"></div>
            <div class="col"></div>
        </div>
        <?php foreach($dados_procede as $retorno): ?>
            <div class="row mt-4 rounded m-2 p-2 d-flex border">
                <div class="col"><?php echo $retorno['id']; ?></div>
                <div class="col"><?php echo $retorno['profissional']; ?></div>
                <div class="col"><?php echo $retorno['duração']; ?></div>
                <div class="col"><?php echo $retorno['valor']; ?></div>
                <div class="col"><?php echo $retorno['serviço']; ?></div>
                <div class="col">
                    <a href="../backadmin/edit/edit_procede.php?id=<?php echo $retorno['id']; ?>" class="btn btn-success">Update</a>
                </div>

                <div class="col">
                    <form action="../backadmin/delete_procede.php" method="post" onsubmit="return confirm('Tem certeza que deseja excluir este procedimento?');">
                        <input type="hidden" name="id_procedimento" value="<?php echo $retorno['id']; ?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
