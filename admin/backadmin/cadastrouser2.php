<?php

require_once '../../back/dbconfig.php';


$nome = addslashes($_POST['nome']);
$sobrenome = addslashes($_POST['sobrenome']);
$telefone = addslashes($_POST['telefone']);
$email = addslashes($_POST['email']);
$senha = addslashes($_POST['senha']);
$senha_repetida = addslashes($_POST['repetesenha']);


    if(!empty($nome) && !empty($sobrenome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($senha_repetida)){

        if ($senha === $senha_repetida) {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $query = "INSERT INTO clientes (`id_cliente`, `nome_cliente`, `telefone_cliente`, `sobrenome_cliente`, `email_cliente`, `senha_cliente`) VALUES (null, '$nome', '$telefone', '$sobrenome', '$email', '$senha_hash')";

            if($db->query($query)) {
                header("Location: ../listcadastros/listusers.php");
            } else {
                echo "Erro ao inserir registro: " . $db->error;
            }
        } else {
            echo "As senhas não coincidem!";
        }
    }


?>