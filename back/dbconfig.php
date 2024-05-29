    <?php

    require_once 'config.php';

    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB_NAME);
    
    if($db->connect_error){
        die("Connection failed: ". $db->connect_error);
    }
