<?php
require_once '../../back/dbconfig.php';



if (!isset($_SESSION['email']) || $_SESSION['user_level'] !== 'admin' && $_SESSION['user_level'] !== 'master') {
    header('Location: ../../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_service'])) {
        $id_service = $_POST['id_service'];

        $sql_delete_procedures = "DELETE FROM procedimentos WHERE servicos_id_servicos = ?";
        $stmt_procedures = $db->prepare($sql_delete_procedures);
        $stmt_procedures->bind_param('i', $id_service);
        
        if ($stmt_procedures->execute()) {
            $sql_delete = "DELETE FROM servicos WHERE id_servicos = ?";
            $stmt = $db->prepare($sql_delete);
            $stmt->bind_param('i', $id_service);

            if ($stmt->execute()) {
                header('Location: ../listcadastros/listservices.php?message=Serviço deletado com sucesso');
                exit();
            } else {
                echo 'Erro ao deletar serviço.';
            }

            $stmt->close();
        } else {
            echo 'Erro ao deletar procedimentos associados ao serviço.';
        }

        $stmt_procedures->close();
    }
} else {
    header('Location: ../listcadastros/listservices.php');
    exit();
}
?>
