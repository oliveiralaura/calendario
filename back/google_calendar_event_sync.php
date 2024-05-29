<?php
require_once 'dbconfig.php';
include_once 'GoogleCalendarApi.class.php';

$statusMsg = '';
$status = 'danger';

if (isset($_GET['code'])) {
    $GoogleCalendarApi = new GoogleCalendarApi();

    $event_id = $_SESSION['last_event_id'];

    if (!empty($event_id)) {
        $sqlQ = "SELECT * FROM events WHERE id = ?";
        $stmt = $db->prepare($sqlQ);
        $stmt->bind_param("i", $db_event_id);
        $db_event_id = $event_id;
        $stmt->execute();
        $result = $stmt->get_result();
        $eventData = $result->fetch_assoc();

        if (!empty($eventData)) {
            // Busca o nome e sobrenome do cliente correspondentes ao ID
            $client_id = $eventData['clientes_id_cliente'];
            $client_full_name = '';

            $sql_get_client_name = "SELECT CONCAT(nome_cliente, ' ', sobrenome_cliente) AS nome_completo FROM clientes WHERE id_cliente = ?";
            $stmt_get_client_name = $db->prepare($sql_get_client_name);
            $stmt_get_client_name->bind_param("i", $client_id);
            $stmt_get_client_name->execute();
            $stmt_get_client_name->bind_result($client_full_name);
            $stmt_get_client_name->fetch();
            $stmt_get_client_name->close();

            $procedure_id = $eventData['procedimentos_id_procedimento'];
            $procedure_name = '';
            $professional_id = '';

            $sql_get_procedure_name = "SELECT nome_procedimento, servicos.profissionais_id_profissional FROM procedimentos 
                                       JOIN servicos ON procedimentos.servicos_id_servicos = servicos.id_servicos 
                                       WHERE id_procedimento = ?";
            $stmt_get_procedure_name = $db->prepare($sql_get_procedure_name);
            $stmt_get_procedure_name->bind_param("i", $procedure_id);
            $stmt_get_procedure_name->execute();
            $stmt_get_procedure_name->bind_result($procedure_name, $professional_id);
            $stmt_get_procedure_name->fetch();
            $stmt_get_procedure_name->close();

            if (!empty($client_full_name)) {
                // Verifica se já existe um evento na mesma hora e com o mesmo profissional
                $sqlCheck = "SELECT * FROM events 
                             JOIN procedimentos ON events.procedimentos_id_procedimento = procedimentos.id_procedimento 
                             JOIN servicos ON procedimentos.servicos_id_servicos = servicos.id_servicos 
                             WHERE events.date = ? 
                             AND ((events.time_from >= ? AND events.time_from < ?) 
                             OR (events.time_to > ? AND events.time_to <= ?)) 
                             AND servicos.profissionais_id_profissional = ? 
                             AND events.id != ?";
                $stmtCheck = $db->prepare($sqlCheck);
                $stmtCheck->bind_param("ssssssi", 
                                       $eventData['date'], 
                                       $eventData['time_from'], 
                                       $eventData['time_to'], 
                                       $eventData['time_from'], 
                                       $eventData['time_to'], 
                                       $professional_id, 
                                       $event_id);
                $stmtCheck->execute();
                $resultCheck = $stmtCheck->get_result();

                if ($resultCheck->num_rows > 0) {
                    $existingEvent = $resultCheck->fetch_assoc();
                    $statusMsg = 'Já existe um evento na mesma hora para o mesmo profissional:<br>';
                    $statusMsg .= 'Título: ' . $existingEvent['procedimentos_id_procedimento'] . '<br>';
                    $statusMsg .= 'Data: ' . $existingEvent['date'] . '<br>';
                    $statusMsg .= 'Hora de Início: ' . $existingEvent['time_from'] . '<br>';
                    $statusMsg .= 'Hora de Término: ' . $existingEvent['time_to'] . '<br>';
                } else {
                    $calendar_event = array(
                        'summary' => $procedure_name,
                        'description' => $client_full_name
                    );
                    $event_datetime = array(
                        'event_date' => $eventData['date'],
                        'start_time' => $eventData['time_from'],
                        'end_time' => $eventData['time_to']
                    );

                    $access_token = null;

                    if (isset($_SESSION['google_access_token'])) {
                        $access_token = $_SESSION['google_access_token'];
                    } else {
                        $data = $GoogleCalendarApi->GetAccessToken(GOOGLE_CLIENT_ID, REDIRECT_URI, GOOGLE_CLIENT_SECRET, $_GET['code']);
                        $access_token = $data['access_token'];
                        $_SESSION['google_access_token'] = $access_token;
                    }

                    if (!empty($access_token)) {
                        try {
                            $user_timezone = $GoogleCalendarApi->GetUserCalendarTimezone($access_token);
                            $google_event_id = $GoogleCalendarApi->CreateCalendarEvent($access_token, 'primary', $calendar_event, 0, $event_datetime, $user_timezone);
                            if ($google_event_id) {
                                $sqlQ = 'UPDATE events set google_calendar_event_id=? where id=?';
                                $stmt = $db->prepare($sqlQ);
                                $stmt->bind_param("si", $db_google_event_id, $db_event_id);
                                $db_google_event_id = $google_event_id;
                                $db_event_id = $event_id;
                                $update = $stmt->execute();

                                unset($_SESSION['last_event_id']);
                                unset($_SESSION['google_access_token']);

                                $sql_get_procedure_value = "SELECT valor_procedimento FROM procedimentos WHERE id_procedimento = ?";
                                $stmt_get_procedure_value = $db->prepare($sql_get_procedure_value);
                                $stmt_get_procedure_value->bind_param("i", $procedure_id);
                                $stmt_get_procedure_value->execute();
                                $stmt_get_procedure_value->bind_result($procedure_value);
                                $stmt_get_procedure_value->fetch();
                                $stmt_get_procedure_value->close();

                                $status = 'success';
                                $statusMsg = 'Agendamento concluído com sucesso:<br>';
                                $statusMsg .= 'Procedimento: ' . $calendar_event['summary'] . '<br>';
                                $statusMsg .= 'Data: ' . $event_datetime['event_date'] . '<br>';
                                $statusMsg .= 'Hora de Início: ' . $event_datetime['start_time'] . '<br>';
                                $statusMsg .= 'Hora de Término: ' . $event_datetime['end_time'] . '<br>';
                                $statusMsg .= 'Valor: ' . $procedure_value . '<br>';
                            }
                        } catch (Exception $e) {
                            $statusMsg = $e->getMessage();
                        }
                    } else {
                        $statusMsg = 'Falha ao obter o token de acesso!';
                    }
                }
            } else {
                $statusMsg = 'Falha ao buscar o nome completo do cliente correspondente!';
            }
        } else {
            $statusMsg = 'Dados do evento não encontrados.';
        }
    } else {
        $statusMsg = 'Referência de evento não encontrada.';
    }

    $_SESSION['status_response'] = array('status' => $status, 'status_msg' => $statusMsg);
    header('Location: ../finalizado.php');
    exit();
}

?>