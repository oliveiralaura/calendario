<?php
    require_once('../../back/dbconfig.php');

    if (!isset($_SESSION['email']) || !in_array($_SESSION['user_level'], ['admin', 'master'])) {
        header('Location: ../../login.php');
        exit();
    }

    date_default_timezone_set('America/Sao_Paulo');

    if(isset($_GET['day'], $_GET['month'], $_GET['year'])) {
        $selectedDay = $_GET['day'];
        $selectedMonth = $_GET['month'];
        $selectedYear = $_GET['year'];
        $realDay = "$selectedYear-$selectedMonth-$selectedDay";
        $formattedDay = "$selectedDay/$selectedMonth/$selectedYear";

        $sql = "SELECT * FROM eventoAdmin WHERE date = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('s', $realDay);
        $stmt->execute();
        $result_day = $stmt->get_result();

        $dados_day = [];
        if ($result_day && $result_day->num_rows > 0) {
            while ($user = $result_day->fetch_assoc()) {
                $dados_day[] = [
                    'date' => $user['date'],
                    'time_from' => $user['time_from'],
                    'time_to' => $user['time_to'],
                    'nome_procedimento' => $user['nome_procedimento'],
                    'nome_cliente' => $user['nome_cliente'],
                    'nome_profissional' => $user['nome_profissional'],
                    'nome_servico' => $user['nome_servico'],
                    'sobrenome_cliente' => $user['sobrenome_cliente']
                ];
            }
        } else {
            $dados_day = null;
        }
        $stmt->close();
    } else {
        echo 'Nenhum dia selecionado.';
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Dia</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .details-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .event {
            padding: 10px;
            margin-bottom: 15px;
            border-left: 5px solid #007bff;
            background-color: #f3f5f7;
            border-radius: 3px;
        }
        .event strong {
            color: #007bff;
        }
        .event p {
            margin: 0;
        }
       
        .navbar a {
            color: #fff;
        }
    </style>
    <script>
        setInterval(function() {
            location.reload();
        }, 50000); 
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="index.php">Voltar para calendário</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="details-container">
    <?php
        $currentHour = date("H:i");
        echo "<h4>$formattedDay - $currentHour</h4>";
        $currentHourNumeric = date('H');

        if ($dados_day !== null) {
            for ($hour = 8; $hour <= 21; $hour++) {
                if ($selectedDay == date('d') && $selectedMonth == date('m') && $selectedYear == date('Y') && $hour <= $currentHourNumeric) {
                    continue;
                }
                
                $event_found = false;
                foreach ($dados_day as $info) {
                    if (intval(substr($info['time_from'], 0, 2)) == $hour) {
                        echo "<div class='event'>";
                        echo "<strong>{$info['time_from']} às {$info['time_to']}</strong><br>";
                        echo "Procedimento: {$info['nome_procedimento']}<br>";
                        echo "Profissional: {$info['nome_profissional']}<br>";
                        echo "Serviço: {$info['nome_servico']}<br>";
                        echo "Cliente: {$info['nome_cliente']} {$info['sobrenome_cliente']}";
                        echo "</div>";
                        $event_found = true;
                        break; 
                    }
                }

                if (!$event_found) {
                    echo "<div class='event'>";
                    echo "<strong>{$hour}:00</strong><br>";
                    echo "Nenhum agendamento marcado.";
                    echo "</div>";
                }
            }
        } else {
            echo "<p>Nenhum agendamento</p>";
        }
    ?>
</div>
</body>
</html>
