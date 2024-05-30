<?php
    session_start();

    if (!isset($_SESSION['email']) || $_SESSION['user_level'] !== 'admin' && $_SESSION['user_level'] !== 'master') {
        header('Location: ../../login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: #fff; /* Cor de fundo da barra de navegação */
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #000!important; /* Cor dos links na barra de navegação */
        }
        .calendar {
            margin-top: 20px;
        }
        .calendar table {
            width: 100%;
        }
        .calendar th, .calendar td {
            text-align: center;
        }
        .calendar .btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Olá, seja bem-vindo(a)</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../listcadastros/listprocede.php">Procedimentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../listcadastros/listprofissa.php">Profissionais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../listcadastros/listservices.php">Serviços</a>
                    </li>
                    <?php if ($_SESSION['user_level'] === 'master'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../listcadastros/listusers.php">Usuários</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.php">Site</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Calendário</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../backadmin/sair.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="calendar">
                    <div class="d-flex justify-content-between mb-3">
                        <button id="prevMonthBtn" class="btn btn-primary">Mês Anterior</button>
                        <h2 id="currentMonth">Maio 2024</h2>
                        <button id="nextMonthBtn" class="btn btn-primary">Próximo Mês</button>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>D</th>
                                <th>S</th>
                                <th>T</th>
                                <th>Q</th>
                                <th>Q</th>
                                <th>S</th>
                                <th>S</th>
                            </tr>
                        </thead>
                        <tbody id="calendarBody">
                            <!-- Os dias do calendário serão gerados aqui -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const prevMonthBtn = document.getElementById('prevMonthBtn');
            const nextMonthBtn = document.getElementById('nextMonthBtn');
            const currentMonthText = document.getElementById('currentMonth');
            const calendarBody = document.getElementById('calendarBody');

            let currentMonth = 5; // Maio
            let currentYear = 2024;

            renderCalendar(currentMonth, currentYear);

            prevMonthBtn.addEventListener('click', function() {
                currentMonth--;
                if (currentMonth < 1) {
                    currentMonth = 12;
                    currentYear--;
                }
                renderCalendar(currentMonth, currentYear);
            });

            nextMonthBtn.addEventListener('click', function() {
                currentMonth++;
                if (currentMonth > 12) {
                    currentMonth = 1;
                    currentYear++;
                }
                renderCalendar(currentMonth, currentYear);
            });

            function renderCalendar(month, year) {
                currentMonthText.textContent = `${getMonthName(month)} ${year}`;
                calendarBody.innerHTML = ''; // Limpa o conteúdo atual do corpo do calendário

                const daysInMonth = new Date(year, month, 0).getDate();
                const firstDay = new Date(year, month - 1, 1).getDay();

                let currentDay = 1;
                for (let i = 0; i < 6; i++) {
                    const row = document.createElement('tr');
                    for (let j = 0; j < 7; j++) {
                        if ((i === 0 && j < firstDay) || currentDay > daysInMonth) {
                            row.innerHTML += '<td></td>';
                        } else {
                            row.innerHTML += `<td class="calendar-day" data-day="${currentDay}" data-month="${month}" data-year="${year}">${currentDay}</td>`;
                            currentDay++;
                        }
                    }
                    calendarBody.appendChild(row);
                    if (currentDay > daysInMonth) break;
                }

                // Adiciona o evento de clique aos dias do calendário
                document.querySelectorAll('.calendar-day').forEach(day => {
                    day.addEventListener('click', function() {
                        const selectedDay = this.getAttribute('data-day');
                        const selectedMonth = this.getAttribute('data-month');
                        const selectedYear = this.getAttribute('data-year');
                        window.location.href = `details.php?day=${selectedDay}&month=${selectedMonth}&year=${selectedYear}`;
                    });
                });
            }

            function getMonthName(month) {
                const monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
                return monthNames[month - 1];
            }
        });
    </script>
</body>
</html>
