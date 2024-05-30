<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
    <style>
        .hmmm{
            font-size: 15px;
        }
    </style>
</head>
<body id="body-login">
    
    <main id="main-login">
        <div id="div-img-login"> 
            <img src="./images/luise-login.png" id="img-login" alt="Login Image">
        </div>
        <div id="direita">
            <h1 class="h1-direita">BELEZA,</h1>
            <h1 class="h1-direita">GLAMOUR</h1>
            <h1 class="h1-direita">CONFIANÇA.</h1>
        </div>
        <div id="esquerda">
            <h3 class="h3-esquerda">Login</h3>
            <form id="form-login" action="/calendario/admin/backadmin/loginverifica.php" method="post">
                <div class="mb-3">
                    <label for="mail-login" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="mail-login" aria-describedby="emailHelp" name="mail-login">
                </div>
                <div class="mb-3">
                    <label for="senha-login" class="form-label">Senha:</label>
                    <input type="password" class="form-control" id="senha-login" name="senha-login">
                </div>
                <?php
                session_start();
                $mens = '';
                if (!empty($_SESSION['status_response'])) {
                    $status_response = $_SESSION['status_response']; 
                    $mens = $status_response['mens'];
                }
                if (!empty($mens)) {
                    echo '<p class="hmmm">' . $mens . '</p>';
                }
                ?>
                <button type="submit" id="button-login" class="btn btn-primary">Entrar</button>
            </form>
            <a href="cadastro.html" id="a-login"><h5 class="h-esquerda">Não tem login? Cadastre-se!</h5></a>
        </div>
    </main>
</body>
</html>
