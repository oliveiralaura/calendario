<?php
// edit_user.php
include '../../../back/dbconfig.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    // Preparar a declaração
    $query = "SELECT * FROM clientes WHERE id_cliente = ?";
    if ($stmt = $db->prepare($query)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
        } else {
            echo 'Usuário não encontrado.';
            exit();
        }

        $stmt->close();
    } else {
        echo 'Erro ao preparar a consulta.';
        exit();
    }
} else {
    echo 'ID inválido.';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit User</h2>
        <form action="../update/update_user.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id_cliente']); ?>">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome_cliente']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="sobrenome" class="form-label">Sobrenome</label>
                <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?php echo htmlspecialchars($user['sobrenome_cliente']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo htmlspecialchars($user['telefone_cliente']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email_cliente']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" value="<?php echo htmlspecialchars($user['senha_cliente']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="user_level" class="form-label">Nível de Acesso</label>
                <select class="form-select" id="user_level" name="user_level" required>
                    <option value="admin" <?php echo ($user['user_level'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="master" <?php echo ($user['user_level'] == 'master') ? 'selected' : ''; ?>>Master</option>
                    <option value="master" <?php echo ($user['user_level'] == 'visitor') ? 'selected' : ''; ?>>Visitante</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
