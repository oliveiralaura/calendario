<?php

require_once 'dbconfig.php';

$postData = $statusMsg = $valErr = '';
$status = 'danger';

if (isset($_POST['button-agendar'])) {
    $_SESSION['postData'] = $_POST;
    $procedimento = !empty($_POST['procedimento']) ? trim($_POST['procedimento']) : '';
    $cliente = !empty($_POST['nome']) ? trim($_POST['nome']) : '';
    $date = !empty($_POST['data']) ? trim($_POST['data']) : '';   
    $time_from = !empty($_POST['time_from']) ? trim($_POST['time_from']) : '';
    $time_to = !empty($_POST['time_to']) ? trim($_POST['time_to']) : '';

    if (empty($procedimento)) {
        $valErr .= 'Please enter event procedimento.<br/>';
    }
    if (empty($date)) {
        $valErr .= 'Please enter event date.<br/>';
    }

    if (empty($valErr)) {
        $sqlQ = "INSERT INTO `events` (`id`, `date`, `time_from`, `time_to`, `google_calendar_event_id`, `created`, `procedimentos_id_procedimento`, `clientes_id_cliente`) 
                 VALUES (NULL, ?, ?, ?, NULL, NOW(), ?, ?)";
        $stmt = $db->prepare($sqlQ);
        
        if ($stmt) {
            $stmt->bind_param("sssss", $date, $time_from, $time_to, $procedimento, $cliente);

            $insert = $stmt->execute();

            if ($insert) {
                $event_id = $stmt->insert_id;
                unset($_SESSION['postData']);
                $_SESSION['last_event_id'] = $event_id;

                header("Location: $googleOauthURL");
                exit();
            } else {
                $statusMsg = 'Something went wrong, please try again after some time.';
            }
            $stmt->close();
        } else {
            $statusMsg = 'Failed to prepare the SQL statement.';
        }
    } else {
        $statusMsg = '<p>Please fill all the mandatory fields:</p>' . $valErr;
    }
} else {
    $statusMsg = 'Form submission failed!';
}

$_SESSION['status_response'] = array('status' => $status, 'status_msg' => $statusMsg);
header('Location: ../agendar.php');
exit();
?>
