<?php
// edit_procede.php
include '../../../back/dbconfig.php'; 

if (!isset($_SESSION['email']) || $_SESSION['user_level'] !== 'admin' && $_SESSION['user_level'] !== 'master') {
    header('Location: ../../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM procedimentos WHERE id_procedimento = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $procedimento = $result->fetch_assoc();
}

$sql_servicos = "SELECT id_servicos, nome_servico FROM servicos";
$result_servicos = $db->query($sql_servicos);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Procedimento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Procedimento</h2>
        <form action="../update/update_procede.php" method="post">
            <input type="hidden" name="id" value="<?php echo $procedimento['id_procedimento']; ?>">
            <div class="mb-3">
                <label for="nome_procedimento" class="form-label">Nome Procedimento</label>
                <input type="text" class="form-control" id="nome_procedimento" name="nome_procedimento" value="<?php echo $procedimento['nome_procedimento']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="duracao_procedimento" class="form-label">Duração</label>
                <input type="text" class="form-control" id="duracao_procedimento" name="duracao_procedimento" value="<?php echo $procedimento['duracao_procedimento']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="valor_procedimento" class="form-label">Valor</label>
                <input type="text" class="form-control" id="valor_procedimento" name="valor_procedimento" value="<?php echo $procedimento['valor_procedimento']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="servicos_id_servicos" class="form-label">Serviço</label>
                <select class="form-control" id="servicos_id_servicos" name="servicos_id_servicos" required>
                    <?php while ($servico = $result_servicos->fetch_assoc()): ?>
                        <option value="<?php echo $servico['id_servicos']; ?>" <?php if ($servico['id_servicos'] == $procedimento['servicos_id_servicos']) echo 'selected'; ?>>
                            <?php echo $servico['nome_servico']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
