<?php

include '../../../back/dbconfig.php'; 

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM service WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $service = $result->fetch_assoc();
    } else {
        echo 'Serviço não encontrado.';
        exit();
    }

    $stmt->close();
} else {
    echo 'ID inválido.';
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Service</h2>
        <form action="../update/update_service.php" method="post">
            <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
            <div class="mb-3">
                <label for="serviço" class="form-label">Serviço</label>
                <input type="text" class="form-control" id="serviço" name="serviço" value="<?php echo $service['serviço']; ?>" required>
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
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
