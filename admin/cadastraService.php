<?php
  require_once '../back/dbconfig.php';
  session_start();

if (!isset($_SESSION['email']) || $_SESSION['user_level'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

  $sql_usuarios = "SELECT * from profissionais;";
  $result_usuarios = $db->query($sql_usuarios);

  if (mysqli_num_rows($result_usuarios) > 0) {
      while ($user = mysqli_fetch_array($result_usuarios)) {
          $dados_usuarios[] = array(
              'id' => $user['id_profissional'],
              'profissional' => $user['nome_profissional']
          );
      }
  } else {
      echo 'Nenhum registro de serviço';
      exit;
  }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadatsro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <form action="/calendario/admin/backadmin/cadastroServico.php" method="post">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nome do serviço</label>
            <input type="text" class="form-control" id="nome" aria-describedby="emailHelp" name="nome">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Profissional</label>
            <select class="form-select form-select-lg mb-3" aria-label="Large select example" id="profissional" name="profissional">
              <option selected disabled>Escolha uma opção</option>
            <?php foreach ($dados_usuarios as $retorno): ?>
              <option value="<?php echo $retorno['id']; ?>"><?php echo $retorno['profissional']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Cadastro</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>