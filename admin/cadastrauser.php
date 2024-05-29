<?php
session_start();

if (!isset($_SESSION['email']) || ($_SESSION['user_level'] !== 'admin' && $_SESSION['user_level'] !== 'master')) {
    header('Location: ../login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Cadastro</title>
    <style>
        .espaco{
    margin: 10px 0px 0px 0px;
}
    </style>
</head>
<body id="body-login">
    <main id="main-login">
        <div id="div-login1" >
            <form action="/calendario/admin/backadmin/cadastrouser.php" class="form-login" method="post">
                <h3>Novo cadastro</h3>
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control">
                <label for="txtsobrenome" class="form-label">Sobrenome:</label>
                <input type="text" name="txtsobrenome" id="txtsobrenome" class="form-control">
                <label for="txttelefone" class="form-label">Telefone:</label>
                <input type="text" name="txttelefone" id="txttelefone" class="form-control">
                <label for="txtemail" class="form-label">Email:</label>
                <input type="email" class="form-control" id="txtemail" name="txtemail">
                <div class="input-group mb-3 espaco">
                        <span class="input-group-text">Senha:</span>
                        <input type="password" name="txtsenha" class="form-control" id="txtsenha">
                        <span class="input-group-text">Repetir senha:</span>
                        <input type="password" name="txtrepetirsenha" id="txtrepetirsenha" class="form-control">
                </div>
                <button type="submit" class="btn btn-danger" name="cadastra" id="senha-cadastro">
                      Finalizar cadastro 
                </button>
            </form>
        </div>
    </main>
</body>
</html>