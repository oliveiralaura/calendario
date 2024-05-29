<?php
// update_procede.php
include '../../../back/dbconfig.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome_procedimento = $_POST['nome_procedimento'];
    $duracao_procedimento = $_POST['duracao_procedimento'];
    $valor_procedimento = $_POST['valor_procedimento'];
    $servicos_id_servicos = $_POST['servicos_id_servicos'];

    $query = "UPDATE procedimentos SET nome_procedimento = ?, duracao_procedimento = ?, valor_procedimento = ?, servicos_id_servicos = ? WHERE id_procedimento = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssdii", $nome_procedimento, $duracao_procedimento, $valor_procedimento, $servicos_id_servicos, $id);
    $stmt->execute();

    header("Location: ../../listcadastros/listprocede.php?message=Procedimento atualizado com sucesso!");
    exit;
}
?>
