<?php
    require_once '../../back/dbconfig.php';
  

    $nome = addslashes($_POST['nome']);

        
        if(!empty($nome) ){
        
                    $query = "INSERT INTO profissionais (id_profissional, nome_profissional) VALUES (null, '$nome')";
        
                    if($db->query($query)) {
                        header("Location: ../listcadastros/listprofissa.php");

                    } else {
                        echo "Erro ao inserir registro: " . $db->error;
                    }
                
        }else{
            echo 'Nada digitado';
        }
    

?>