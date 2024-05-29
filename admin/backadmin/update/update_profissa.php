<?php
// update_profissa.php
include '../../../back/dbconfig.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $profissional = $_POST['profissional'];

    $query = "UPDATE profissionais SET nome_profissional = ? WHERE id_profissional = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$profissional, $id]);

    header("Location: ../../listcadastros/listprofissa.php?message=Profissional atualizado com sucesso!");
    exit;
}
?>
