<?php
    require_once '../../back/dbconfig.php';


$nome = addslashes($_POST['nome']);
$profissa = addslashes($_POST['profissional']);

        
        if(!empty($nome) && !empty($profissa) ){
            echo 'aqui';
        
                    $query = "INSERT INTO servicos (id_servicos, nome_servico, profissionais_id_profissional) VALUES (null, '$nome', '$profissa')";
        
                    if($db->query($query)) {
                        header("Location: ../listcadastros/listservices.php");
                    } else {
                        echo "Erro ao inserir registro: " . $db->error;
                    }
                
        }else{
            echo 'Nada digitado';
        }
    

?>