<?php
session_start();
require_once('back/dbconfig.php');

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['servico'])) {
    $servico_nome = urldecode($_GET['servico']);    
    $sql_procedimentos = "SELECT procedimentos.id_procedimento, procedimentos.nome_procedimento, procedimentos.duracao_procedimento, procedimentos.valor_procedimento, servicos.nome_servico 
                          FROM procedimentos 
                          INNER JOIN servicos ON procedimentos.servicos_id_servicos = servicos.id_servicos 
                          WHERE nome_servico = '$servico_nome'";
    $result_procedimentos = $db->query($sql_procedimentos);
}

include_once 'back/config.php';

$status = $statusMsg = '';
if (!empty($_SESSION['status_response'])) {
    $status_response = $_SESSION['status_response']; 
    $status = $status_response['status'];
    $statusMsg = $status_response['status_msg'];
}

$postData = array(); 
if (!empty($_SESSION['postData'])) {
    $postData = $_SESSION['postData'];
    unset($_SESSION['postData']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        #form-agendar{
    width: 50%;
    position: absolute;
    top: 200px;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    z-index: 1;
    color: #ebbcd8;
}
#time_toooo, #data, #procedimento, #time_from{
    width: 250px!important;
}

#time_from{
    position: relative;
    left: -15px;
}
    </style>
</head>
<body>
    <nav class="nav-agendar">
        <div class="div-nav">
            <a href="#">
                <img src="./images/batom.png" id="img-logo" alt="">
            </a>
        </div>
        <div class="div-nav" id="menu">
            <a class="a-nav-agendar" href="index.php">Home</a>
            <form action="admin/backadmin/sair.php" method="post" id="form-logout">
          <a  class="a-nav" href="#" onclick="document.getElementById('form-logout').submit();">Sair</a>
        </form>
        </div>
    </nav>
    
    <div class="wave-header-agendar">
        <h1 id="h1-agendar">AGENDE AGORA O SEU HORÁRIO:</h1>
        <form id="form-agendar" action="back/addEvent.php" method="post" name="form-agendar">
            <div class="mb-3">
                <label for="procedimento" class="form-label">Procedimento:</label>
                <select name="procedimento" class="form-select" id="procedimento" required onchange="popularInputs()">
                    <option selected disabled>Selecione um procedimento</option>
                    <?php
                    if ($result_procedimentos->num_rows > 0) {
                        while ($procedimento = $result_procedimentos->fetch_assoc()) {
                            echo '<option value="' . $procedimento['id_procedimento'] . '|' . $procedimento['duracao_procedimento'] . ' ">' . $procedimento['nome_procedimento'] . ' - R$' . $procedimento['valor_procedimento'] . ' - Duração: ' . $procedimento['duracao_procedimento'] . '</option>';
                        }
                    } else {
                        echo '<option disabled>Nenhum procedimento encontrado para o serviço de manicure.</option>';
                    }
                    ?>
                </select>
                <input type="hidden" name="id_proced" id="id_proced">
                <input type="hidden" name="dura_proced" id="dura_proced">
            </div>
            <div class="mb-3" style="display: none;">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo $_SESSION['id_cliente']; ?>">
            </div>

            <div class="mb-3">
                <label for="data" class="form-label">Data:</label>
                <input type="date" class="form-control" id="data" name="data" value="<?php echo !empty($postData['data']) ? $postData['data'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="time_from" class="form-label">Horário de início:</label>
                <select name="time_from" class="form-select" id="time_from" onchange="popularInputs2()">
                    <option selected disabled>Selecione um horário</option>
                    <?php
                    date_default_timezone_set('America/Sao_Paulo');
                    $hora_inicial_manha = strtotime('08:00');
                    $hora_final_manha = strtotime('12:00');
                    $hora_inicial_tarde = strtotime('13:00');
                    $hora_final_tarde = strtotime('19:00');

                    for ($hora = $hora_inicial_manha; $hora <= $hora_final_manha; $hora += 1800) { 
                        echo '<option value="' . date('H:i', $hora) . '"';
                        if (!empty($postData['time_from']) && $postData['time_from'] == date('H:i', $hora)) {
                            echo ' selected';
                        }
                        echo '>' . date('H:i', $hora) . '</option>';                                 
                    }

                    for ($hora = $hora_inicial_tarde; $hora <= $hora_final_tarde; $hora += 1800) { 
                        echo '<option value="' . date('H:i', $hora) . '"';
                        if (!empty($postData['time_from']) && $postData['time_from'] == date('H:i', $hora)) {
                            echo ' selected';
                        }
                        echo '>' . date('H:i', $hora) . '</option>';  
                    }
                    ?>
                </select>
                <input type="hidden" name="dura_proced2" id="dura_proced2">
            </div>
            <div class="mb-3">
                <label for="time_to" class="form-label">Horário de término:</label>
                <input type="text" name="time_toooo" class="form-control" id="time_toooo" value="" disabled>
                <input type="hidden" name="time_to" class="form-select" id="time_to" value="">
            </div>
            <button type="submit" id="button-agendar" name="button-agendar" class="btn btn-primary">Agendar</button>
        </form> 
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ebbcd8" fill-opacity="1" d="M0,64L48,58.7C96,53,192,43,288,74.7C384,107,480,181,576,181.3C672,181,768,107,864,96C960,85,1056,139,1152,149.3C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
    </div>
    <script>
        var select2 = document.getElementById("time_from");
        select2.disabled = true;

        function popularInputs() {
            var select = document.getElementById("procedimento");
            var selectedValue = select.value.split('|');
            var id_proced = document.getElementById("id_proced");    
            var dura_proced = document.getElementById("dura_proced");

            id_proced.value = selectedValue[0];
            dura_proced.value = selectedValue[1].trim();
            select2.disabled = false;
        }

        function timeStringToSeconds(timeString) {
            const parts = timeString.split(':');
            const hour = parseInt(parts[0], 10);
            const minutes = parseInt(parts[1], 10);
            return hour * 3600 + minutes * 60;
        }

        function secondsToTimeString(seconds) {
            const date = new Date(seconds * 1000);
            return date.toISOString().substr(11, 8);
        }

        function popularInputs2() {
            var time_from = document.getElementById("time_from").value;
            var dura_proced = document.getElementById("dura_proced").value;
            var time_to = document.getElementById("time_to");
            var time_toooo = document.getElementById("time_toooo");
            
            function timeStringToSeconds(timeString) {
                const parts = timeString.split(':');
                const hour = parseInt(parts[0], 10);
                const minutes = parseInt(parts[1], 10);
                const seconds = parseInt(parts[2] || 0, 10); 
                return hour * 3600 + minutes * 60 + seconds;
            }

            function secondsToTimeString(seconds) {
                const hours = Math.floor(seconds / 3600).toString().padStart(2, '0');
                const minutes = Math.floor((seconds % 3600) / 60).toString().padStart(2, '0');
                const secs = (seconds % 60).toString().padStart(2, '0');
                return `${hours}:${minutes}:${secs}`;
            }

            let startSeconds = timeStringToSeconds(time_from);
            let durationSeconds = timeStringToSeconds(dura_proced);

            let endSeconds = startSeconds + durationSeconds;

            time_to.value = secondsToTimeString(endSeconds);
            time_toooo.value = secondsToTimeString(endSeconds);
        }
    </script>
</body>
</html>
