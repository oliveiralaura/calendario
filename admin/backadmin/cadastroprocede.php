<?php
require_once '../../back/dbconfig.php';


$nome = addslashes($_POST['nome']);

$profissa = addslashes($_POST['profissional']);
$dura = addslashes($_POST['dura']);
$vale = addslashes($_POST['vale']);

if (!empty($nome)) {

    $sql_conflito = "SELECT * FROM procedimentos WHERE nome_procedimento LIKE '$nome';";
    $result_conflito = $db->query($sql_conflito);

    if (mysqli_num_rows($result_conflito) > 0) {
        echo 'Já existe um procedimento com esse nome.';
    } else {
        $query = "INSERT INTO `procedimentos`(`id_procedimento`, `nome_procedimento`, `duracao_procedimento`, `valor_procedimento`, `servicos_id_servicos`) VALUES (null, '$nome', '$dura', '$vale', '$profissa')";

        if ($db->query($query)) {
            header("Location: ../listcadastros/listprocede.php");

        } else {
            echo "Erro ao inserir registro: " . $db->error;
        }
    }
} else {
    echo 'Nada digitado';
}
?>
