<?php
// update_user.php
include '../../../back/dbconfig.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $user_level = $_POST['user_level'];

    $query = "UPDATE clientes SET nome_cliente = ?, sobrenome_cliente = ?, telefone_cliente = ?, email_cliente = ?, senha_cliente = ?, user_level = ? WHERE id_cliente = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$nome, $sobrenome, $telefone, $email, $senha, $user_level, $id]);

    header("Location: ../../listcadastros/listusers.php?message=Usuário atualizado com sucesso!");
    exit;
}
?>
