<?php
session_start();

if (!isset($_SESSION['email'])) {
  header("Location: login.php");
    exit();
}
require_once 'back/dbconfig.php';

    $sql_service = "SELECT * FROM service;";
    $result_service = $db->query($sql_service);

    if (mysqli_num_rows($result_service) > 0) {
        while ($user = mysqli_fetch_array($result_service)) {
            $dados_services[] = array(
                'id' => $user['id'],
                'serviço' => $user['serviço'],
                'profissional' => $user['profissional']
            );
        }
    } else {
        echo 'Nenhum registro de usuários';
        exit;
    }

   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario-evento</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
       #div-img{
        position: relative;
    bottom: 40px;
       }
    </style>
</head>
<body>
    <nav>
      <div class="div-nav">
        <a href="#">
          <img src="./images/batom.png" id="img-logo" alt="">
        </a>
      </div>
      
      <div class="div-nav" id="menu">
        <a  class="a-nav" href="#sobre">Sobre</a>
        <a  class="a-nav" href="#serviços">Serviços</a>
        <a  class="a-nav" href="agendamentos.php">Meus agendamentos</a>
        <a  class="a-nav" href="#contato">Contato</a>
        <?php if ($_SESSION['user_level'] === 'admin' || $_SESSION['user_level'] === 'master'): ?>
    
        <a class="a-nav" href="admin/index.php">Sistema</a>
   
<?php endif; ?>

        <form action="admin/backadmin/sair.php" method="post" id="form-logout">
          <a  class="a-nav" href="#" onclick="document.getElementById('form-logout').submit();">Sair</a>
        </form>
      </div>
    </nav>
    <div class="wave-header">
        <div id="div-comeco">
        <h3> Seja bem vindo(a)!</h3>
        
        <h1>DESEJA ENCONTRAR SUA MELHOR VERSÃO?</h1>
        </div>
        <?php if(!empty($statusMsg)){ ?>
                <div class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></div>
            <?php } ?>
        <div id="icon-button">
        <a class="btn btn-primary" href="#serviços" role="button" style="width: 350px;">Agende um horário</a>
        <a href="#sobre" id="icon"><i class="bi bi-arrow-down-circle"></i></a>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#862f66" fill-opacity="1" d="M0,64L48,58.7C96,53,192,43,288,74.7C384,107,480,181,576,181.3C672,181,768,107,864,96C960,85,1056,139,1152,149.3C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
    </div>
    <div id="sobre">
        <section id="conteudo-sobre">
        <h3>SOBRE NÓS</h3>
        <section id="conteudo">
        <div class="div-conteudo" id="div-img">
          <img src="./images/luise.png" id="luise-img" alt="">
        </div>
        <div class="div-conteudo" id="texto-div">
          <p id="p-conteudo">
            O(nome salao) é um destino de beleza dedicado a proporcionar uma experiência excepcional aos nossos clientes. Nossa equipe altamente qualificada e apaixonada está comprometida em oferecer serviços de excelência, desde cortes de cabelo modernos até tratamentos faciais rejuvenescedores e manicures impecáveis.
          </p>
        </div>
      </section>
        </section>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ebbcd8" fill-opacity="1" d="M0,64L48,58.7C96,53,192,43,288,74.7C384,107,480,181,576,181.3C672,181,768,107,864,96C960,85,1056,139,1152,149.3C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
    </div>
    <div id="serviços">
    <h3 id="h3-serviço">SERVIÇOS</h3>
    <section id="section-serviço">
        <?php foreach ($dados_services as $servico): ?>
          <a class="a-serviço" href="agendar.php?servico=<?php echo urlencode($servico['serviço']); ?>">
              <div class="div-serviço">
                  <p style="display: none;"><?php echo $servico['id']; ?></p>
                  <p><?php echo $servico['serviço']; ?></p>
              </div>
          </a>
        <?php endforeach; ?>
    </section>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#862f66" fill-opacity="1" d="M0,256L40,250.7C80,245,160,235,240,218.7C320,203,400,181,480,192C560,203,640,245,720,261.3C800,277,880,267,960,250.7C1040,235,1120,213,1200,213.3C1280,213,1360,235,1400,245.3L1440,256L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"></path>
    </svg>
</div>



    <div id="contato">
      <section id="conteudo-contato">
      <h3>CONTATO</h3>

      <section id="conteudo">

      <div class="div-conteudo" id="img-contato">
        <img src="./images/luise-footer.png" id="luise-img" alt="">
      </div>
      <div class="div-conteudo" id="texto-div">
        <p id="p-contato">
          Localização: <br>
          Rua Principal, 123 <br>
          Bairro Centro <br>
          Cidade - Estado <br>
          CEP: XXXXX-XXX <br>
          
          Telefone: <br>
          (XX) XXXX-XXXX <br>
          
          E-mail: <br>
          contato@salãoglamour.com <br>
          Horário de Funcionamento: <br>
          Segunda a Sexta: 8h às 18h <br>
          Sábado: 8h às 15h <br>
          Domingo: Fechado        </p>

      </div>
    </section>
      </section>

      <div id="div-contato">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ebbcd8" fill-opacity="1" d="M0,64L48,58.7C96,53,192,43,288,74.7C384,107,480,181,576,181.3C672,181,768,107,864,96C960,85,1056,139,1152,149.3C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
      </div>
      </div>
</body>
</html>
