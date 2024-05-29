<?php
include '../../../back/dbconfig.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $serviço = $_POST['serviço'];
    $profissional = $_POST['profissional'];

    $query = "UPDATE servicos SET nome_servico = ?, profissionais_id_profissional = ? WHERE id_servicos = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$serviço, $profissional, $id]);

    header("Location: ../../listcadastros/listservices.php?message=Serviço atualizado com sucesso!");
    exit;
}
?>
