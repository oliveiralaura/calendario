<?php
require_once '../../back/dbconfig.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_profissional']) && is_numeric($_POST['id_profissional'])) {
        $id_profissional = (int) $_POST['id_profissional'];  

        $db->begin_transaction();

        try {
            $sql_delete_services = "DELETE FROM servicos WHERE profissionais_id_profissional = ?";
            $stmt_services = $db->prepare($sql_delete_services);
            if ($stmt_services) {
                $stmt_services->bind_param('i', $id_profissional);
                $stmt_services->execute();
                $stmt_services->close();
            } else {
                throw new Exception('Erro ao preparar a declaração para deletar serviços.');
            }

            $sql_delete_professional = "DELETE FROM profissionais WHERE id_profissional = ?";
            $stmt_professional = $db->prepare($sql_delete_professional);
            if ($stmt_professional) {
                $stmt_professional->bind_param('i', $id_profissional);
                $stmt_professional->execute();
                $stmt_professional->close();
            } else {
                throw new Exception('Erro ao preparar a declaração para deletar profissional.');
            }

            $db->commit();

            header('Location: ../listcadastros/listprofissa.php?message=Profissional deletado com sucesso');
            exit();
        } catch (Exception $e) {
            $db->rollback();
            header('Location: ../listcadastros/listprofissa.php?error=' . urlencode($e->getMessage()));
            exit();
        }
    } else {
        header('Location: ../listcadastros/listprofissa.php?error=ID do profissional inválido.');
        exit();
    }
} else {
    header('Location: listcadastros/listprofissa.php');
    exit();
}
?>
