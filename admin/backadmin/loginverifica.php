<?php
    require_once('../../back/dbconfig.php');


     $email = $_POST['mail-login'];
     $senha = $_POST['senha-login'];

        if(!empty($email) && !empty($senha)) {
           
    
            $query = "SELECT * FROM clientes WHERE email_cliente='$email'";
            $result = $db->query($query);
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id_cliente = $row['id_cliente'];
                $nome_cliente = $row['nome_cliente'];
                $sobrenome_cliente = $row['sobrenome_cliente'];
                $user_level = $row['user_level'];
                $senha_hash = $row['senha_cliente'];
    
                if (password_verify($senha, $senha_hash)) {
                    session_start();
                    $_SESSION['email'] = $email;
                    $_SESSION['id_cliente'] = $id_cliente;
                    $_SESSION['nome_cliente'] = $nome_cliente;
                    $_SESSION['sobrenome_cliente'] = $sobrenome_cliente;
                    $_SESSION['user_level'] = $user_level;

                    if ($user_level === 'admin' || $user_level === 'master') {
                        header("Location: ../index.php");
                    } else {
                        header("Location: ../../index.php");
                    }
                    exit(); 
                } else {
                    echo "Email ou senha incorretas.";
                }

            } else {
                echo "Email não encontrada.";
            }
        }
    


?>