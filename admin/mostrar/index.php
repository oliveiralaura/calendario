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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: #fff; /* Cor de fundo da barra de navegação */
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #000!important; /* Cor dos links na barra de navegação */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Olá, seja bem-vindo(a)</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../listcadastros/listprocede.php">Procedimentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../listcadastros/listprofissa.php">Profissionais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../listcadastros/listservices.php">Serviços</a>
                    </li>
                    <?php if ($_SESSION['user_level'] === 'master'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../listcadastros/listusers.php">Usuários</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.php">Site</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../mostrar/index.php">Calendário</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../backadmin/sair.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
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

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
