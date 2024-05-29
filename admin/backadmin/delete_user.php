<?php
require_once '../../back/dbconfig.php';

session_start();

if (!isset($_SESSION['email']) || $_SESSION['user_level'] !== 'admin' && $_SESSION['user_level'] !== 'master') {
    header('Location: ../../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_cliente'])) {
        $id_cliente = $_POST['id_cliente'];

        $sql_delete = "DELETE FROM clientes WHERE id_cliente = ?";
        $stmt = $db->prepare($sql_delete);
        $stmt->bind_param('i', $id_cliente);

        if ($stmt->execute()) {
            header('Location: ../listcadastros/listusers.php');
            exit();
        } else {
            echo 'Erro ao deletar usuário.';
        }

        $stmt->close();
    }
} else {
    header('Location: ../listcadastros/listusers.php');
    exit();
}
?>
