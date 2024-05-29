<?php
require_once '../../back/dbconfig.php';



if (!isset($_SESSION['email']) || $_SESSION['user_level'] !== 'admin' && $_SESSION['user_level'] !== 'master') {
    header('Location: ../../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_procedimento'])) {
        $id_procedimento = $_POST['id_procedimento'];

        $sql_delete = "DELETE FROM procedimentos WHERE id_procedimento = ?";
        $stmt = $db->prepare($sql_delete);
        $stmt->bind_param('i', $id_procedimento);

        if ($stmt->execute()) {
            header('Location: ../listcadastros/listprocede.php');
            exit();
        } else {
            echo 'Erro ao deletar procedimento.';
        }

        $stmt->close();
    }
} else {
    header('Location: ../listcadastros/listprocede.php');
    exit();
}
?>
