<?php
// edit_profissa.php
include '../../../back/dbconfig.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    // Preparar a declaração
    $query = "SELECT * FROM profissionais WHERE id_profissional = ?";
    if ($stmt = $db->prepare($query)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $profissional = $result->fetch_assoc();
        } else {
            echo 'Profissional não encontrado.';
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
    <title>Edit Profissional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Profissional</h2>
        <form action="../update/update_profissa.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($profissional['id_profissional']); ?>">
            <div class="mb-3">
                <label for="profissional" class="form-label">Nome Profissional</label>
                <input type="text" class="form-control" id="profissional" name="profissional" value="<?php echo htmlspecialchars($profissional['nome_profissional']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
